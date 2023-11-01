<?php

namespace App\Models\Admin;

use App\Models\Admins;
use App\Models\User\SendDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject',
        'note',
        'admin_id',
        'status',
    ];
    public function admin()
    {
        return $this->hasOne(Admins::class, 'id', 'admin_id');
    }
    public function senddocuments()
    {
        return $this->hasMany(SendDocuments::class, );
        // return $this->hasMany(SendDocuments::class, 'id', 'file_document_id ');
    }
}
