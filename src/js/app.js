const headerMenuBtn = document.querySelector(".header__menu");
const headerNav = document.querySelector(".header__nav");

headerMenuBtn.addEventListener("click", () => {
  console.log(123);
  if (headerMenuBtn.classList.contains("header__menu_active")) {
    headerMenuBtn.classList.remove("header__menu_active");
    headerNav.classList.remove("header__nav_active");
  } else {
    headerMenuBtn.classList.add("header__menu_active");
    headerNav.classList.add("header__nav_active");
  }
});
