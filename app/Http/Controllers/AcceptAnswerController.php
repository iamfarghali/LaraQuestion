<?php

namespace App\Http\Controllers;

use App\Answer;

class AcceptAnswerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke ( Answer $answer )
    {
        $this->authorize( 'accept', $answer );
        $answer->question->acceptBestAnswer( $answer );
        if ( request()->expectsJson() ) {
            return response()->json( ['message' => 'The answer marked as the best answer'], 200 );
        }
        return back()->with( 'success', 'The answer marked as the best answer' );
    }
}
