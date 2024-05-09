const nav = document.querySelector("#nav-menu");
const bars = document.querySelector("#mobile-nav");
const scrollTop = document.querySelector(".scroll-top");
const scrollLinks = document.querySelectorAll(".scroll-link");

function styleNavTop() {
  if (window.innerWidth > 700) {
    nav.style.top = "0";
  } else {
    nav.style.top = "-228px";
    bars.innerHTML = '<i class="fas fa-bars-staggered"></i>';
  }
}

function showNav() {
  nav.style.top = "52px";
  bars.innerHTML = '<i class="fas fa-xmark"></i>';
}

function hideNav() {
  nav.style.top = "-228px";
  bars.innerHTML = '<i class="fas fa-bars-staggered"></i>';
}

window.addEventListener("load", styleNavTop);
window.addEventListener("resize", styleNavTop);

window.addEventListener("scroll", () => {
  // Sembunyikan navbar saat scroll ke bawah
  if (nav.style.top === "52px") {
    hideNav();
  }

  // Tampilkan tombol scroll to top saat scroll bars >= 52px
  if (window.scrollY >= 52) {
    scrollTop.style.display = "flex";
  } else {
    scrollTop.style.display = "none";
  }
});

window.addEventListener("blur", () => {
  // Sembunyikan navbar ketika tidak dalam keadaan focus
  if (nav.style.top === "52px") {
    hideNav();
  }
});

bars.addEventListener("click", () => {
  if (nav.style.top === "-228px") {
    showNav();
  } else {
    hideNav();
  }
});

scrollLinks.forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();

    const targetId = link.getAttribute("href");
    const targetElement = document.querySelector(targetId);
    const contentWrapper = document.querySelector(".content-wrapper");

    var scrollPosition;
    if (targetId === "#home") {
      scrollPosition = 0;
      hideNav();
    } else {
      scrollPosition = contentWrapper.offsetTop + targetElement.offsetTop;
    }

    window.scrollTo({
      top: scrollPosition,
      behavior: "smooth",
    });
  });
});
