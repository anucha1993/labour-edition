<?php

namespace App\Models\importGroup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class importGroupModel extends Model
{
    use HasFactory;
    protected $table = 'import';
    protected $primaryKey="import_id";
    protected $fillable = [
        'import_name',
        'import_user_add',
        'import_user_edit',
    ];
}
