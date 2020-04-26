<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\StoreCandidateRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource with the search condition.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Candidate $candidate)
    {
        if ($request->has('q')) {
            $query = $candidate->where('name', $request->input('q'))
                ->orWhere('email', 'like', '%' . $request->input('q') . '%')
                ->orWhere('web_address', 'like', '%' . $request->input('q') . '%')
                ->orWhere('cover_letter', 'like', '%' . $request->input('q') . '%')
                ->orWhere('location', 'like', '%' . $request->input('q') . '%');
            $candidates = $query->orderBy('updated_at')->get();
            return view('candidates.search', ['candidates' => $candidates]);
        } else {
            $candidates = Candidate::orderBy('updated_at')->get();
        }

        return view('candidates.index', ['candidates' => $candidates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidates.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidateRequest $request)
    {
        $ip = file_get_contents('https://api.ipify.org');
        $ipDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        try {
            $resumeFilePath = $request->file('resume')->store('public', ['disk' => 'public_uploads']);
            DB::beginTransaction();
            $candidateObj = new Candidate;
            $candidateObj->uuid = Str::random(36);
            $candidateObj->name = $request->get('name');
            $candidateObj->email = $request->get('email');
            $candidateObj->web_address = $request->get('web_address');
            $candidateObj->cover_letter = $request->get('cover_letter');
            $candidateObj->is_working = $request->get('is_working');
            $candidateObj->visitor = $ip;
            $candidateObj->location = $ipDetails->city;
            $candidateObj->resume_path = $resumeFilePath;
            $candidateObj->save();
            unset($candidateObj);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return Redirect::back()->with('error', $e->getMessage());
        }
        return Redirect::back()->with('message', 'Candidate is created a successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $candidate = Candidate::where('uuid', $uuid)->first();
        $commentRatingCount = \App\Comment::where('created_by', \Auth::user()->id)
            ->where('candidate_id', $candidate->id)
            ->whereNotNull('rating')
            ->count();
        $ratingAvg = \App\Comment::where('candidate_id', $candidate->id)
            ->whereNotNull('rating')
            ->select(\DB::raw('AVG( rating ) as rating_avg'))
            ->get();
        return view('candidates.model', ['candidate' => $candidate, 'ratingIsExist' => $commentRatingCount, 'avgRating' => ceil($ratingAvg[0]->rating_avg)]);
    }

}
