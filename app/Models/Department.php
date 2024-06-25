<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stuff_id',


    ];
    public $timestamps = false;






      public function users(){
        return $this->hasMany(User::class);

    }
}
