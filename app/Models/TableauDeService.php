<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TableauDeService extends Model
{

        use HasFactory;

        // Définir les champs remplissables
        protected $fillable = [
            'user_id',
            'quart_id',
            'heure_debut',
            'heure_fin',
            'week',
            'date_service',
        ];

        // Définir des valeurs par défaut pour heure_debut, heure_fin et week dans boot()
        protected static function boot()
        {
            parent::boot();

            static::creating(function ($tableauDeService) {
                // Définir les valeurs par défaut si elles ne sont pas spécifiées
                if (empty($tableauDeService->heure_debut)) {
                    $tableauDeService->heure_debut = json_encode(['00H', '06H', '13H', '20H']);
                }
                if (empty($tableauDeService->heure_fin)) {
                    $tableauDeService->heure_fin = json_encode(['06H', '13H', '20H', '24H']);
                }
                if (empty($tableauDeService->week)) {
                    $tableauDeService->week = json_encode(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']);
                }
            });
        }
    }
