<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable=['model','des','pro_on','img','mf_id'];
    public function mf(){
        return $this->belongsTo(\App\Models\Mf::class);
    }

}
