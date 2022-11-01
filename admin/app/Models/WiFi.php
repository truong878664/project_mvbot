<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StatusRobots;

class WiFi extends Model
{
    use HasFactory;

    protected $table = 'table_wifi';

    public function robot() {
        return $this->belongsTo(StatusRobots::class);
    }
}
