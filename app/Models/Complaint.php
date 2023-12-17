<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'involved_establishment_id',
        'date_of_incident', 
        'description', 
        'response', 
        'tourist_id',  
        'resolved'
    ];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }
}