<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Qna;

class QnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return response()->json(['qnas'=>Qna::orderBy('id', 'ASC')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qna = new Qna();
        $qna->user_id = 'test';
        $qna->title = $request->title;
        $qna->question = $request->question;
        $qna->view = 0;

        $qna->save();
        
        return response()->json(['msg'=>"Success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $qna = Qna::where('id', $id)->first();
        $added_view = $qna->view + 1;
        $qna->update(['view' => $added_view]);
        $qna->save();
        return response()->json(['qna'=>$qna->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $qna = Qna::where('id', $id)->first();
        $qna->update(['title' => $request->title, 'question' => $request->question]);
        $qna->save();
        return response()->json(['msg'=>"Success"]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qna = new Qna();
        $qna->find($id)->delete();

        return response()->json(['msg'=>"Success"]);
    }
}
