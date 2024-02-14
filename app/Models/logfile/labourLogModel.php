<?php

namespace App\Models\logfile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labourLogModel extends Model
{
    use HasFactory;

    protected $table = 'activity_log';
    protected $primaryKey="id";
    protected $fillable = [
       'log_name',
       'description',
       'subject_type',
       'event',
       'subject_id',
       'causer_type',
       'causer_id',
       'properties',
       'batch_uuid',
    ];
}
