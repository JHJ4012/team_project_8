<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Info_program;
use App\User;
use Symfony\Component\HttpFoundation\Session\Session;

class JapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['japans'=>Info_program::get()]);
    }
    // public function formSubmit(Request $request){
    //     return response()->json([$request->all()]);
    // }
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
        $imageName=time().'.'.$request->image->guessExtension();
        $request->image->move(public_path('images'), $imageName);
        $japan = new Info_program();
        $japan->week=$request->week;
        $japan->image=$imageName;
        $japan->title=$request->title;

        $info_br = str_replace("<br/>", "\r\n", $request->info);    //띄어쓰기 문제 때문에
        $japan->info=$info_br;

        $japan->save();
        return response()->json(['msg'=>'만들기 성공!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $japans=new Info_program();
        $session = new Session();
        $user = $session->get('user');
        $getUser = User::where('user_id',$user)->value('admin');
        return response()->json(['japans'=>Info_program::where('week', $id)->get(), 'user' => $getUser]);
    }
    public function modifyShow($id)
    {
        $japans=new Info_program();
        // return response()->json(['msg'=>"업데이트 성공!"]);
    
        return response()->json(['japans'=>Info_program::where('id', $id)->get()]);
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
        $japan = Info_program::find($id);


        if($request->image == $japan->image){

            $japan->week=$request->week;
            $japan->image=$request->image;
            $japan->title=$request->title;
            $japan->info=$request->info;

            $japan->save();

            return response()->json(['msg'=>'Update 성공! 내용']);
        }
        
        $imageName=time().'.'.$request->image->guessExtension();
        $request->image->move(public_path('images'), $imageName);

        // $image_path = public_path('images').'/'.$request->image;
        // File::delete($image_path);

        $request_modify = $request;
        $request_modify->image = $imageName;

        $japan->week=$request_modify->week;
        $japan->image=$imageName;
        $japan->title=$request_modify->title;
        $japan->info=$request_modify->info;
        
        $japan->save();
        return response()->json(['msg'=>'Update 성공! 내용, 이미지 변경']);
        
      
        

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Info_program::destroy($id);
        return response()->json(['msg'=>'Destroy 성공!']);
    }
}
