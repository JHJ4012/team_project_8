<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\User;
use Illuminate\Support\Facades\Auth;
use File;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $users = new User();
        $members = new Member();
        $session = new Session();

        $usercheck = $session->get('user') ? 1 : 0;
        if($usercheck) {
            $user_id = $session->get('user');
            $user = $users->where('user_id', $user_id)->get('name');
            $admin = $users->where('user_id', $user_id)->get('admin');
            $user_key = $users->where('user_id', $user_id)->get('id');
            $member = $members->where('user_id', $user_key[0]->id)->get();

            return response()->json(['member'=>Member::with('user')->orderBy('user_id', 'ASC')->get(), 'user_name'=>$user, 'admin'=>$admin, 'check'=>$member]);
        } else {
            return response()->json(['member'=>Member::with('user')->orderBy('user_id', 'ASC')->get()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_name)
    {
        $members = new Member;
        $users = new User;

        $user_id = $users->where('name', $user_name)->get('id');
        $member = $members->where('user_id', $user_id[0]->id)->get();

        return response()->json(['member'=>$member[0]]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('member_info','image'), [
            'member_info' => 'required',
            'image' => 'required'
        ], ['member_info.required'=>'내용','image.required'=>'이미지']);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $member_info = $request->member_info;
        $image = $request->image;
        $user_name = $request->user_name;

        $imagename = time().'.'.$request->image->getClientOriginalExtension();  //이미지 이름 지정
        $request->image->move(public_path('images'), $imagename);

        $user_id = User::where('name', $user_name)->get('id');

        $member = Member::with('user')->where('id',$user_id[0]->id)->create([
            'user_id'=>$user_id[0]->id,
            'member_info'=>$member_info,
            'imagename'=>$imagename,
        ]);

        return response()->json('success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_name)
    {
        $members = new Member;
        $users = new User;

        $member_info = $request->member_info;
        $image = $request->image;
        
        $user_id = $users->where('name', $user_name)->get('id');
        $member = $members->where('user_id', $user_id[0]->id)->get();

        $image_path = public_path('images').'/'.$member[0]->imagename;

        if($image == '없음' && $member_info == '없음') {    //변경 내용 없음
            return response()->json('success');
        } 
        else if($image == '없음' && $member_info){  // 소개만 변경
            Member::with('user')->where('user_id',$user_id[0]->id)->update([
                'member_info'=>$member_info,
            ]);

            return response()->json('success');
        }
        else if($image && $member_info == '없음') { //이미지만 변경
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $imagename = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imagename);
            //move 하는 이유 : 파일을 불러오면 그것이 메인메모리에 save 되는데 이것은 temp 임시 파일이여서
            //휘발성이다. 그래서 메인메모리에서 public 폴더로 옮겨줄 필요 있음

            Member::with('user')->where('user_id',$user_id[0]->id)->update([
                'imagename'=>$imagename,
            ]);

            return response()->json('success');
        }   
        else {  //모두 변경
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $imagename = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imagename);

            Member::with('user')->where('user_id',$user_id[0]->id)->update([
                'member_info'=>$member_info,
                'imagename'=>$imagename,
            ]);

            return response()->json('success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_name)
    {
        $members = new Member();
        $users = new User();

        $user_id = $users->where('name', $user_name)->get('id');
        $member = $members->where('user_id', $user_id[0]->id)->get();
        
        $image_path = public_path('images').'/'.$member[0]->imagename;

        if (File::exists($image_path)) { 
            File::delete($image_path);
        }

        $members->where('user_id', $user_id[0]->id)->delete();
        
        return response()->json(['member'=>Member::with('user')->orderBy('user_id', 'ASC')->get()]);
    }
}