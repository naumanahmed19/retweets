<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

class Retweet extends Model
{
    public function connection(){
        return new TwitterOAuth(
            config('services.twitter.consumer_key'),
            config('services.twitter.consumer_secret'),
            config('services.twitter.access_token'),
            config('services.twitter.access_token_secret'));
    }

    public function response(){
        return $this->connection->getLastHttpCode() == 200;
    }
}
