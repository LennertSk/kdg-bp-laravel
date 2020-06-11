<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Option;
use App\Http\Resources\Survey as SurveyResource;
use App\Http\Requests;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get surveys
        $surveys = Survey::all();

        // Return as resource
        return SurveyResource::collection($surveys);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get question
        $survey = Survey::where('survey_code', '=', $id)->firstOrFail();

        // Return question as resource
        return new SurveyResource($survey);
    }

    /**
     * Update the rating of the specified survey
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rating(Request $request, $id, $value)
    {
        $survey = Survey::where('survey_code', '=', $id)->firstOrFail();
        $rating = $survey->rating;
        $amount_rated = $survey->amount_rated;
        switch ($value) {
        case 0:
            $rating = $rating + 0;
            break;
        case 100:
            $rating = $rating + 1;
            break;
        case 200:
            $rating = $rating + 2;
            break;
        case 300:
            $rating = $rating + 3;
            break;
        case 400:
            $rating = $rating + 4;
            break;
        default:
            return 'Something went wrong';
        }
        $amount_rated++;
        $rating_percent = $rating / $amount_rated;
        $rating_percent = ceil($rating_percent);
        
        Survey::where('survey_code', '=', $id)->update(['rating' => $rating, 'amount_rated' => $amount_rated, 'ratingPerc' => $rating_percent]);
        return 'Survey rating has been successfully updated';
    }


    /**
     * Update the rating of the specified survey
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function answer(Request $request, $oid)
    {
        Option::where('option_id', '=', $oid)->increment('option_answered');
        return 'Survey rating has been successfully updated';
    }
}
