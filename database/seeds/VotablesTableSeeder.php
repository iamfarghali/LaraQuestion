<?php

use App\Question;
use App\User;
use Illuminate\Database\Seeder;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        \DB::table( 'votables' )->delete();

        $users = User::all();
        $users_count = $users->count();
        $votes = [ -1, 1 ];

        foreach ( Question::all() as $q ) {
            for ( $i = 0; $i < rand( 1, $users_count ); $i++ ) {
                $users[ $i ]->voteQuestion( $q, $votes[ rand( 0, 1 ) ] );
            }
        }
    }
}
