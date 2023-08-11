<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = ['tourist_id', 'description', 'response', 'resolved'];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }
}