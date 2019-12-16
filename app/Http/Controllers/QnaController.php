<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Qna;
use App\Reply;
use Auth;
use App\User;
use Symfony\Component\HttpFoundation\Session\Session;

class QnaController extends Controller
{

    public function index()
    {
        return Qna::latest()->paginate(5);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        debug($request->control);
        $session = new Session();
        if($request->control == 'qna'){ //qna 만들 때
            $qna = new Qna();
            $qna->user_id = $session->get('user');
            $qna->title = $request->title;
            $qna->question = $request->question;
            $qna->view = 0;
    
            $qna->save();
            
            return response()->json(['msg'=>"Success"]);
        }
        elseif($request->control == 'reply'){   //댓글 만들때
            $reply = new Reply();
            $reply->qna_id = $request->qna_id;
            $reply->user_id = $session->get('user');
            $reply->reply = $request->reply;
    
            $reply->save();
            
            return response()->json(['reply'=>Reply::where('qna_id',$request->qna_id)->get()]);
        }
        
    }

    public function show($id)   //QnAList에서 특정 질문 클릭했을 때 그 qna 객체와 그 qna에 속해있는 댓글들 리턴
    {
        $qna = new Qna();
        $added_view = $qna->find($id)->view + 1;    //조회수 증가시키기 위함.
        $qna->find($id)->update(['view' => $added_view]);
        $session = new Session();
        $userId = $session->get('user');
        return response()->json(['qna'=>Qna::where('id',$id)->get(), 'reply'=>Reply::where('qna_id', $id)->get(), 'user'=> $userId, 'admin'=>User::where('user_id', $userId)->get()]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)   //수정 눌렀을 때.
    {
        $qna = new Qna();
        $qna->find($id)->update(['title' => $request->title, 'question' => $request->question]);
        return response()->json(['msg'=>"Success"]);
        
    }

    public function destroy($id) //삭제하기
    {
        $qna = new Qna();
        $qna->find($id)->delete();

        return response()->json(['msg'=>"Success"]);
    }
}
