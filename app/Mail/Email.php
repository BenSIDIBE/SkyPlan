<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $donnees;
    public $variables;

    public function __construct($donnees, $variables)
    {
        $this->donnees = $donnees;
        $this->variables = $variables;

    }
   

    public function attachments(): array
    {
        return [];
    }
    

    public function build()
    {
        $pdf = Pdf::loadView('emails.test',['variables' => $this->variables])->setPaper('A4', 'landscape');
        
        return $this->subject($this->donnees['title'])
            ->view('pdf.invioice', [
            'message' => $this->donnees['body'] . "\n\nMerci pour votre confiance." // Adding a message to the body with a thank you note
            ])
            ->attachData($pdf->output(), 'Service_du_' . $this->donnees['start_date'] . '_au_' . $this->donnees['end_date'] . '.pdf', [
            'mime' => 'application/pdf',
            ]);

           
            
    }
}
