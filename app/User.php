<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions ()
    {
        return $this->hasMany( 'App\Question' );
    }

    public function answers ()
    {
        return $this->hasMany( 'App\Answer' );
    }

    public function getUrlAttribute ()
    {
        return '#';
    }

    public function getAvatarAttribute ()
    {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function favorites ()
    {
        return $this->belongsToMany( Question::class, 'favorites' );
    }

    public function voteQuestions ()
    {
        return $this->morphedByMany( Question::class, 'votable' );
    }

    public function voteAnswers ()
    {
        return $this->morphedByMany( Answer::class, 'votable' );
    }

    public function voteQuestion ( Question $question, $vote )
    {
        $voteQuestionsRel = $this->voteQuestions();
        $this->_vote( $voteQuestionsRel, $question, $vote );
    }

    public function voteAnswer ( Answer $answer, $vote )
    {
        $voteAnswersRel = $this->voteAnswers();
        $this->_vote( $voteAnswersRel, $answer, $vote );
    }

    private function _vote ( $relationship, $model, $vote )
    {
        if ( $relationship->where( 'votable_id', $model->id )->exists() ) {
            $relationship->updateExistingPivot( $model, [ 'vote' => $vote ] );
        } else {
            $relationship->attach( $model, [ 'vote' => $vote ] );
        }
        $model->load( 'votes' );
        $downVotes = (int)$model->downVote()->sum( 'vote' );
        $upVotes = (int)$model->upVote()->sum( 'vote' );
        $model->votes_count = $upVotes + $downVotes;
        $model->save();
    }
}
