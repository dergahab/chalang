var swiper = new Swiper(".mySwiper", {
  slidesPerView: 2,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});


// JavaScript/jQuery code
$(document).ready(function() {
  $(".filter-button").click(function() {
    var value = $(this).attr('data-filter');

    // If the value is "all," show all elements and remove the active class
    if (value == "all") {
      $('.filter').show('3000');
      $(".filter-button").removeClass("is-checked");
      $(this).addClass("is-checked");
    } else {
      // If the value is not "all," apply the regular filtering logic
      $('.filter:not(.' + value + ')').hide('3000');
      $('.filter.' + value).show('3000');

      // Add/remove active class
      $(".filter-button").removeClass("is-checked");
      $(this).addClass("is-checked");
    }
  });
});


