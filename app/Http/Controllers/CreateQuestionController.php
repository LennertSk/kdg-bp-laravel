<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Survey;
use App\Option;

class CreateQuestionController extends Controller
{
    /**
     * Show the question creation page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $survey = session('survey');
        if (isset($survey)) {
            return view('question-1');   
        } else {
            return redirect('/');
        }
    }

    /**
     * Check user input and save question to session
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function question(Request $request)
    {
        $userInput = $request->validate(
            [
            'question' => 'required|min:4|max:120',
            'url' => 'required|min:4|max:50|unique:questions,url'
            ],
            [
            'question.min' => 'The :attribute should have at least 4 characters',
            'question.max' => 'The :attribute should not be longer than 50 characters',
            'question.required' => 'The :attribute can not be blank.',
            'url.min' => 'The :attribute should have at least 4 characters',
            'url.max' => 'The :attribute should not be longer than 50 characters',
            'url.required' => 'The :attribute can not be blank.'
            ]
        );


        $question = ['question' => $userInput['question'], 'url' => $userInput['url']];
        session()->put('question', $question);
        return redirect('/add-question/info');
    }

    /**
     * Show the question info page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function questionInfo()
    {
        $survey = session('survey');
        $question = session('question');
        if (isset($survey)) {
            return view('question-2', compact('question'));   
        } else {
            return redirect('/');
        }
    }

    /**
     * Check user input and save question info to session
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function questionInfoSet(Request $request)
    {
        $userInput = $request->validate(
            [
            'answer' => 'required|min:4|max:250',
            'tip' => 'nullable|min:4|max:250'
            ],
            [
            'answer.min' => 'The :attribute should have at least 4 characters',
            'answer.max' => 'The :attribute should not be longer than 250 characters',
            'answer.required' => 'The :attribute can not be blank.',
            'tip.min' => 'The :attribute should have at least 4 characters',
            'tip.max' => 'The :attribute should not be longer than 250 characters',
            ]
        );
        
        $question = session('question');
        $question['answer'] = $userInput['answer'];
        $question['hint'] = $userInput['tip'];
        session()->put('question', $question);

        return view('question-3');   
    }

    /**
     * Show the question type page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function questionType($id)
    {
        $survey = session('survey');
        $question = session('question');

        if (isset($survey) && isset($question)) {
            return view('question-' . $id);   
        } else {
            return redirect('/');
        }
    }

    /**
     * Check user input and save question to db
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function addSelect(Request $request)
    {
        $hasNoAnswer = $request->input('openQuestion');
        $amountOptions = $request->input('quantity');
        $type = $request->input('type');

        if ($hasNoAnswer) {
            $input = $request->validate(
                [
                    'optionA' => 'required|min:1|max:150',
                    'optionB' => 'required|min:1|max:150',
                    'optionC' => 'nullable|min:1|max:150'
                ]
                );
        } else {
            $input = $request->validate(
                [
                    'answerWrong' => 'required|min:3|max:150',
                    'optionA' => 'required|min:1|max:150',
                    'optionB' => 'required|min:1|max:150',
                    'optionC' => 'nullable|min:1|max:150',
                    'correct' => 'required'
                ]
                );
        }
        
        $survey = session('survey');
        $question = session('question');
        $survey = Survey::where('survey_code', '=', $survey['code'])->first();

        if (isset($input['correct'])) {
            $correct_oid = $input['correct'];
            $answer_wrong = $input['answerWrong'];
        } else {
            $correct_oid = null;
            $answer_wrong = null;
        }

        /* 
        * Save question without correct option id for now.
        */
        $newQuestion = new Question;
        $newQuestion->question = $question['question'];
        $newQuestion->survey_id = $survey['survey_id'];
        $newQuestion->option_id = null;
        $newQuestion->url = $question['url'];
        $newQuestion->type = $type;
        $newQuestion->text_hint = $question['hint'];
        $newQuestion->text_answer = $question['answer'];
        $newQuestion->text_wrong = $answer_wrong;
        $newQuestion->timestamps = false;
        $newQuestion->save();

        /* 
        * Get questin id (qid) back from db
        */

        $newQuestionId = Question::where('url', '=', $question['url'])->first();
        $qid = $newQuestionId['question_id'];

        /* 
        * Save options to db
        */

        $newOption = new Option;
        $newOption->question_id = $qid;
        $newOption->option = $input['optionA'];
        $newOption->option_answered = 0;
        $newOption->save();

        $newOption = new Option;
        $newOption->question_id = $qid;
        $newOption->option = $input['optionB'];
        $newOption->option_answered = 0;
        $newOption->save();

        if ( $amountOptions == 3) {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionC'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        /* 
        * If question has answer,
        * Get correct option back from db so we can update question with correct option id (oid)
        */
        if (!$hasNoAnswer) {

            if ($correct_oid == 1) {
                $correctOption = Option::where('option', '=', $input['optionA'])->first();   
            } elseif ($correct_oid == 2) {
                $correctOption = Option::where('option', '=', $input['optionB'])->first();  
            } else {
                $correctOption = Option::where('option', '=', $input['optionC'])->first();  
            }
            
            $oid = $correctOption['option_id'];

            Question::where('question_id', '=', $qid)
                ->update(['option_id' => $oid]);
        }
        return redirect('/dashboard');

    }

    /**
     * Check user input and save question to db
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function addRange(Request $request) {
        $hasNoAnswer = $request->input('openQuestion');
        $amountOptions = $request->input('quantity');
        $type = $request->input('type');

        if ($hasNoAnswer) {
            $input = $request->validate(
                [
                    'optionA' => 'required|min:1|max:150',
                    'optionB' => 'required|min:1|max:150',
                    'optionC' => 'nullable|min:1|max:150',
                    'optionD' => 'nullable|min:1|max:150',
                    'optionE' => 'nullable|min:1|max:150',
                    'optionF' => 'nullable|min:1|max:150',
                    'optionG' => 'nullable|min:1|max:150',
                    'optionH' => 'nullable|min:1|max:150',
                    'optionI' => 'nullable|min:1|max:150',
                    'optionJ' => 'nullable|min:1|max:150'
                ]
                );
        } else {
            $input = $request->validate(
                [
                    'answerWrong' => 'required|min:3|max:150',
                    'optionA' => 'required|min:1|max:150',
                    'optionB' => 'required|min:1|max:150',
                    'optionC' => 'nullable|min:1|max:150',
                    'optionD' => 'nullable|min:1|max:150',
                    'optionE' => 'nullable|min:1|max:150',
                    'optionF' => 'nullable|min:1|max:150',
                    'optionG' => 'nullable|min:1|max:150',
                    'optionH' => 'nullable|min:1|max:150',
                    'optionI' => 'nullable|min:1|max:150',
                    'optionJ' => 'nullable|min:1|max:150',
                    'correct' => 'required'
                ]
                );
        }

        $survey = session('survey');
        $question = session('question');
        $survey = Survey::where('survey_code', '=', $survey['code'])->first();

        if (isset($input['correct'])) {
            $correct_oid = $input['correct'];
            $answer_wrong = $input['answerWrong'];
        } else {
            $correct_oid = null;
            $answer_wrong = null;
        }

        /* 
        * Save question without correct option id for now.
        */
        $newQuestion = new Question;
        $newQuestion->question = $question['question'];
        $newQuestion->survey_id = $survey['survey_id'];
        $newQuestion->option_id = null;
        $newQuestion->url = $question['url'];
        $newQuestion->type = $type;
        $newQuestion->text_hint = $question['hint'];
        $newQuestion->text_answer = $question['answer'];
        $newQuestion->text_wrong = $answer_wrong;
        $newQuestion->timestamps = false;
        $newQuestion->save();

        /* 
        * Get questin id (qid) back from db
        */

        $newQuestionId = Question::where('url', '=', $question['url'])->first();
        $qid = $newQuestionId['question_id'];

        /* 
        * Save options to db
        */

        $newOption = new Option;
        $newOption->question_id = $qid;
        $newOption->option = $input['optionA'];
        $newOption->option_answered = 0;
        $newOption->save();

        $newOption = new Option;
        $newOption->question_id = $qid;
        $newOption->option = $input['optionB'];
        $newOption->option_answered = 0;
        $newOption->save();

        

        if ( $amountOptions >= '3') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionC'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '4') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionD'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '5') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionE'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '6') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionF'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '7') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionG'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '8') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionH'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '9') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionI'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if ( $amountOptions >= '10') {
            $newOption = new Option;
            $newOption->question_id = $qid;
            $newOption->option = $input['optionJ'];
            $newOption->option_answered = 0;
            $newOption->save();
        }

        if (!$hasNoAnswer) {

            if ($correct_oid == 1) {
                $correctOption = Option::where('option', '=', $input['optionA'])->first();   
            } elseif ($correct_oid == 2) {
                $correctOption = Option::where('option', '=', $input['optionB'])->first();  
            }  elseif ($correct_oid == 3) {
                $correctOption = Option::where('option', '=', $input['optionC'])->first();  
            } elseif ($correct_oid == 4) {
                $correctOption = Option::where('option', '=', $input['optionD'])->first();  
            } elseif ($correct_oid == 5) {
                $correctOption = Option::where('option', '=', $input['optionE'])->first();  
            } elseif ($correct_oid == 6) {
                $correctOption = Option::where('option', '=', $input['optionF'])->first();  
            } elseif ($correct_oid == 7) {
                $correctOption = Option::where('option', '=', $input['optionG'])->first();  
            } elseif ($correct_oid == 8) {
                $correctOption = Option::where('option', '=', $input['optionH'])->first();  
            } elseif ($correct_oid == 9) {
                $correctOption = Option::where('option', '=', $input['optionI'])->first();  
            } else {
                $correctOption = Option::where('option', '=', $input['optionJ'])->first();  
            }
            
            $oid = $correctOption['option_id'];

            Question::where('question_id', '=', $qid)
                ->update(['option_id' => $oid]);
        }
        return redirect('/dashboard');

    }
}