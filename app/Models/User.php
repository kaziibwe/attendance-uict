<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

        'date_appointed',
        'salary_scale',
        'salary_amount',
        'allowances',
        'gross_pay',
        'education',
        'netpay',
        'duty',
        'first_appointment',
        'date_first_appointment',
        'appointment_staff',
        'appointment_status',

    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');

    }


    public function attendances(){
        return $this->hasMany(Attendance::class);

    }

    public function Appointments(){
        return $this->hasMany(Appointment::class);

    }
}
