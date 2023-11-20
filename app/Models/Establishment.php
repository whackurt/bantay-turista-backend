<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city_municipality',
        'barangay',
        'address_1',
        'contact_number',
        'owner_name',
        'owner_email',
        'owner_phone',
        'photo_url',
        'type_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(EstablishmentType::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}