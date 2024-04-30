<?php

namespace App\Models\labours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class filesModel extends Model
{
    use HasFactory;
    protected $table = 'file';
    protected $primaryKey="file_id";
    protected $fillable = [
        'labour_id',
        'files_type',
        'file_path',
    ];
}
