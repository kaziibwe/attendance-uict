<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(Department::class, 'user_id');
    }

    protected $fillable = [
        'user_id',
        'status',
        'singin',
        'signout',
    ];
    public $timestamps = false;
}
