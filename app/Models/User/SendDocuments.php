<?php

namespace App\Models\User;

use App\Models\Admin\Faculty;
use App\Models\Admin\FileDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendDocuments extends Model
{
    use HasFactory;
    protected $fillable = [
        'img',
        'amount',
        'type_loan',
        'year',
        'term',
        'status',
        'comment',
        'updated_at',
        'faculty_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function filedocument()
    {
        return $this->belongsTo(FileDocument::class, 'file_document_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}