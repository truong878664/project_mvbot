<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WiFi;
use App\Models\Points;

class StatusRobots extends Model
{
    use HasFactory;

    protected $table = 'robot_status'; 

    public function table_wifi() {
        return $this->hasMany(WiFi::class, 'robot_id', 'id');
    }

    public function points() {
        return $this->hasMany(Points::class, 'robot_id', 'id');
    }
}
