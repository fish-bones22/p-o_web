$(window).ready(function() {
  // jQuery to collapse the navbar on scroll

  $(window).scroll(collapseNavbar);
  $(document).ready(function () {
    collapseNavbar();
    $('.logform').hide();
  });

  // Closes the Responsive Menu on Menu Item Click
  $('.navbar-collapse ul li a').click(function() {
    $(this).closest('.collapse').collapse('toggle');
  });
});

function collapseNavbar() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
}
