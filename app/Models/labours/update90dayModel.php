<?php

namespace App\Models\labours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class update90dayModel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = '90days';
    protected $primaryKey="ninety_id";
    protected $fillable = [
        'labour_id',
        'labour_passport',
        'ninety_date_start',
        'ninety_date_end',
        'ninety_user_add',
        'ninety_note',

    ];
}
