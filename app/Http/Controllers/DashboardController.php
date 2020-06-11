<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Survey;
use App\Question;
use App\Option;

class DashboardController extends Controller
{
    /**
     * Check if user is logged in and show the Dashboard input page
     * Or reroute to login page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $session = session('survey');
        if (!isset($session)) {
            return view('login');
        }

        $survey = Survey::where('survey_code', '=', $session['code'])->first();
        $questions = Question::where('survey_id', '=', $survey['survey_id'])->get();

        return view('dashboard', compact('survey','questions'),['questionAmount' => count($questions)]
        );  
    }

    /**
     * Check user input and reroute if user has an account
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function login(Request $request)
    {
        $userInput = $request->validate(
            [
            'code' => 'required|exists:surveys,survey_code',
            'password' => 'required'
            ],
            [
            'code.exists' => 'We could not find a survey with that :attribute',
            'code.required' => 'The :attribute can not be blank.',
            'password.required' => 'The :attribute can not be blank.'
            ]
        );
        $survey = Survey::where('survey_code', '=', $userInput['code'])->first();

        if (!Hash::check($userInput['password'], $survey->password)) {
            throw ValidationException::withMessages(['password' => 'This password is incorrect.']);
        } 

        $session = [
            'title' => $survey['survey_name'],
            'code' => $survey['survey_code'],
            'desc' => $survey['description'],
            'user' => $survey['created_by']
        ];
        
        session()->put('survey', $session);
        return redirect('/dashboard');
    }

    /**
     * CShow question info page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function question($id)
    {
        $session = session('survey');
        if (!isset($session)) {
            return view('login');
        } else {
            
            $question = Question::where('url', '=', $id)->first();
            $survey = Survey::where('survey_id', '=', $question['survey_id'])->first();
            if ($session['code'] == $survey['survey_code']) {
                $options = Option::where('question_id', '=', $question['question_id'])->get();
                return view('question', compact('question', 'options'));  
            } else {
                return redirect('/dashboard');
            }
        }
    }

    /**
     * Remove question
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function remove($id)
    {
    
        Question::where('question_id', '=', $id)->delete();
        Option::where('question_id', '=', $id)->delete();

        return redirect('/dashboard');
    }
}
