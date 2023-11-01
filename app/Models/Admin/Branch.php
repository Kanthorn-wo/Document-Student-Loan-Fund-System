<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'faculty_id',
        'branch_name',
        'branch_code',

    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
