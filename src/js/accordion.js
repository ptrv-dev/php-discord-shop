const items = document.querySelectorAll("._accordion");

items.forEach((item) => {
  item.addEventListener("click", (event) => {
    event.composedPath().forEach((el) => {
      if (el.classList && el.classList.contains("_accordion__header")) {
        item.classList.toggle("_accordion_active");
      }
    });
  });
});
