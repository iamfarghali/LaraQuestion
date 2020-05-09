<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store ( Question $question, Request $request )
    {
        $question->answers()->create( $request->validate( [ 'body' => 'required' ] ) + [ 'user_id' => auth()->user()->id ] );
        return back()->with( 'success', 'Your answer has been submitted successfully.' );
    }

    public function edit ( Question $question, Answer $answer )
    {
        $this->authorize( 'update', $answer );
        return view( 'answers.edit', [ 'question' => $question, 'answer' => $answer ] );
    }

    public function update ( Request $request, Question $question, Answer $answer )
    {
        $this->authorize( 'update', $answer );
        $answer->update( $request->validate( [ 'body' => 'required' ] ) );
        return redirect()->route( 'questions.show', $question->slug )->with( 'success', 'Your answer has been updated successfully.' );
    }

    public function destroy ( Question $question, Answer $answer )
    {
        $this->authorize( 'delete', $answer );
        $answer->delete();
        return back()->with( 'success', 'Your answer has been deleted successfully.' );
    }
}
