<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\User;
use Illuminate\Support\Facades\Auth;
use File;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $member_info = $request->member_info;
        $image = $request->image;
        $user_name = $request->user_name;

        $imagename = time().'.'.$request->image->getClientOriginalExtension();  
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
        $validatedData = $request->validate([
            'member_info' => 'required|string',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);
        if ($validator->fails())
        {
            return response()->json(['error' => $validator->errors()->getMessages()], 400);
        }
        $members = new Member;
        $users = new User;

        $member_info = $request->member_info;
        $image = $request->image;
        
        $user_id = $users->where('name', $user_name)->get('id');
        $member = $members->where('user_id', $user_id[0]->id)->get();

        $image_path = public_path('images').'/'.$member[0]->imagename;

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        if($image == '없음' && $member_info == '없음') {
            return response()->json('success');
        } 
        else if($image == '없음' && $member_info){
            Member::with('user')->where('user_id',$user_id[0]->id)->update([
                'member_info'=>$member_info,
            ]);

            return response()->json('success');
        }
        else if($image && $member_info == '없음') {
            $imagename = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imagename);

            Member::with('user')->where('user_id',$user_id[0]->id)->update([
                'imagename'=>$imagename,
            ]);

            return response()->json('success');
        }   
        else {
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