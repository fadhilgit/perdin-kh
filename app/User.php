<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'unitkerja_id',
        'subunitkerja_id',
        'position_id',
        'secondposition_id',
        'phone_number',
        'initial',
        'signature',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    function position()
    {
        return $this->belongsTo(Position::class);
    }

    function secondposition()
    {
        return $this->belongsTo(SecondPosition::class);
    }

    function unitkerja()
    {
        return $this->belongsTo(Unitkerja::class);
    }
    function subunitkerja()
    {
        return $this->belongsTo(Subunitkerja::class);
    }

    function perdinRecipient()
    {
        return $this->hasMany(PerdinRecipient::class, 'user_id');
    }
}
