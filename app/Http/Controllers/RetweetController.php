<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRetweetRequest;
use App\Retweet;
use Illuminate\Support\Facades\Redis;

class RetweetController extends Controller
{
    private $connection;

    public function __construct(Retweet $retweet)
    {
        $this->connection = $retweet->connection();
    }

    public function index()
    {
        return view('retweets.index');
    }

    public function store(CreateRetweetRequest $request, Retweet $retweet)
    {

        $id = $request->tweet_id();
        $redis = Redis::Connection();
        $cached = false;

        //Check if Already In database else call API

        if ($redis->exists($id . '_followers') && $redis->exists($id . '_total')) {
            $total_retweeters = $redis->get($id . '_total');
            $followers_retweeters = $redis->get($id . '_followers');
            $cached = true;

        } else {
            //Get tweet author screen name
            $response = $this->connection->get("statuses/show/{$id}");

            //Check if a valid tweet URL
            if (!empty($response->errors)) {
                return back()->withInput()->withErrors([
                    __('twitter.invalid_url')
                ]);
            }

            if ($this->connection->getLastHttpCode() == 200) {
                $followers_all = $this->connection->get("followers/ids", [
                    'screen_name' => $response->user->screen_name
                ]);
            }

            if ($this->connection->getLastHttpCode() == 200) {
                $retweeters = $this->connection->get("statuses/retweeters/ids", [
                    'id' => $id
                ]);

                $total_retweeters = count($retweeters->ids);
            }

            if ($this->connection->getLastHttpCode() == 200) {
                $followers_retweeters = array_intersect($followers_all->ids, $retweeters->ids);
                $followers_retweeters = count($followers_retweeters);
            }
            //Save redis database for 2 hours
            if ($this->connection->getLastHttpCode() == 200) {
                $redis->setEx($id . '_followers', 7200, $followers_retweeters);
                $redis->setEx($id . '_total', 7200, $total_retweeters);
            } else {
                return back()->withInput()->withErrors([__('twitter.connection_failed')]);
            }
        }
        $data = [
            'total_retweeters' => $total_retweeters,
            'followers_retweeters' => $followers_retweeters,
            'cached' => $cached
        ];
        return view('retweets.index', compact('data'));
    }
}
