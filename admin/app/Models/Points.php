<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StatusRobots;
use App\Models\GroupsMissions;

class Points extends Model
{
    use HasFactory;
    protected $table = 'points';

    public function robot() {
        return $this->belongsTo(StatusRobots::class);
    }

    // public function mission() {
    //     return $this->belongsTo(GroupsMissions::class);
    // }
}
