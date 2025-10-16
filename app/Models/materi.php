<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class materi extends Model
{
    protected $fillable = [
        'title',
        'content',
        'file_url',
        'category_id',
        'guru_id',
    ];
    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    public function quizzes()
    {
        return $this->hasMany(quiz::class);
    }
}
