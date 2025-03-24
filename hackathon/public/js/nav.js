document.addEventListener("DOMContentLoaded", function () {
    // Select all dropdown toggles
    const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

    dropdownToggles.forEach((toggle) => {
      toggle.addEventListener("click", function (event) {
        event.preventDefault();
        let dropdown = this.nextElementSibling;

        // Toggle the 'show' class on the clicked dropdown
        dropdown.classList.toggle("show");
        this.parentElement.classList.toggle("show");

        // Close other open dropdowns
        document.querySelectorAll(".dropdown-menu").forEach((menu) => {
          if (menu !== dropdown) {
            menu.classList.remove("show");
            menu.parentElement.classList.remove("show");
          }
        });
      });
    });

    // Close dropdowns when clicking outside
    document.addEventListener("click", function (event) {
      if (!event.target.closest(".nav-item")) {
        document.querySelectorAll(".dropdown-menu").forEach((menu) => {
          menu.classList.remove("show");
          menu.parentElement.classList.remove("show");
        });
      }
    });

    // Toggle menu visibility for small screens
    const navbarToggler = document.querySelector(".navbar-toggler");
    const mainNav = document.getElementById("main-nav");

    if (navbarToggler) {
      navbarToggler.addEventListener("click", function () {
        mainNav.classList.toggle("show");
      });
    }
  });