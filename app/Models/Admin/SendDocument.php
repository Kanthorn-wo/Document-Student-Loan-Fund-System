<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'img',
        'amount',
        'type_loan',
        'term',
        'year',
        'status',
        'user_id',
        'comment',
        'updated_at',
        'faculty_id'
    ];

    public function filedocument()
    {
        return $this->belongsTo(FileDocument::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}