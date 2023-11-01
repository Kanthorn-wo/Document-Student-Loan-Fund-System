<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $fillable = [
        'faculty_code',
        'faculty_name',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
