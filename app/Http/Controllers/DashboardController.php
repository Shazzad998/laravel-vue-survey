<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyAnswerResource;
use App\Http\Resources\SurveyResourceDashboard;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        //Total Number of Surveys
        $totalSurveys = Survey::query()->where('user_id', $user->id)->count();

        //Latest Survey
        $latestSurvey = Survey::query()->where('user_id', $user->id)->latest('created_at')->first();

        //Total Number of Answers
        $totalAnswers = SurveyAnswer::query()
            ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
            ->where('surveys.user_id', $user->id)
            ->count();

        //Latest 5 Answers
        $latestAnswers = SurveyAnswer::query()
        ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
        ->where('surveys.user_id', $user->id)
        ->latest('end_date')
        ->limit(5)
        ->getModels('survey_answers.*');



        return [
            'totalSurveys' => $totalSurveys,
            'latestSurvey' => $latestSurvey? new SurveyResourceDashboard($latestSurvey) : null,
            'totalAnswers' => $totalAnswers,
            'latestAnswers' => SurveyAnswerResource::collection($latestAnswers)
        ];
    }
}
