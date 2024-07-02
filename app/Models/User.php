<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'sex',
        'lang_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'password' => 'hashed',
        ];
    }

    public function lang()
    {
        return $this->belongsTo(Lang::class, 'lang_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(function () {
            return $this->last_name . ' ' . $this->first_name;
        });
    }
}
