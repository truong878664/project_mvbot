<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Groups extends Model
{
    use HasFactory;

    protected $table = 'groups';

    public function users() {
        return $this->hasMany(User::class, 'group_id', 'id'); 
    }

    public function postBy() {
        return $this->beLongsTo(User::class, 'user_id', 'id');
    }
}
