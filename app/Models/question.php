<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'correct_option_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
    public function correctOption()
    {
        return $this->belongsTo(question_option::class, 'correct_option_id');
    }
    public function options()
    {
        return $this->hasMany(question_option::class);
    }
    public function answers()
    {
        return $this->hasMany(answer::class);
    }




}
