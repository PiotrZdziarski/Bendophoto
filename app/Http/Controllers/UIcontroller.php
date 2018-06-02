<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cookie;
use Auth;
use App\Redirect;
use Illuminate\Support\Facades\Input;

class UIcontroller extends Controller
{
    public function addingpost()
    {
      return view('sites.addingpost');
    }

    public function addpost(Request $request)
    {
      $loggeduser = Auth::user()->name;
      $userid = Auth::user()->id;
      $description = $request->input('description');
      $type = $request->input('type');
      $date = now();

      $DBfollowers = DB::table('followers')->where('followingid', $userid)->get();
      DB::table('users')->where('id', $userid)->increment('posts');
      array_set($arrayfollowers, 'creator', 'siema');
      foreach($DBfollowers as $followers) {
        array_push($arrayfollowers, $followers->followerid);
      }
      unset($arrayfollowers['creator']);

      foreach($arrayfollowers as $follower) {
        $userchecker = DB::table('users')->where('id', $follower)->get();
        DB::table('users')->where('id', $follower)->increment('notifications');
        foreach($userchecker as $singlecheck) {
          $name = $singlecheck->name;
        }
        $notification = "$loggeduser added post!";
        $date = now();
        $DBposts = DB::table('posts')->take(1)->orderBy('id', 'desc')->get();
        foreach($DBposts as $post) {
          $postid = $post->id;
        }
        $realid = $postid += 1;
        DB::table('notifacations')->insert(['username' => $name,'text' => $notification, 'date' => $date, 'postid' => $realid, 'type' => $loggeduser]);
      }


      if(Input::hasFile('post')) {
        $file = Input::file('post');
        $filename = $file->getClientOriginalName();
        $file->move("storage/images/$loggeduser/", $file->getClientOriginalName());
      }

      DB::table('posts')->insert(['autorpost' => $loggeduser, 'post' => $filename, 'textpost' => $description,
      'date' => $date, 'likes' => 0, 'type' => $type]);

      return redirect('/')->with('addedpost', 'Post succesfully added!');
    }



    public function searching(Request $request, $lookingfor)
    {
      $result = DB::table('users')->take(50)->where('name', 'LIKE', "$lookingfor%")->orderBy('followers','desc')->get();
      array_set($array, 'siemnanko', 200);
      foreach($result as $onesearch) {
        if(isset($onesearch->name))
          array_push($array, $onesearch->name);
      }
      unset($array['siemanko']);
      return $array;
    }

    public function notifacationlink(Request $request)
    {
      $postid = $request->input('postid');
      return redirect('/')->with('showpost', $postid);
    }


    public function newpostlink(Request $request)
    {
      $postid = $request->input('postid');
      $authorpost = $request->input('authorpost');
      return redirect("/profile/$authorpost/")->with('showpost', $postid);
    }


    public function follow(Request $request)
    {
      $following = $request->input('following');
      $follower = $request->input('follower');

      DB::table('followers')->insert(['followingid' => $following, 'followerid' => $follower]);


      $DBfollowers = DB::table('users')->where('id', $follower)->get();
      foreach($DBfollowers as $onefollower){
        $followingcount = $onefollower->following;
      }
      $followingcount += 1;
      DB::table('users')->where('id', $follower)->update(['following' => $followingcount]);


      $DBfollowing = DB::table('users')->where('id', $following)->get();
      foreach($DBfollowing as $onefollowing){
        $followercount = $onefollowing->followers;
      }
      $followercount += 1;
      DB::table('users')->where('id', $following)->update(['followers' => $followercount]);




      return back();
    }


    public function notificationshow(Request $request)
    {
      $username = Auth::user()->name;
      $userid = Auth::user()->id;
      DB::table('notifacations')->where('showed', 0)->where('username', $username)->increment('showed');
      DB::table('users')->where('id', $userid)->update(['notifications' => 0]);
      return null;
    }



    public function unfollow(Request $request)
    {
      $following = $request->input('following');
      $follower = $request->input('follower');

      DB::table('followers')->where('followingid', $following)->where('followerid', $follower)->delete();


      $DBfollowers = DB::table('users')->where('id', $follower)->get();
      foreach($DBfollowers as $onefollower){
        $followingcount = $onefollower->following;
      }
      $followingcount -= 1;
      DB::table('users')->where('id', $follower)->update(['following' => $followingcount]);


      $DBfollowing = DB::table('users')->where('id', $following)->get();
      foreach($DBfollowing as $onefollowing){
        $followercount = $onefollowing->followers;
      }
      $followercount -= 1;
      DB::table('users')->where('id', $following)->update(['followers' => $followercount]);




      return back();
    }


    public function saveeditedprofile(Request $request)
    {
      $username = $request->input('username');
      $namesurname = $request->input('namesurname');
      $description = $request->input('description');
      $email = $request->input('email');

      $userid = Auth::user()->id;

      DB::table('users')->where('id', $userid)->update(['name' => $username, 'namesurname' => $namesurname, 'description' => $description, 'email' => $email]);

      return back()->with('status', 'Profile succesfully updated!');
    }

    public function deleteaccont(Request $request)
    {
      $userid = $request->input('userid');

      DB::table('users')->where('id', $userid)->delete();

      return redirect('/login');
    }

    public function reportuser(Request $request)
    {
      $loggeduser = Auth::user()->name;
      $DBusers = DB::table('users')->where('name', $loggeduser)->get();
      $DBnotifications = DB::table('notifacations')->where('username', $loggeduser)->take(50)->orderBy('id', 'desc')->get();
      foreach($DBusers as $user) {
        $notificationscount = $user->notifications;
      }


      $userid = $request->input('userid');
      $profilename = $request->input('profilename');

      return view('sites.report',['profilename' => $profilename, 'userid' => $userid,
        'DBnotifications' => $DBnotifications, 'loggeduser' => $loggeduser, 'notificationscount' => $notificationscount]);
    }

    public function reporting(Request $request)
    {
      $userid = $request->input('userid');
      $description = $request->input('description');
      $category = $request->input('category');
      $profilename = $request->input('profilename');

      DB::table('reports')->insert(['category' => $category, 'description' => $description, 'userid' => $userid]);

      return redirect("/profile/$profilename")->with('status', 'User succesfully reported!');
    }
}
