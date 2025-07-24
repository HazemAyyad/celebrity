window.addEventListener("load", function () {
  const preloader = document.getElementById("preloader");

  if (preloader) {
    preloader.style.transition = "opacity 0.5s ease"; // Adjust duration as needed
    preloader.style.opacity = 0;

    // Wait for the transition to complete before removing the element
    setTimeout(() => {
      preloader.remove();
    }, 500); // Match this duration with the CSS transition
  }
});

// Calculate the Space Top for Navbar
document.addEventListener("DOMContentLoaded", function () {
  function calcvulateNavbarTop() {
    const navbar = document.getElementById("navbar");
    const alert = document.getElementById("alert");
    const alertHeight = alert.clientHeight;
    const closeBtn = document.getElementById("closeAlert");
    if (alertHeight - window.scrollY >= 0) {
      navbar.style.top = `${alertHeight - window.scrollY}px`;
    } else {
      navbar.style.top = 0;
    }
    closeBtn.addEventListener("click", () => {
      navbar.style.top = 0;
    });
  }

  // Call the function when the page loads
  window.addEventListener("scroll", calcvulateNavbarTop);

  // Call the function when the page resize
  window.addEventListener("resize", calcvulateNavbarTop);

  // Call your function directly
  calcvulateNavbarTop();
});

// Toggle Classes for Collapse in the Search Page
document.addEventListener("DOMContentLoaded", function () {
  const collapseEditSearch = document.getElementById("collapseEditSearch");
  const collapseFilter = document.getElementById("collapseFilter");
  // Apply fade class only on mobile (smaller than 768px)
  function applyFadeOnMobile() {
    if (collapseEditSearch && collapseFilter) {
      if (window.innerWidth < 768) {
        collapseEditSearch.classList.remove("show");
        collapseEditSearch.classList.add("fade");

        collapseFilter.classList.remove("show");
        collapseFilter.classList.add("fade");
      } else {
        collapseEditSearch.classList.remove("fade");
        collapseEditSearch.classList.add("show");

        collapseFilter.classList.remove("fade");
        collapseFilter.classList.add("show");
      }
    }
    return;
  }

  // Call the function when the page loads
  applyFadeOnMobile();

  // Handle window resize
  window.addEventListener("resize", applyFadeOnMobile);
});

// Initialize WOW Animated
new WOW().init();

// Initialize the Features Swiper
const swiperFeatures = new Swiper(".swiper-features", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 3000, // Time between slides (in milliseconds)
    disableOnInteraction: false, // Keeps autoplay running after user interaction
  },
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    // when window width is >= 640px
    640: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});


// Initialize the Features Swiper
const swiperSecondFeatures = new Swiper(".swiper-second-features", {
  slidesPerView: 3,
  centeredSlides: true,
  infinite: true,
  initialSlide: 1, // Start from the second slide
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 3000, // Time between slides (in milliseconds)
    disableOnInteraction: false, // Keeps autoplay running after user interaction
  },
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    // when window width is >= 640px
    640: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

// Initialize the Reviews Swiper
const swiperReviews = new Swiper(".swiper-reviews", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 3000, // Time between slides (in milliseconds)
    disableOnInteraction: false, // Keeps autoplay running after user interaction
  },
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    // when window width is >= 640px
    640: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

// Change Input Text in the Search Form to Select Box and Auto Complete
$(document).ready(function () {
  $(".destinations-input").keyup(function (e) {
    var _group = $(this).closest(".form-group");
    _group.find(".selector-box").html("");
    $.ajax({
      url: "https://gita.sa/api/airlines",
      data: {
        search: $(this).val(),
      },
      type: "get",
      success: function (res) {
        _group.find(".selector-box").html(res);
      },
    });
  });

  // Take the Selected Value to the Input
  $(document).on("click", ".airline-option", function (e) {
    e.preventDefault();
    var _val = $(this).data("code");
    var _group = $(this).closest(".form-group");
    _group.find(".destinations-input").val($(this).data("city"));
    _group.find(".destinations-input").data("val", _val);
    $(this).closest(".selector-box").removeClass("show");
  });
});

// Toggle Classes Show to Selector Box
$(".destinations-input").keyup(function () {
  $(this).parent().find(".selector-box").addClass("show");
});

// Close the Select Box when Mouseup
$(document).mouseup(function (e) {
  var container = $(".selector-box");

  if (!container.is(e.target) && container.has(e.target).length === 0) {
    $(".selector-box").removeClass("show");
  }
});


let slideIndex = 1;

function openLightbox() {
  document.getElementById("lightbox").style.display = "block";
}

function closeLightbox() {
  document.getElementById("lightbox").style.display = "none";
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex - 1].style.display = "block";
}
