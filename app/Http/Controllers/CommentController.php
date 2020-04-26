<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request)
    {
        try {
            DB::beginTransaction();
            $commentObj = new Comment;
            $commentObj->uuid = Str::random(36);
            $commentObj->subject = $request->get('subject');
            $commentObj->comment = $request->get('comment');
            $commentObj->candidate_id = $request->get('candidate_id');
            $commentObj->rating = $request->get('rating');
            $commentObj->created_by = \Auth::user()->id;
            $response = $commentObj->save();
            unset($commentObj);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return Redirect::back()->with('error', $e->getMessage());
        }
        
        $candidate = \App\Candidate::where('id', $request->get('candidate_id'))->first();
        $commentRatingCount = \App\Comment::where('created_by', \Auth::user()->id)
            ->where('candidate_id', $candidate->id)
            ->whereNotNull('rating')
            ->count();
        return view('comments.view', ['candidate' => $candidate, 'ratingIsExist' => $commentRatingCount]);
    }

}
