<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}