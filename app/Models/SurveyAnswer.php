<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table    = 'survey_answers';
    public $timestamps  = true;
    protected $fillable = [
        'survey_id',
        'question_id',
        'answer',
        'user_id'
    ];
    protected $casts = [
        'answer'     => 'json',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
