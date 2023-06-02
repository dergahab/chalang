var swiper = new Swiper(".mySwiper", {
  slidesPerView: 2,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});


$(document).ready(function() {
  $(".filter-button").click(function() {
    var value = $(this).attr('data-filter');

    if (value == "all") {
      $('.filter:not(.' + value + ')').hide('3000');
      $('.filter.' + value).show('3000');
    } else {
      $('.filter:not(.' + value + ')').hide('3000');
      $('.filter.' + value).show('3000');
    }

   // Add/remove active class
   $(".filter-button").removeClass("is-checked");
   $(this).addClass("is-checked");
  });
});

