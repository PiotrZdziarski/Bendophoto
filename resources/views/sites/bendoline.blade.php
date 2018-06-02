@extends('layouts.app')

@section('content')
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
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <div class="container" style="margin-top: 20px;">
    <div class="row justify-content-center">

      @foreach($DBposts as $post)
        <div class="col-md-7 bendolinepost">
          <div class="bendolinepostinfo">
            <a class="authorinbendoline" href='{{URL("/profile/$post->autorpost")}}'>{{$post->autorpost}}</a>
            <span class="bendolinedate">{{$post->date}}</span>
          </div>
          <img src='{{Asset("storage/images/$post->autorpost/$post->post")}}' class="bendolineimage">
          <div class="utilitiebendoline">
            <span class="float-left" style="font-weight: 700; margin-top: 7px; font-size: 16px;">Likes: </span>
            <span class="float-left" id="likes_span{{$post->id}}" style="font-weight: 700; margin-top: 7px; margin-left: 5px;font-size: 16px;"> {{$post->likes}}</span>


            <div class="likediv">
              <label class="control control-checkbox">
                <input type = "checkbox" class="red-heart-checkbox" id="likeBtn{{$post->id}}"<?php if(session("checkingcheckbox$post->id") == $post->id):  ?> checked <?php endif; ?> data-id="{{$post->id}}" data-user="{{$loggeduser}}">
                <div class="control_indicator"></div>
                 <a style="color:dodgerblue;">Like</a>
              </label>
              </p>
            </div>

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
              <br><Br>
                <button class="btndescription" type="button" data-toggle="collapse" data-target="#descriptioncollapse{{$post->id}}" aria-expanded="false" aria-controls="collapseExample">
                  Description
                </button>
              <div class="collapse" id="descriptioncollapse{{$post->id}}">
                  <span class="textpost" style="color: #333333">{{$post->textpost}}</span>

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
                            <input type="hidden" value="{{$post->autorpost}}" name="authorpost">
                            <textarea name="comment" class="commenttextarea" style="width: 100%; margin-bottom: 10px;" maxlength="100" placeholder="Type comment..."></textarea>
                            <br><br><button class="btnsendcomment">Send</button><br>
                          </form>
                        </div>
                      @endif
                  </div>
              </div>
            </div>
      </div>
      @endforeach
    </div>
  </div>
@endsection
