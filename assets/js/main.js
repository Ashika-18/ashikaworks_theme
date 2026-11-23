(function () {
  var motionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
  var slider = document.querySelector("[data-fv-slider]");
  var slides = slider ? Array.prototype.slice.call(slider.querySelectorAll(".fv-slide")) : [];
  var dots = Array.prototype.slice.call(document.querySelectorAll("[data-fv-dot]"));
  var index = 0;
  var timer = 0;

  function showSlide(next) {
    if (!slides.length) {
      return;
    }
    index = (next + slides.length) % slides.length;
    slides.forEach(function (slide, slideIndex) {
      slide.classList.toggle("is-active", slideIndex === index);
    });
    dots.forEach(function (dot, dotIndex) {
      var active = dotIndex === index;
      dot.classList.toggle("is-active", active);
      dot.setAttribute("aria-current", active ? "true" : "false");
    });
  }

  function stopSlider() {
    window.clearInterval(timer);
    timer = 0;
  }

  function startSlider() {
    stopSlider();
    if (motionQuery.matches || slides.length < 2) {
      return;
    }
    timer = window.setInterval(function () {
      showSlide(index + 1);
    }, 4500);
  }

  if (slides.length) {
    showSlide(0);
    startSlider();
    dots.forEach(function (dot, dotIndex) {
      dot.addEventListener("click", function () {
        showSlide(dotIndex);
        startSlider();
      });
    });
    if (typeof motionQuery.addEventListener === "function") {
      motionQuery.addEventListener("change", startSlider);
    }
  }

  var nav = document.querySelector("[data-site-nav]");
  var toggle = document.querySelector("[data-nav-toggle]");
  var closers = Array.prototype.slice.call(document.querySelectorAll("[data-nav-close]"));

  function setNav(open) {
    if (!nav || !toggle) {
      return;
    }
    document.body.classList.toggle("is-nav-open", open);
    toggle.setAttribute("aria-expanded", open ? "true" : "false");
  }

  if (toggle) {
    toggle.addEventListener("click", function () {
      setNav(!document.body.classList.contains("is-nav-open"));
    });
  }

  closers.forEach(function (closer) {
    closer.addEventListener("click", function () {
      setNav(false);
    });
  });

  var screenQuery = window.matchMedia("(min-width: 1025px)");

  function fitFirstScreen() {
    var header = document.querySelector(".site-header");
    if (!header || !document.querySelector(".fv")) {
      return;
    }
    if (!screenQuery.matches) {
      document.documentElement.style.removeProperty("--header-band");
      return;
    }
    document.documentElement.style.setProperty("--header-band", header.offsetHeight + "px");
  }

  fitFirstScreen();
  window.addEventListener("resize", fitFirstScreen);
  if (typeof screenQuery.addEventListener === "function") {
    screenQuery.addEventListener("change", fitFirstScreen);
  }

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      setNav(false);
    }
  });

  document.addEventListener("click", function (event) {
    var link = event.target.closest("a[href]");
    if (!link) {
      return;
    }
    if (link.closest("[data-site-nav]")) {
      setNav(false);
    }
    var url;
    try {
      url = new URL(link.href, window.location.href);
    } catch (error) {
      return;
    }
    if (!url.hash || url.pathname !== window.location.pathname) {
      return;
    }
    var target = document.getElementById(url.hash.slice(1));
    if (!target) {
      return;
    }
    event.preventDefault();
    target.scrollIntoView({
      behavior: motionQuery.matches ? "auto" : "smooth",
      block: "start"
    });
  });
}());
