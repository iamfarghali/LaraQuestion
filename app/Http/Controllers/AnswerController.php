<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct ()
    {
        $this->middleware( 'auth' )->except( 'index' );
    }

    public function index ( Question $question )
    {
        return $question->answers()->with( 'user' )->simplePaginate( 2 );
    }

    public function store ( Question $question, Request $request )
    {
        $answer = $question->answers()->create( $request->validate( [ 'body' => 'required' ] ) + [ 'user_id' => auth()->user()->id ] );
        if ( $request->expectsJson() ) {
            return response()->json( [
                'message' => 'Your answer has been submitted successfully.',
                'answer'  => $answer->load( 'user' )
            ] );
        }
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
        if ( $request->expectsJson() ) {
            return response()->json( [
                'message' => 'Your answer has been updated successfully.',
                'answer'  => $answer,
            ] );
        }
        return redirect()->route( 'questions.show', $question->slug )->with( 'success', 'Your answer has been updated successfully.' );
    }

    public function destroy ( Question $question, Answer $answer )
    {
        $this->authorize( 'delete', $answer );
        $answer->delete();
        if ( request()->expectsJson() ) {
            return response()->json( [
                'message' => 'Your answer has been deleted successfully.'
            ] );
        }
        return back()->with( 'success', 'Your answer has been deleted successfully.' );
    }
}
