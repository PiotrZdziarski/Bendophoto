<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $loggeduser = Auth::user()->name;
      $DBusers = DB::table('users')->where('name', $loggeduser)->get();
      $DBposts= DB::table('posts')->where('autorpost', $loggeduser)->orderBy('id', 'desc')->get();
      $DBcomments = DB::table('comments')->orderBy('id', 'desc')->get();
      $DBlikes = DB::table('likes')->get();
      $DBnotifications = DB::table('notifacations')->where('username', $loggeduser)->take(50)->orderBy('id', 'desc')->get();
      $profileimagename = '';

      foreach($DBusers as $user) {

        if($user->profileimage != '') {
          $profileimagename = $user->profileimage;
        }

        $posts = $user->posts;
        $following = $user->following;
        $followers = $user->followers;
        $namesurname = $user->namesurname;
        $description = $user->description;
        $profilename = $user->name;
        $notificationscount = $user->notifications;
      }

      return view('home', ['dbusers' => $DBusers,'DBnotifications' => $DBnotifications, 'loggeduser'=> $loggeduser, 'dblikes' => $DBlikes, 'profileimagename' => $profileimagename, 'posts' => $posts, 'profilename' => $profilename,
      'following' => $following, 'notificationscount' => $notificationscount, 'DBcomments' => $DBcomments, 'followers' => $followers, 'DBposts' => $DBposts, 'namesurname' => $namesurname, 'description' => $description]);
    }




    public function userprofile($userprofile)
    {
      if(isset(Auth::user()->name)) {
        if($userprofile == Auth::user()->name) {
          return redirect('/');
        }
      }
      $DBusers = DB::table('users')->where('name', $userprofile)->get();
      $DBposts= DB::table('posts')->where('autorpost', $userprofile)->orderBy('id', 'desc')->get();
      $DBcomments = DB::table('comments')->orderBy('id', 'desc')->get();
      $DBlikes = DB::table('likes')->get();
      foreach($DBusers as $user) {
        $notificationscount = $user->notifications;
      }
      $profileimagename = '';

      foreach($DBusers as $user) {

        if($user->profileimage != '') {
          $profileimagename = $user->profileimage;
        }

        $posts = $user->posts;
        $following = $user->following;
        $followers = $user->followers;
        $namesurname = $user->namesurname;
        $description = $user->description;
        $profilename = $user->name;
        $profileid = $user->id;
        $notificationscount = $user->notifications;
      }



      if(isset(Auth::user()->name)) {
        $loggeduser = Auth::user()->name;
        $loggedid = Auth::user()->id;
        $alreadyfollowcheck = 1;
        $DBcheck = DB::table('followers')->where('followingid', $profileid)->where('followerid', $loggedid)->get();
        foreach($DBcheck as $check) {
          $alreadyfollowcheck += 1;
        }
        $DBnotifications = DB::table('notifacations')->where('username', $loggeduser)->take(50)->orderBy('id', 'desc')->get();
        $DBusers = DB::table('users')->where('name', $loggeduser)->get();
        foreach($DBusers as $user) {
          $notificationscount = $user->notifications;
        }
        return view('sites.userprofile', ['DBnotifications' => $DBnotifications, 'loggeduser'=> $loggeduser, 'alreadyfollowcheck' => $alreadyfollowcheck, 'profileid' => $profileid, 'dbusers' => $DBusers,'userprofile'=> $userprofile, 'dblikes' => $DBlikes, 'profileimagename' => $profileimagename, 'posts' => $posts, 'profilename' => $profilename,
        'following' => $following, 'notificationscount' => $notificationscount, 'DBcomments' => $DBcomments,'profileid' => $profileid, 'followers' => $followers, 'DBposts' => $DBposts, 'namesurname' => $namesurname, 'description' => $description]);
      }
      return view('sites.userprofile', ['dbusers' => $DBusers,'userprofile'=> $userprofile, 'dblikes' => $DBlikes, 'profileimagename' => $profileimagename, 'posts' => $posts, 'profilename' => $profilename,
      'following' => $following, 'notificationscount' => $notificationscount, 'DBcomments' => $DBcomments, 'profileid' => $profileid, 'followers' => $followers, 'DBposts' => $DBposts, 'namesurname' => $namesurname, 'description' => $description]);
    }


    public function bendoline()
    {
      //NEDDED TO SECONDNAVBAR //////////////////////////////////
      $loggeduser = Auth::user()->name;
      $DBusers = DB::table('users')->where('name', $loggeduser)->get();
      $DBnotifications = DB::table('notifacations')->where('username', $loggeduser)->take(50)->orderBy('id', 'desc')->get();
      foreach($DBusers as $user) {
        $notificationscount = $user->notifications;
      }
      ///////////////////////////////////////////////////////////
      $userid = Auth::user()->id;
      $DBfollowers = DB::table('followers')->where('followerid', $userid)->get();
      $DBcomments = DB::table('comments')->orderBy('id', 'desc')->get();

      //GETTING ID OF FOLLOWERS
      array_set($arrayfollowers, 'creator[]=-91293hashh', '99999;[]9');
      foreach($DBfollowers as $follower) {
        array_push($arrayfollowers, $follower->followingid);
      }
      unset($arrayfollowers['creator[]=-91293hashh']);

      //TRANSFERING IT INTO STRINGS
      $DBfollowingusers = DB::table('users')->where('id', $arrayfollowers)->get();

      array_set($nameoffollowers, 'creator[]=-91293hashh', '99999;[]9');
      foreach($DBfollowingusers as $namefollower) {
        array_push($nameoffollowers, $namefollower->name);
      }
      unset($nameoffollowers['creator[]=-91293hashh']);
      $DBposts = DB::table('posts')->where('autorpost', $nameoffollowers)->orderBy('id', 'desc')->get();
      return view('sites.bendoline',['DBposts' => $DBposts, 'DBcomments' => $DBcomments,
      'DBnotifications' => $DBnotifications, 'loggeduser' => $loggeduser, 'notificationscount' => $notificationscount]);
    }


    public function explore()
    {
      $loggeduser = Auth::user()->name;
      $DBusers = DB::table('users')->where('name', $loggeduser)->get();
      $DBposts = DB::table('posts')->where('autorpost', '!=', $loggeduser)->orderBy('id', 'desc')->get();
      $DBcomments = DB::table('comments')->orderBy('id', 'desc')->get();
      $DBnotifications = DB::table('notifacations')->where('username', $loggeduser)->take(50)->orderBy('id', 'desc')->get();
      foreach($DBusers as $user) {
        $notificationscount = $user->notifications;
      }
      return view('sites.explore', ['DBnotifications' => $DBnotifications, 'DBcomments' => $DBcomments, 'DBposts' => $DBposts, 'loggeduser' => $loggeduser, 'notificationscount' => $notificationscount]);
    }


    public function editprofile()
    {
      $loggeduser = Auth::user()->name;
      $userid = Auth::user()->id;
      $DBusers = DB::table('users')->where('name', $loggeduser)->get();
      $DBnotifications = DB::table('notifacations')->where('username', $loggeduser)->take(50)->orderBy('id', 'desc')->get();
      foreach($DBusers as $user) {
        $notificationscount = $user->notifications;
        $email = $user->email;
        $namesurname = $user->namesurname;
        $description = $user->description;
      }





      return view('sites.editprofile', ['DBnotifications' => $DBnotifications, 'loggeduser' => $loggeduser, 'notificationscount' => $notificationscount,
     'email' => $email, 'namesurname' => $namesurname, 'userid'=> $userid, 'description' => $description]);
    }
}
