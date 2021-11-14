(function ($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $(".sidebar .collapse").collapse("hide");
    }
  });

  if ($(window).width() < 480) {
    $(".sidebar .collapse").collapse("hide");
  } else {
    $("body").removeClass("sidebar-toggled");
      $(".sidebar").removeClass("toggled");
  }
  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function () {
    if ($(window).width() < 768) {
      $(".sidebar .collapse").collapse("hide");
    }

    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() > 480) {
      $("body").removeClass("sidebar-toggled");
      $(".sidebar").removeClass("toggled");
      $(".sidebar .collapse").collapse("hide");

    }
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over

  // Scroll to top button appear
  $(document).on("scroll", function () {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $(".scroll-to-top").fadeIn();
    } else {
      $(".scroll-to-top").fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on("click", "a.scroll-to-top", function (e) {
    var $anchor = $(this);
    $("html, body")
      .stop()
      .animate({
          scrollTop: $($anchor.attr("href")).offset().top,
        },
        1000,
        "easeInOutExpo"
      );
    e.preventDefault();
  });

  $(document).on("click", "a#panduan", function (e) {
    var $anchor = $(this);
    $("html, body").animate({
        scrollTop: $($anchor.attr("href")).offset().top + 190,
      },
      1000,
      "easeInOutExpo"
    );
    e.preventDefault();
  });

})(jQuery); // End of use strict