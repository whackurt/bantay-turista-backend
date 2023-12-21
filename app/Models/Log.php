<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['qr_code', 'date_time', 'tourist_id', 'establishment_id'];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}