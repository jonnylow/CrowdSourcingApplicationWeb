<?php

namespace App\Http\Controllers\Ranks;

use Illuminate\Http\Request;

use App\Http\Requests\RankRequest;
use App\Http\Controllers\Controller;
use App\Rank;
use JsValidator;

/**
 * Resource controller that handles the logic when managing ranks.
 *
 * @package App\Http\Controllers\Ranks
 */
class RankController extends Controller
{
    /**
     * Show the form to manage the ranks.
     * Responds to requests to GET /rank
     *
     * @return Response
     */
    public function index()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\RankRequest');

        $ranks = Rank::all();

        return view('ranks.manage', compact('validator', 'ranks'));
    }

    /**
     * Update an rank.
     * Responds to requests to PATCH /rank
     *
     * @param  \App\Http\Requests\RankRequest  $request
     * @return Response
     */
    public function update(RankRequest $request)
    {
        $currentRank1 = Rank::where('rank', 1)->first();
        $currentRank2 = Rank::where('rank', 2)->first();
        $currentRank3 = Rank::where('rank', 3)->first();
        $currentRank4 = Rank::where('rank', 4)->first();

        $currentRank1->update([
            'min' => $request->get('rank_1'),
        ]);

        $currentRank2->update([
            'min' => $request->get('rank_2'),
            'max' => $request->get('rank_1') - 1,
        ]);

        $currentRank3->update([
            'min' => $request->get('rank_3'),
            'max' => $request->get('rank_2') - 1,
        ]);

        $currentRank4->update([
            'max' => $request->get('rank_3') - 1,
        ]);

        return back()->with('success', 'Ranks are updated successfully!');
    }
}
