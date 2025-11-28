<?php

namespace App\Models;
use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table    = 'surveys';
    public $timestamps  = true;
    protected $fillable = [
        'id', 'organization_id', 'user_id',
        'title', 'description', 'start_date', 'end_date', 'is_anonymous',
        'created_at', 'updated_at','token'
    ];
    protected $casts = [
    ];

    /**
     * RelationShip
     *
     * This method allows access to questions related to a survey:
     * $survey->questions all return the associated SurveyQuestion.
     */
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

}
