<?php

namespace App\Models\labours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressLabourModel extends Model
{
    use HasFactory;
    protected $table = 'address_labour';
    protected $primaryKey="addr_id";
    protected $fillable = [
        'labour_id',
        'labour_passport',
        'addr_number',
        'addr_province',
        'addr_amphur',
        'addr_distict',
        'addr_zipcode',
        'addr_note',
        'addr_user_add',
        'addr_user_update',
        'addr_status',
    ];
}
