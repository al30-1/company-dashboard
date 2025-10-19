<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubmodule extends Model
{
    use HasFactory;

    protected $table = 'user_submodule';

    protected $fillable = ['user_id', 'submodule_id', 'granted_at', 'created_by'];
}