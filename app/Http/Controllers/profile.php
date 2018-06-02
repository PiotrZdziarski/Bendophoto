<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cookie;
use Auth;
use Illuminate\Support\Facades\Input;

class profile extends Controller
{
    public function addingprofilepicture(Request $request)
    {
      $user = Auth::user()->name;

      if(Input::hasFile('profilepicture')) {
        $file = Input::file('profilepicture');
        $filename = $file->getClientOriginalName();
        if($file->move("storage/images/$user", $file->getClientOriginalName())) {
          $profileimagecommunicat = "Profile picture successfully updated!";
        } else {
          $profileimagecommunicat = "Something went wrong. Try again later";
        }
        DB::table('users')->where('name', $user)->update(['profileimage' => $filename]);
      } else {
        $profileimagecommunicat = "Something went wrong. Try again later";
      }

      return back()->with('status', $profileimagecommunicat);
    }


    public function likingmethod($postid, $username)
    {
      $DBlikes = DB::table('likes')->where([['username', $username], ['postid', $postid]])->get();
      $alreadyliked = false;

      foreach($DBlikes as $like) {
        $alreadyliked = true;
      }
      if($alreadyliked == false) {
        $DBposts = DB::table('posts')->where('id', $postid)->get();
        foreach($DBposts as $post) {
          $likes = $post->likes;
        }
        $likes += 1;
        session()->put("checkingcheckbox$postid", $postid);
        DB::table('posts')->where('id', $postid)->update(['likes' => $likes]);
        DB::table('likes')->insert(['postid' => $postid, 'username' => $username]);
      }


      if($alreadyliked == true) {
        $DBposts = DB::table('posts')->where('id', $postid)->get();
        foreach($DBposts as $post) {
          $likes = $post->likes;
        }
        $likes -= 1;
        session()->forget("checkingcheckbox$postid");
        DB::table('posts')->where('id', $postid)->update(['likes' => $likes]);
        DB::table('likes')->where([['username', $username], ['postid', $postid]])->delete();
      }
    }


    public function typecomment(Request $request)
    {
      $loggeduser = Auth::user()->name;
      $userid = Auth::user()->id;
      $postid = $request->input('postid');
      $comment = $request->input('comment');
      $authorpost = $request->input('authorpost');
      $date = now();
      $notification = "$loggeduser added comment to your post!";
      $type = "comment";


      $postsDB = DB::table('posts')->where('id', $postid)->get();

      foreach($postsDB as $post){
        $authorpost = $post->autorpost;
      }

      DB::table('users')->where('name', $authorpost)->increment('notifications');


      DB::table('notifacations')->insert(['username' => $authorpost, 'type' => $type, 'text' => $notification, 'date' => $date, 'postid' => $postid]);

      DB::table('comments')->insert(['comment' => $comment, 'postid' => $postid, 'authorcomment' => $loggeduser]);

      return back()->with('showpost', $postid);
    }
}
