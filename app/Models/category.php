<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = ['name'];

    public function materis()
    {
        return $this->hasMany(materi::class);
    }
}
