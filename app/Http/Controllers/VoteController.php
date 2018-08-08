<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use App\TypeVote;
use App\ItemVoting;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeVotes = TypeVote::all();
        $votes = Vote::count();
        return view('vote.index', compact('typeVotes', 'votes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeVotes = TypeVote::all();
        return view('vote.create', compact('typeVotes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $vote = new Vote();
        $vote->cpf = $data['cpf'];
        if ($vote->save()) {
            foreach ($data['itemvote'] as $item) {
                $itemVote = new ItemVoting();
                $itemVote->vote_id = $vote->id;
                $itemVote->type_vote_id = $item;
                $itemVote->save();
            }
        }
        return redirect(route('votes.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
