<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Points;

class StepsMissions extends Model
{
    use HasFactory;
    protected $table = 'steps_missions'; 

    // public function points() {
    //     return $this->hasMany(Points::class, 'group_mission', 'id');
    // }
}
