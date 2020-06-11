<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;

class HomepageController extends Controller
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // Get top ranked surveys
        $getSurveys = Survey::orderby('ratingPerc', 'desc')->paginate(3);
        $surveys = [];
        foreach ($getSurveys as $survey) {
            $survey = [
                'title' => $survey->survey_name,
                'desc' => $survey->description,
                'createdBy' => $survey->created_by,
                'code' => $survey->survey_code
            ];
            array_push($surveys, $survey);
        }
        return view('index',  compact('surveys'));
    }
}
