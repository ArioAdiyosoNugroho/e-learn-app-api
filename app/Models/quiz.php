<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class quiz extends Model
{
    protected $fillable = [
        'title',
        'guru_id',
        'materi_id',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function materi()
    {
        return $this->belongsTo(materi::class,'materi_id');
    }

    public function questions()
    {
        return $this->hasMany(question::class);
    }
    public function results()
    {
        return $this->hasMany(result::class);
    }
}
