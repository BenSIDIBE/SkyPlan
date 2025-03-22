<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TableauService extends Model
{
    use HasFactory;

    protected $table = 'tableau_service'; // 🔹 Spécifier le nom correct de la table
    protected $fillable = [
        'date_debut',
        'date_fin',
        'week',
        'jour_ferie',
        'data',
    ];

    protected $casts = [
        'week' => 'array',
        'jour_ferie' => 'array',
        'data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            $lundiProchain = Carbon::now()->startOfWeek()->addWeek(); // Lundi prochain
            $dates = [];
            $joursSemaine = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
            $joursDeLaSemaine = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $lundiProchain->copy()->addDays($i)->toDateString();
                $dates[] = $date;
                $joursDeLaSemaine[] = $joursSemaine[$i]; // Ajouter le jour de la semaine en français
            }

            $service->date_debut = $dates[0]; // Lundi
            $service->date_fin = $dates[6]; // Dimanche
            $service->week = $joursDeLaSemaine; // Jours de la semaine en français
            $service->jour_ferie = []; // Vide au début
        });
    }
}
