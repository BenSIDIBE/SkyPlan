<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_tableauService',
        'heure_debut',
        'heure_fin',
        'date_service',
    ];

    public function tableauService()
    {
        return $this->belongsTo(TableauService::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
