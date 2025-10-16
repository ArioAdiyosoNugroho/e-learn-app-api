<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class question_option extends Model
{
    protected $fillable = [
        'question_id',
        'option_label',
        'option_text',
    ];

    public function question()
    {
        return $this->belongsTo(question::class);
    }
    public function answers()
    {
        return $this->hasMany(answer::class,'option_id');
    }
}
