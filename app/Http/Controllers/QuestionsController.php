<?php 

namespace App\Http\Controllers; 

use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
class QuestionsController extends Controller
{
    public function index()
    {
        $questions = SurveyQuestion::all();
        return response()->json($questions);
    }
}
