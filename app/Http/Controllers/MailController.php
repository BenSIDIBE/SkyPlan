<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Service;
use App\Models\User;
use App\Models\TableauService;
use App\Models\Poste;

    

class MailController extends Controller

{  public $semaine;
    public $jour_ferie = [];
    public $technicien_absent = [];
    public $permanence_tech = "";
    public $commandant_permanence = "";
    public $listeDate = [];  

    /**

     * Write code on Method

     *

     * @return response()

     */
    

     


    public function send( $id_tableauService  )

    { //dd($id_tableauService);

        $this->tableauService = TableauService::findOrFail((int)$id_tableauService);
        $Services = Service::where('id_tableauService', $id_tableauService)->get();         
       // dd($this->tableauService->data);
       $commandant_permanence = $this->tableauService->data['commandant_permanence'];
       $permanence_tech = $this->tableauService->data['permanence_tech'];
       $this->jours_feries = $this->tableauService->data['jour_ferie'];
       $this->technicien_absent = $this->tableauService->data['technicien_absent']; 

        // Récupérer la date actuelle
        $lundi_semaine_suivante = $this->tableauService->date_debut;
       

        $this->id_tableauService= \App\Models\TableauService::where('date_debut', $lundi_semaine_suivante->format('Y-m-d'))
            ->value('id');

        $this->jours = [
            'Lundi' => $lundi_semaine_suivante->format('d-m-Y'),
            'Mardi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Mercredi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Jeudi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Vendredi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Samedi' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
            'Dimanche' => $lundi_semaine_suivante->addDay()->format('d-m-Y'),
        ];
       // dd($this->jours['Dimanche']);
        $posteSurveillanceId = Poste::where('nom', 'Technicien de surveillance')->value('id');
        $posteMaintenanceId = Poste::where('nom', 'Technicien de maintenance')->value('id');

        $surveillants = User::where('poste_id', $posteSurveillanceId)->get();
        $techniciens_maintenance = User::where('poste_id', $posteMaintenanceId)->get();

        $techniciens_maintenance = $techniciens_maintenance->diff($surveillants);
        $this->surveillants = $surveillants->toQuery()->whereNotIn('id',$this->tableauService->data["technicien_absent"])->get();

        $techniciens_maintenance = $techniciens_maintenance->take(3 - $surveillants->count());                
            
            //dd($Services, $commandant_permanence, $permanence_tech, $this->jours_feries, $this->technicien_absent, $this->surveillants, $techniciens_maintenance);

      $variables = [
            'commandant_permanence' => $commandant_permanence,
            'permanence_tech' => $permanence_tech,
            'jours_feries' => $this->jours_feries,
            'technicien_absent' => $this->technicien_absent,
            'surveillants' => $this->surveillants,
            'techniciens_maintenance' => $techniciens_maintenance,
            'services' => $Services,
            'jours' => $this->jours,
        ];

        $Data = [

            'title' => 'Du Chef de service',

            'body' => 'Bonjour, Vous êtes concerné par une programmation cette semaine.',
             'start_date' => $this->jours['Lundi'],
            'end_date' => $this->jours['Dimanche'],

        ];

       // $pdf = PDF::loadView('emails.test'/*, $Data*/)->setPaper('A4', 'landscape');
       // $pdfContent = $pdf->output();

        /*$users = \App\Models\User::all(); // Assuming you have a User model
        foreach ($users as $user) {
            Mail::to($user->email)->send(new Email($Data));
        }*/
        Mail::to('bencompteweb@gmail.com')->send(new Email($Data, $variables));


       /* $mailData= [
            'pdf_content' => $pdfContent,
        ];*/

       // dd("L'email a été envoyé avec succès.");
        //return view('emails.test', $mailData);
        return redirect()->route('dashboard')->with('success', "L'email a été e nvoyé avec succès.");
    }

}