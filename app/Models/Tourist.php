<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tourist extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'qr_code',
        'first_name',
        'last_name',
        'date_of_birth',
        'address',
        'gender',
        'nationality',
        'photo_url',
        'contact_number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}