document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const conservationList = document.getElementById("conservationList");

    // Function to filter the easement list based on search term
    function filterEasements() {
      const searchTerm = searchInput.value.toLowerCase();
      const easementItems = conservationList.querySelectorAll(".easement-box");

      easementItems.forEach((item) => {
        // Retrieve the title from the data attribute or inner text
        const title = item.querySelector(".easement-item").dataset.title || item.querySelector(".easement-item").textContent;
        item.style.display = title.toLowerCase().includes(searchTerm) ? "" : "none";
      });
    }

    // Filter as you type
    searchInput.addEventListener("keyup", filterEasements);
  });