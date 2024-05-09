const bar = document.getElementById("bar");
bar.addEventListener("click", () => {
  const aside = document.querySelector("aside");
  const nav = document.querySelector("nav");
  const main = document.querySelector("main");

  aside.classList.toggle("aside-left");
  nav.classList.toggle("nav-left");
  main.classList.toggle("main-left");
});

const profile = document.querySelector(".profile-dropdown");
profile.addEventListener("click", () => {
  const profileDropdownList = document.querySelector(".profile-dropdown-list");
  profileDropdownList.classList.toggle("d-none");
});

window.addEventListener("resize", () => {
  const aside = document.querySelector("aside");
  const nav = document.querySelector("nav");
  const main = document.querySelector("main");

  if (window.innerWidth > 768) {
    aside.classList.remove("aside-left");
    nav.classList.remove("nav-left");
    main.classList.remove("main-left");
  }
});
