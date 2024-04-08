<?php

namespace App\Models\Labours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabourModel extends Model
{
    use HasFactory;
    protected $table = 'labour';
    protected $primaryKey="labour_id";
    protected $fillable = [
        'labour_number',
        'labour_code',
        'labour_name',
        'labour_company',
        'labour_agent',
        'labour_date_create',
        'labour_nationality',
        'labour_sex',
        'labour_birth_date',
        'labour_passport_number',
        'labour_passport_date_start',
        'labour_passport_date_end',
        'labour_passport_run_date',
        'labour_visa_number',
        'labour_visa_date_start',
        'labour_visa_date_end',
        'labour_visa_run_date',
        'labour_work_permit_number',
        'labour_work_permit_date_start',
        'labour_work_permit_date_end',
        'labour_work_permit_run_date',
        'labour_ninety_date_start',
        'labour_ninety_date_end',
        'labour_work',
        'labour_work_date',
        'labour_escape',
        'labour_escape_date',
        'labour_resign',
        'labour_resign_date',
        'labour_installment',
        'labour_note',
        'labour_user_add',
        'labour_user_edit',
        'labour_department',
        'labour_visa_date_start01',
        'labour_visa_date_end01',
        'labour_visa_date_start02',
        'labour_visa_date_end02',
        'labour_work_permit_date_start01',
        'labour_work_permit_date_end01',
        'labour_work_permit_date_start02',
        'labour_work_permit_date_end02',
        'labour_TM_province',
        'labour_status',
        'labour_immigration_number',
        'labour_textid',
        'import_id',
        'labour_passport_company_manage',
        'labour_visa_company_manage',
        'labour_work_permit_company_manage',
        'labour_ninety_company_manage',
    ];
        
}
