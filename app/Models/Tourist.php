<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}