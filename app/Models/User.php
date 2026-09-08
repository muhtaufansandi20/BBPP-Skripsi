<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['nip', 'name','e_mail', 'password', 'role', 'no_hp', 'jabatan','signature '];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Custom function to find the user by NIP.
     * 
     * @param  string $nip
     * @return \App\Models\User|null
     */
    public function findForPassport($nip)
    {
        return $this->where('nip', $nip)->first();
    }

    /**
     * Override the method to use NIP for authentication instead of email.
     */
    public function getAuthIdentifierName()
    {
        return 'nip'; // Use NIP as the identifier for authentication
    }

    /**
     * Override the method to use NIP for authentication instead of email.
     */
    public function getAuthIdentifier()
    {
        return $this->nip; // Return the NIP for authentication
    }



    public function timkerja()
    {
        return $this->belongsTo(Timkerja::class);
    }


    public function kuotaCutiTahunan()
    {
        return $this->hasOne(KuotaCutiTahunan::class)->latestOfMany();
    }



}
