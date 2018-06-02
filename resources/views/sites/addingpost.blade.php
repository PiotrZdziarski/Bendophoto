@extends('layouts.app')
@section('content')
 <div class="container margincontainer" style="padding:0;">
   <div class="col-md-6 justify-content-center" style="margin-left:auto; margin-right:auto;">
     <div class="card">

       <div class="card-header">
         Add post
       </div>

       <div class="card-body">
         <form method="post" action="{{Route('addpost')}}" enctype="multipart/form-data">
           @csrf
           Type: <Br>
           <select class="form-control" name="type">
            <option value="Photo">Photo</option>
            <option value="Video">Video</option>
           </select>
           <br>
           <input type="file" class="form-control" name="post">
           <br>
           <textarea maxlength="200" class="form-control" name="description" placeholder="Type some description..."></textarea>
           <br>
           <button class="form-control" style="margin-left: 75%;width:24%;"> Send</button>
         </form>
       </div>

   </div>
 </div>
@endsection
