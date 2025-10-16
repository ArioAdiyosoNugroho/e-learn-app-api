<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'option_id',
        'is_correct',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(question::class);
    }

    public function option()
    {
        return $this->belongsTo(question_option::class, 'option_id');
    }
}
