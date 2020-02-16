<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;

class PollsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $poll_id, $slug)
    {
        $poll = Poll::where('id', '=', $poll_id)
            ->whereSlug($slug)
            ->firstOrFail();

        //logged user
        $user = $request->user();

        if ($poll->hasVoted($user->id)) {
            toastr()->info('Você já votou nesta enquete. Aqui estão os resultados.', 'Enquete');
            return redirect()->route('site.poll.results', ['id' => $poll->id, 'slug' => $poll->slug]);
        }

        //increment views
        $poll->increment('views');

        return view('site.polls.poll', compact('poll'));
    }

    public function vote(Request $request, $poll_id, $slug)
    {
        $poll = Poll::whereSlug($slug)->findOrFail($poll_id);

        $user = $request->user();

        if ($poll->hasVoted($user->id)) {
            toastr()->info('Você já votou nesta enquete. Aqui estão os resultados.', 'Enquete');
            return redirect()->route('site.poll.results', ['id' => $poll->id, 'slug' => $poll->slug]);
        }

        $options = $request->input('option');

        if (is_array($options)) {
            foreach ($options as $key => $option) {
                Vote::create([
                    'poll_id' => $poll->id,
                    'option_id' => $option,
                    'user_id' => $user->id
                ]);
            }
        } else {
            Vote::create([
                'poll_id' => $poll->id,
                'option_id' => $options,
                'user_id' => $user->id
            ]);
        }

        toastr()->info('O seu voto foi computado.', 'Enquete');
        return redirect()->route('site.poll.results', [$poll->id, $poll->slug]);
    }

    public function result($poll_id, $slug)
    {
        $poll = Poll::where('id', '=', $poll_id)
            ->whereSlug($slug)
            ->firstOrFail();

        $totalVotes = $poll->totalVotes();

        return view('site.polls.result', compact('poll', 'totalVotes'));
    }
}
