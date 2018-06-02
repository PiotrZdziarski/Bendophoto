//  LISTS AND NOTIFICATIONS
  function handleSelect(elm) {
    window.location = '/profile/' + elm.value;
  }

    $(document).ready(function(){

      var height = $('.postphoto').height();


      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });

      $('#shownotification').on('click', function(){
        $('#notificationlist').css({"display": "grid"});
      });

      $(document).click(function(event) {
        if (!$(event.target).is("#searcher, #searchresult")) {
          $('#searchresult').css({"display": "none"});
        }

        if (!$(event.target).is("#collapseExample, .touchable, #collapseBody")) {
          $('#collapseExample').collapse('hide');
        }
      });


      $("#searcher").keydown(function(event) {
        if (event.keyCode === 13) {
          href = $(this).val();
            window.location = "/profile/" + href;
        }
      });



      $('#searcher').on("keyup", function() {
          text = $('#searcher').val();
          if(text == "") {
            $('#searchresult').css({"display": "none"});
          }
          if(text != ""){
            $('#searchresult').css({"display": "grid"});
          }
        });


      $('#searcher').on("input", function() {
        var lookingfor = $(this).val();

        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  },
          type:"GET",
          url: '/searching/'+lookingfor,
          success: function(searchresult) {
            var lengthy = Object.keys(searchresult).length;
            $('#searchresult').children('option').remove();

              for(i = 0; i < lengthy; i++) {
                $('#searchresult').append($('<option></option>', {
                    href: '/profile/' + searchresult[i],
                    value: searchresult[i],
                    text: searchresult[i]
                }));
              }
          }
        });
      });
//  END OF LISTS AND NOTIFICATIONS

      $('#notificationbutton').on('click', function(){
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: '/notificationshow',
          type: 'get',
        });

        $('#notifacationcount').text('0');
      });



        setTimeout(function() {
            $(".alert").alert('close' ,"slow");
        }, 5000);

      });
