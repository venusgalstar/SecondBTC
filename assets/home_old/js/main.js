"use strict";



$(document).ready(function() {

  $('#preloader').fadeOut('normall', function() {
      $(this).remove();
  });

});

if($("#video-area").length !== 0) {
  $('#video-play').mb_YTPlayer();
}

