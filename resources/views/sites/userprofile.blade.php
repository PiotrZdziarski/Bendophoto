@extends('layouts.app')

@section('content')
  @if(isset(Auth::user()->name))
    <div class="secondnavbar" style="width:100%; height: 50px; padding-top:  10px;margin-top: 38px; background-color:#f9fbff">
      <input name="searcher" id="searcher" type="text" class="form-control float-left" placeholder="🔎 Search">
        <a href="{{Route('bendoline')}}">
          <div class="float-left news"  data-toggle="tooltip" data-placement="right" title="Bendoline" style="cursor:pointer;">
            <div class="float-left" ><img src="{{Asset('storage/images/news.png')}}" style="width: 30px; height:30px;"></div>
          </div>
        </a>

        <div class="float-left notifications">

          <label for="notificationbutton" id="labelnotification" style="cursor:pointer;" data-toggle="tooltip" data-placement="right" title="Notifications">
            <div class="float-left" id="shownotification"><img src="{{Asset('storage/images/notification.png')}}" style="width: 30px; height:30px;"></div>
            <span class="float-left" id="notifacationcount" style="font-size: 12px; color: dodgerblue;margin-top: 22px;">{{$notificationscount}}</span>
          </label>

          <button class="btn btn-primary" type="button" style="display:none;" id="notificationbutton" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          </button>

          <script>

          </script>
        </div>
        <a href="{{Route('explore')}}">
          <div class="float-left explore"  data-toggle="tooltip" data-placement="right" title="Explore" style="cursor:pointer;">
            <div class="float-left" ><img src="{{Asset('storage/images/explore.png')}}" style="width: 30px; height:30px;"></div>
          </div>
        </a>
    </div>

    <select onchange="javascript:handleSelect(this)" multiple="multiple" class="float-left form-control" id="searchresult">
    </select>

    <div class="collapse fast notifacationresult" id="collapseExample">
      <div style="height:250px;">
        <div class="card card-body collapse" id="collapseBody" style="z-index: 4; padding:0; height: 100%;background-color: white;border-top:0; border-bottom:0;">
          @foreach($DBnotifications as $notification)
            @if($notification->showed == 0)

              <!--------- VISIBLE -->
              @if($notification->type == "comment")
                <label for="btnnotification{{$notification->id}}" style="margin-bottom:2px;">
                  <div style="border-bottom: 1px solid lightgray; padding-bottom:14px; margin: 0; padding-top:0;">
                    <span class="touchable" style="width:100%; color:#333333; text-decoration: none;padding-left: 5px;">
                      {{$notification->text}}<br> <span style="font-size: 11px; position:absolute; right: 0%; margin-top: 0px;">{{$notification->date}}</span>
                    </span>
                  </div>
                </label>

                <form method = "post" action="{{Route('notificationlink')}}">
                  @csrf
                  <input type="hidden" value="{{$notification->postid}}" name="postid">
                  <button id ="btnnotification{{$notification->id}}" style="display:none;"></button>
                </form>
              @endif



              @if($notification->type != "comment")
                <label for="btnnewpost{{$notification->id}}" style="margin-bottom:2px;">
                  <div style="border-bottom: 1px solid lightgray; padding-bottom:14px; margin: 0; padding-top:0;">
                    <span class="touchable" style="width:100%; color:#333333; text-decoration: none;padding-left: 5px;">
                      {{$notification->text}}<br> <span style="font-size: 11px; position:absolute; right: 0%; margin-top: 0px;">{{$notification->date}}</span>
                    </span>
                  </div>
                </label>

                <form method = "post" action="{{Route('newpostlink')}}">
                  @csrf
                  <input type="hidden" value="{{$notification->postid}}" name="postid">
                  <input type="hidden" value="{{$notification->type}}" name="authorpost">
                  <button id ="btnnewpost{{$notification->id}}" style="display:none;"></button>
                </form>
              @endif
            @endif

            @if($notification->showed != 0)

                <!--------- NOTVISIBLE -->
              @if($notification->type == "comment")
                <label for="btnnotification{{$notification->id}}" style="margin-bottom:2px; background-color: #eeeeee">
                  <div style="border-bottom: 1px solid lightgray; padding-bottom:14px; margin: 0; padding-top:0;">
                    <span class="touchable" style="width:100%; color: #999999; text-decoration: none;padding-left: 5px;">
                      {{$notification->text}}<br> <span style="font-size: 11px; position:absolute; right: 0%; margin-top: 0px;">{{$notification->date}}</span>
                    </span>
                  </div>
                </label>

                <form method = "post" action="{{Route('notificationlink')}}">
                  @csrf
                  <input type="hidden" value="{{$notification->postid}}" name="postid">
                  <button id ="btnnotification{{$notification->id}}" style="display:none;"></button>
                </form>
              @endif



              @if($notification->type != "comment")
                <label for="btnnewwpost{{$notification->id}}" style="margin-bottom:2px; background-color: #eeeeee">
                  <div style="border-bottom: 1px solid lightgray; padding-bottom:14px; margin: 0; padding-top:0;">
                    <span class="touchable" style="width:100%; color: #999999; text-decoration: none;padding-left: 5px;">
                      {{$notification->text}}<br> <span style="font-size: 11px; position:absolute; right: 0%; margin-top: 0px;">{{$notification->date}}</span>
                    </span>
                  </div>
                </label>
                <form method = "post" action="{{Route('newpostlink')}}">
                  @csrf
                  <input type="hidden" value="{{$notification->postid}}" name="postid">
                  <input type="hidden" value="{{$notification->type}}" name="authorpost">
                  <button id ="btnnewwpost{{$notification->id}}" style="display:none;"></button>
                </form>
              @endif
            @endif
          @endforeach
        </div>
      </div>
    </div>
  @endif

  @if(isset(Auth::user()->name))
    <div class="container">
  @endif

@if(!isset(Auth::user()->name))
  <div class="container margincontainer">
@endif
    <div class="row justify-content-center">
        <div class="col-md-10" id="profilecolmd10">
          <div class="form-group row" style="padding:0; margin:0;">
            <div id="loggeduser" style="min-width: 145px;">
              <div style="width: 100%; min-width: 145px;">
                <div style="padding-right: 15%; ">

                    @if($profileimagename == '' || $profileimagename == null)
                        <img class="rounded" src="{{Asset('storage/images/nonepicture.png')}}" id="profilepicture">
                    @endif

                    @if($profileimagename != '' || $profileimagename != null)
                        <img class="rounded" src='{{Asset("storage/images/$profilename/$profileimagename")}}' id="profilepicture">
                    @endif

                </div>
              </div>


            </div>
              <div style="width: 59%;">
                <a id="username">{{$profilename}}</a>

                  <span data-target="#reportmodal" data-toggle="modal" style="margin-top: 6px; position: absolute;"><img src="{{Asset('storage/images/dots.png')}}" style="width: 30px;height: 30px;"></span>
                <br>



                <!-- Modal REPORT MODAL -->
                <div class="modal" id="reportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                      <form method="post" action="{{Route('reportuser')}}">
                        @csrf
                        <input type="hidden" value="{{$profileid}}" name="userid">
                        <input type="hidden" value="{{$profilename}}" name="profilename">
                        <button type="submit" class="buttonmodalreport">
                          Report this user
                        </button>
                      </form>

                      <button data-dismiss="modal" class="buttonmodalreport">
                        Cancel
                      </button>
                    </div>
                  </div>
                </div>



                @if(isset($loggeduser))
                  @if($alreadyfollowcheck == 1)
                  <form method="post" action="{{Route('follow')}}">
                    @csrf
                    <input type="hidden" value='{{$profileid}}' name="following">
                    <input type="hidden" value='{{Auth::user()->id}}' name="follower">
                    <button type="submit" class="followbutton">Follow</button>
                  </form>
                  @endif


                  @if($alreadyfollowcheck != 1)
                    <form method="post" action="{{Route('unfollow')}}">
                      @csrf
                      <input type="hidden" value='{{$profileid}}' name="following">
                      <input type="hidden" value='{{Auth::user()->id}}' name="follower">
                      <button type="submit" class="unfollowbutton">Unfollow</button>
                    </form>
                  @endif
                @endif




                  <nav class="navbar-light navbar-laravel navbar navbar-expand-md" style="padding-right:0;">
                      <button id="btninfo" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#profileContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span style="color:#888888;">Info</span>
                      </button>



                      <div class="collapse navbar-collapse"  id="profileContent" style="padding-top: 5px;">


                            <span style="width:100%;">
                                <a id="nameandsurname">{{$namesurname}}</a>
                              <br><br>
                                <a style="font-family: 'Roboto', sans-serif;">Posts: {{$posts}}</a>
                                <a class="posts">Following: {{$following}}</a>
                                <span class="posts">Followers: {{$followers}}</span>
                              <br><br>
                                <a>{{$description}}</a>

                            </span>

                      </div>
                  </nav>

              </div>








              </div>
          </div>
  </div>
</div>



<section id="tabs">
	<div class="container" style="margin-top: 30px;">
		<div class="row">
			<div class="col-xs-12 col-md-10" style="margin-left:auto; margin-right:auto; padding:0;">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist" style="margin-bottom: 20px;">
					</div>
				</nav>
        <div class="tab-content py-3 px-sm-0 divwithposts" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            @foreach($DBposts as $post)
              <script>
              $(document).ready(function(){
                $('.postphoto, .text-content').hover(function(){
                  var heightt = $('#posting{{$post->id}}').height();
                  $('#hoverofpost{{$post->id}}').height(heightt);
                });
              });
              </script>
              <div class="float-left decidingphotodiv" style="width: 28.3%; margin-top: -10px;margin-left:2.5%; margin-right: 2.5%;">
                  @if($post->type == 'Photo')
                    <div class="centeringvertically">
                      <label for="button{{$post->id}}" class="labelpost">
                        <span class="text-content" id="hoverofpost{{$post->id}}"><span style="font-size: 22px; font-family: 'Roboto', sans-serif;">👍 {{$post->likes}}</span></span>
                        <img src='{{Asset("storage/images/$post->autorpost/$post->post")}}' id="posting{{$post->id}}" class="postphoto">
                      </label>
                    </div>
                  @endif
                  @if($post->type == "Video")
                    <div class="centeringvertically">
                      <label for="button{{$post->id}}" class="labelpost">
                        <span class="text-content" id="hoverofpost{{$post->id}}"><span style="font-size: 22px; font-family: 'Roboto', sans-serif;">👍 {{$post->likes}}</span></span>
                        <img src="{{Asset("storage/images/video5.png")}}" id="posting{{$post->id}}" class="postphoto">
                      </label>
                    </div>
                  @endif
              </div>
              <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" id="button{{$post->id}}" style="display:none;" data-toggle="modal" data-target="#{{$post->id}}">
                  Launch demo modal
                </button>

                <!-- Modal -->
                <div class="modal fade col-md-8 large modal-lg" id="{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width:80%; top:3%; margin-bottom: 3%;">
                    <div class="modal-content">
                      <a href='{{url("/profile/$post->autorpost")}}' class="float-left authorinmodal">{{$post->autorpost}}</a>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 5%; margin-left:93%;position: absolute;padding:0;">
                        <span aria-hidden="true" style="font-size: 36px; text-align:right;">&times;</span>
                      </button>
                        <div class="modal-body">
                          @if($post->type == 'Photo')
                            <img src='{{Asset("storage/images/$userprofile/$post->post")}}' class="imagingsmalldevice">
                          @endif

                          @if($post->type == "Video")
                            <video controls  class="imagingsmalldevice">
                              <source src="{{Asset("storage/images/$userprofile/".$post->post)}}">
                            </video>
                          @endif
                            <span class="float-left" style="font-weight: 700; margin-top: 7px; font-size: 16px;">Likes: </span>
                            <span class="float-left" id="likes_span{{$post->id}}" style="font-weight: 700; margin-top: 7px; margin-left: 5px;font-size: 16px;"> {{$post->likes}}</span>

                              @if(isset(Auth::user()->name))
                                <div class="likediv">
                                  <label class="control control-checkbox">
                                    <input type = "checkbox" class="red-heart-checkbox" id="likeBtn{{$post->id}}"<?php if(session("checkingcheckbox$post->id") == $post->id):  ?> checked <?php endif; ?> data-id="{{$post->id}}" data-user="{{$loggeduser}}">
                                    <div class="control_indicator"></div>
                                    <a style="color:dodgerblue;">Like</a>
                                  </label>
                                 </p>
                                </div>
                              @endif


                              @if(!isset(Auth::user()->name))
                                <div class="likediv nologgedlike">
                                  <label class="control control-checkbox" style="font-size: 14px;">
                                    <div></div>
                                    <div class="control_indicator"></div>
                                    Log in to rate!
                                  </label>
                                 </p>
                                </div>
                              @endif



                              <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                              <script>

                                  $(document).ready(function(){
                                    $('#likeBtn{{$post->id}}').on('click', function() {
                                      var postid = $(this).data('id');
                                      var username = $(this).data('user');

                                      var likes = $('#likes_span{{$post->id}}').text();
                                      var likesminus = Number(likes) - 1;
                                      var likesplus =  Number(likes) + 1;

                                      var checking = $(this).prop('checked');

                                      if(checking == true) {
                                        $('#likes_span{{$post->id}}').text(likesplus);
                                      }
                                      if(checking == false) {
                                        $('#likes_span{{$post->id}}').text(likesminus);
                                      }



                                      $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  },
                                        url: '/liking/'+postid+'/'+username,
                                        type: 'post',
                                        data: {'postid': postid, 'username': username}
                                      });
                                    });
                                  });


                                </script>


                              <br><br><div class="linebreaker"><br></div>
                                <span class="textpost">{{$post->textpost}}</span>
                              <br>
                                <span class="datespan">{{$post->date}}</span>

                            <div style='width: 100%; border-top: .5px solid lightgray; margin-top: 18px; padding-top:5px;'>
                              @foreach($DBcomments as $comment)
                                @if($comment->postid == $post->id)
                                <a style="font-weight:700; font-family: 'Roboto', sans-serif; margin-right: 5px;">{{$comment->authorcomment}}: </a> {{$comment->comment}}<br>
                                @endif
                              @endforeach
                                @if(isset(Auth::user()->name))
                                  <div>
                                    <form method="post" action="{{Route('typecomment')}}">
                                      @csrf
                                      <input type="hidden" value="{{$post->id}}" name="postid">
                                      <textarea name="comment" class="commenttextarea" maxlength="100" placeholder="Type comment..."></textarea>
                                      <br><br><button class="btnsendcomment">Send</button>
                                    </form>
                                  </div>
                                @endif
                                @if(!isset(Auth::user()->name))
                                  <div>
                                    <form method="post" action="{{Route('typecomment')}}">
                                      @csrf
                                      <input type="hidden" value="{{$post->id}}" name="postid">
                                      <textarea name="comment" class="commenttextarea" maxlength="100"></textarea>
                                      <br><br><div style="background-color:transparent; border: 1px solid lightgray; padding: 2px; margin-top: -19px;right: 3%; color:#222222; position:absolute;">Log in to comment!</div>
                                    </form>
                                  </div>
                                @endif
                            </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- --- --- -->

            @endforeach
					</div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					</div>
				</div>

			</div>
		</div>
	</div>
</section>




@if(session('status'))
<div class="col-md-6 justify-content-center profilepicturealert">
  <div class="alert alert-warning alert-dismissible fade show justify-content-center alertdissapear" role="alert" style="margin:0; background-color: #3c3f42; color:lightgray; border:0; border-radius:1px;">
    {{session('status')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" color="white">&times;</span>
    </button>
  </div>
</div>
@endif


@if(session('showpost'))
<script type="text/javascript">
    $(window).on('load',function(){
        $('#{{session('showpost')}}').modal('show');
    });

</script>
@endif



@if(session('addedpost'))
<div class="col-md-6 justify-content-center profilepicturealert">
  <div class="alert alert-warning fade show justify-content-center alertdissapear" role="alert" style="margin:0; background-color: #3c3f42; color:lightgray; border:0; border-radius:1px;">
    {{session('addedpost')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" style="color:white;">&times;</span>
    </button>
  </div>
</div>
@endif

<script>
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").alert('close' ,"slow");
    }, 7000);
});
</script>



@endsection
