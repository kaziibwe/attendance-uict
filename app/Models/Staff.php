<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'department_id',
        'title',
        'email',
        'staff_number',
        'dob',
        'current_appointment',
        'appointment_date',
        'nin',
        'tin',
        'phone',
        'password',

    ];
    public $timestamps = false;
}
