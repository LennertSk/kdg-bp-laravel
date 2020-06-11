<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Option;

class Question extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $options = [];
        $optionsArr = Option::select('option', 'option_answered', 'option_id')->where('question_id', '=', $this->question_id)->get();
        foreach ($optionsArr as $option) {

            $isCorrect = false;
            if ($option->option_id === $this->option_id) {
                $isCorrect = true;
            }
            if ($this->option_id === null) {
                $isCorrect = true;
            }

            $option = [
                'oid' => $option->option_id,
                'option' => $option->option,
                'amount_answered' => $option->option_answered,
                'isCorrect' => $isCorrect
            ];
            array_push($options, $option);
        }
        
        return [
            'qid' => $this->question_id,
            'url' => $this->url,
            'question' => $this->question,
            'type' => $this->type,
            'info' => $this->text_info,
            'hint' => $this->text_hint,
            'answer' => $this->text_answer,
            'answer_wrong' => $this->text_wrong,
            'correct_option' => $this->option_id,
            'options' => $options
        ];
    }
}
