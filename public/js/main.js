$(function () {

  $(this).scroll(function (e) { 
    let offsetTop = $(this).scrollTop();
    if (offsetTop > 40) {
      $('#home nav').css({
        'background-color': 'white',
        'transition': '.7s'
      });
      
      $('#home nav').addClass('shadow');
    } else {
      $('#home nav').css({
        'background-color': 'transparent'
      });
      $('#home nav').removeClass('shadow');
    }
  });

  $('nav a.nav-link').click(function (e) { 
    $('button.navbar-toggler').addClass('collapsed');
    $('#navbarNav').removeClass('show');
    $('nav a.nav-link').removeClass('active');
    $(this).addClass('active');
  });
  $(document).on('click', 'a.nav-link',function (e) { 
    $("html, body")
    .stop()
    .animate({
        scrollTop: $($(this).attr("href")).offset().top - 60,
      },
      1000,
      'easeInOutExpo'
      );
    });
    e.preventDefault();
});