window.addEventListener("scroll", function () {
  var header = document.querySelector("nav");
  header.classList.toggle("nav-sticky", window.scrollY > 0);
});

const but = document.querySelector(".humburger");
const nav = document.querySelector(".nav");

but.addEventListener("click", () => {
  if (nav.classList != "nav active") {
    nav.classList.add("active");
    but.innerHTML = "&#10006;";
  } else {
    nav.classList.remove("active");
    but.innerHTML = "&#9776;";
  }
});