<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Points;

class GroupsMissions extends Model
{
    use HasFactory;
    protected $table = 'groups_missions'; 

    // public function points() {
    //     return $this->hasMany(Points::class, 'group_mission', 'id');
    // }
}
