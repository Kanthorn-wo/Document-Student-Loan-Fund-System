<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatePicker extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'status',
    ];
}
