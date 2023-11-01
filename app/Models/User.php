<?php

namespace App\Models;

use App\Models\Admin\Branch;
use App\Models\Admin\Faculty;
use App\Models\User\SendDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'process',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function senddocuments()
    {
        return $this->hasMany(SendDocuments::class);

    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class);

    }

    public function branch()
    {
        return $this->hasOne(Branch::class);

    }
    public function faculties()
    {
        return $this->belongsTo(Faculty::class);
    }
}
