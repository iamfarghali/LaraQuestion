<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = [ 'title', 'body' ];

    public function user ()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function setTitleAttribute ( $value )
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug( $value );
    }

    public function getUrlAttribute ()
    {
        return route( 'questions.show', $this->slug );
    }

    public function getCreatedDateAttribute ()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute ()
    {
        if ( $this->answers_count > 0 ) {
            if ( !is_null( $this->best_answer_id ) ) {
                return 'best-answer';
            }
            return 'answered';
        }
        return 'unanswered';
    }

    public function answers ()
    {
        return $this->hasMany( 'App\Answer' );
    }

    public function getBodyHtmlAttribute ()
    {
        return clean( $this->bodyHtml() );
    }

    public function getExcerptAttribute ()
    {
        return \Str::words( strip_tags( $this->bodyHtml() ), 60, '...' );
    }

    public function acceptBestAnswer ( $answer )
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites ()
    {
        return $this->belongsToMany( User::class, 'favorites' );
    }

    public function getIsFavoritedAttribute ()
    {
        return $this->isFavorites();
    }

    public function getFavoritesCountAttribute ()
    {
        return $this->favorites->count();
    }

    public function isFavorites ()
    {
        return $this->favorites()->where( 'user_id', auth()->user()->id )->count() > 0;
    }

    private function bodyHtml ()
    {
        return \Parsedown::instance()->text( $this->body );
    }
}
