<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator,Redirect,Response;
use Session;
use Illuminate\Support\Facades\Hash;
use App\Survey;

class InputController extends Controller
{
    /**
     * Show the survey input page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('input');
    }

    /**
     * Store user input is session
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function set(Request $request)
    {
        $userInput = $request->validate([
            'title' => 'required|min:4|max:50',
            'code' => 'required|min:4|max:30|unique:surveys,survey_code',
            'description' => 'required|max:255',
            'username' => 'required|min:4',
            'password' => 'required|min:4|max:30'
            ],[
                'title.required' => 'The :attribute can not be blank.',
                'title.min' => 'The :attribute needs to be at least 4 characters long.',
                'title.max' => 'The :attribute needs to be less than 50 characters long.',
                'code.required' => 'The :attribute can not be blank.',
                'code.min' => 'Your :attribute needs to be at least 4 characters long.',
                'code.max' => 'Your :attribute needs to be less than 30 characters long.',
                'code.unique' => 'That code has already been taken.',
                'description.required' => 'The :attribute can not be blank.',
                'description.max' => 'The :attribute needs to be less than 255 characters long.',
                'username.required' => 'Your :attribute can not be blank.',
                'username.min' => 'Your :attribute needs to be at least 4 characters long.',
                'password.required' => 'The :attribute can not be blank.'
            ]);
        
        $sessionSurvey = Session::get('survey');

        if ($request->session()->has('survey')) {
            $request->session()->forget('survey');
        }
        $survey = [
            'title' => $userInput['title'],
            'code' => $userInput['code'],
            'desc' => $userInput['description'],
            'user' => $userInput['username']
        ];

        $newSurvey = new Survey;
        $newSurvey->survey_name = $survey['title'];
        $newSurvey->survey_code = $survey['code'];
        $newSurvey->description = $survey['desc'];
        $newSurvey->created_by = $survey['user'];
        $newSurvey->password = Hash::make($userInput['password']);
        $newSurvey->rating = 0;
        $newSurvey->amount_rated = 0;
        $newSurvey->save();

        session()->put('survey', $survey);
        
        return redirect('/dashboard');
    }
}
