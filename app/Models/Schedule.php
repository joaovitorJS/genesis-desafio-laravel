<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;


    protected $fillable = [
       "name",
       "cpf",
       "card_sus",
       "reason",
       "date_scheduling",
       "urgency",
       "doctor_name",
       "professional_name"
    ];
}
