<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Option;
use App\Question;

class Survey extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $questions = [];
        
        // Get questions related to survey id
        $questionsArr = Question::where('survey_id', '=', $this->survey_id)->get();

        foreach ( $questionsArr as $question ) {
            $questionArr = [
                'question_id' => $question->question_id,
                'question' => $question->question,
                'question_url' => $question->url
            ];
            array_push( $questions, $questionArr );
        }
        // return json with data, questions and options
        return [
            'id' => $this->survey_id,
            'name' => $this->survey_name,
            'description' => $this->description,
            'created_by' => $this->created_by,
            'code' => $this->survey_code,
            'rating' => $this->rating,
            'amount_rated' => $this->amount_rated,
            'created_at' => $this->created_at,
            'questions' => $questions
        ];
    }
}
