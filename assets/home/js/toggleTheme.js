const BASE = "https://secondbtc.com/assets/home/";
$(document).ready(function () {
  if (localStorage.getItem("theme") === null) {
    localStorage.setItem('theme', 'dark')
  } else if (localStorage.getItem("theme") === 'dark') {
    $("#theme").attr("href", BASE + "css/dark-theme.css?v=" + Math.random());
    $('#navbar-logo').attr('src', BASE +'img/logo-light.svg');
    $('#icon-theme').attr('src', BASE + 'img/light-theme.svg');
      $('#icon-theme').attr('onclick', 'toggleLight(this)');
      $('body').removeClass().addClass("dark-theme");
  } else {
    $("#theme").attr("href", BASE + "css/light-theme.css?v=" + Math.random());
    $('#navbar-logo').attr('src', BASE + 'img/logo-dark.svg');
    $('#icon-theme').attr('src', BASE +'img/dark-theme.svg');
      $('#icon-theme').attr('onclick', 'toggleDark(this)');
      $('body').removeClass().addClass("light-theme");
  }

  localStorage.getItem('theme')
});

function toggleLight(e) {
  $("#theme").attr("href", BASE + "css/light-theme.css?v=" + Math.random());
  $('#navbar-logo').attr('src', BASE + 'img/logo-dark.svg');
  $(e).attr('src', BASE + 'img/dark-theme.svg');
    $(e).attr('onclick', 'toggleDark(this)');
    $('body').removeClass().addClass("light-theme");
  localStorage.setItem('theme', 'light');
}

function toggleDark(e) {
  $("#theme").attr("href", BASE + "css/dark-theme.css?v=" + Math.random());
  $('#navbar-logo').attr('src', BASE+'img/logo-light.svg');
  $(e).attr('src', BASE+'img/light-theme.svg');
    $(e).attr('onclick', 'toggleLight(this)');
    $('body').removeClass().addClass("dark-theme");
  localStorage.setItem('theme', 'dark');
}
