<?php

namespace App\Models\customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $primaryKey="company_id";
    protected $fillable = [
        "company_number",
        "company_name",
        "company_code" ,
        "company_surname",
        "company_lastname",
        "company_fax",
        "company_email",
        "company_tel",
        "company_authorized_surname_1",
        "company_authorized_lastname_1",
        "company_authorized_surname_2",
        "company_authorized_lastname_2",
        "company_authorized_surname_3" ,
        "company_authorized_lastname_3",
        "company_authorized_surname_4",
        "company_authorized_lastname_4",
        "company_authorized_surname_5" ,
        "company_authorized_lastname_5",
        "company_house_number" ,
        "company_area",
        "company_district",
        "company_province",
        "company_zipcode",
        "company_business_type",
        "company_coordinator" ,
        "company_note",
    ];
}
