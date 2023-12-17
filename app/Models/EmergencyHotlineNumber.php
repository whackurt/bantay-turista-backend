<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyHotlineNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'agencyName',
        'address',
        'hotlineNumber',
    ];
}
