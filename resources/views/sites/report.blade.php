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
  <div class="container" >
    <br>
    <span class="explorespan">Report</span>
    <div class="row justify-content-center">
      <div class="col-md-10" style="border-bottom: 1px solid lightgray; padding-bottom: 25px;">

      </div>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8" style="padding-top: 20px;">
        <div style="width: 100%; font-size: 20px; margin-bottom: 20px;text-align: center;">You want to report <b>{{$profilename}}</b></div>
                <form method="POST" action="{{ route('reporting') }}">
                    @csrf
                    <input type="hidden" value="{{$userid}}" name="userid">
                    <input type="hidden" value="{{$profilename}}" name="profilename">
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Category') }}</label>

                        <div class="col-md-6">
                          <select class="form-control" name="category">
                            <option value="Pornography">Pornography</option>
                            <option value="Spam">Spam</option>
                            <option value="Violation of privacy">Violation of privacy</option>
                          </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Description') }}</label>

                        <div class="col-md-6">
                            <textarea rows="3" id="description" class="form-control" name="description" required autofocus></textarea>
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btnwhite">
                                {{ __('Report') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10" style="border-bottom: 1px solid lightgray; padding-bottom: 25px; margin-bottom: 20px;">
      </div>
    </div>
  </div>



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
@endsection
