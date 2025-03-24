document.addEventListener("DOMContentLoaded", function () {
    const sortOption = document.getElementById("sortOption");
    const conservationList = document.getElementById("conservationList");

    // Function to sort the conservation easement items
    function sortEasements() {
      const selectedOption = sortOption.value;
      // Map the sort option to the actual dataset key (accessibility maps to "access")
      const datasetKey = selectedOption === "accessibility" ? "access" : selectedOption;
      const easementItems = Array.from(conservationList.querySelectorAll(".easement-box"));

      const sortedItems = easementItems.sort((a, b) => {
        const aItem = a.querySelector(".easement-item");
        const bItem = b.querySelector(".easement-item");

        if (selectedOption === "name") {
          return aItem.dataset.title.toLowerCase().localeCompare(bItem.dataset.title.toLowerCase());
        } else if (selectedOption === "size") {
          // Extract numeric part of the size for proper sorting
          const aSize = parseFloat(aItem.dataset.size) || 0;
          const bSize = parseFloat(bItem.dataset.size) || 0;
          return bSize - aSize;
        } else {
          const aValue = aItem.dataset[datasetKey] || "";
          const bValue = bItem.dataset[datasetKey] || "";
          return aValue.toLowerCase().localeCompare(bValue.toLowerCase());
        }
      });

      // Clear the list and update display text for each item
      conservationList.innerHTML = "";
      sortedItems.forEach(item => {
        const link = item.querySelector(".easement-item");
        let displayText = link.dataset.title;

        // If not sorting by name, update display text with the sort key value
        if (selectedOption !== "name") {
          let value = "";
          if (selectedOption === "size") {
            // Parse the numeric size; if it's 0 (or not a positive number), show "unknown size"
            const sizeValue = parseFloat(link.dataset.size);
            value = sizeValue > 0 ? link.dataset.size : "Unknown Size";
          } else {
            value = link.dataset[datasetKey] || "";
          }
          displayText += " - " + value;
        }
        link.textContent = displayText;
        conservationList.appendChild(item);
      });
    }

    // Automatically sort when the dropdown value changes
    sortOption.addEventListener("change", sortEasements);

    // Call the sort function on page load to default to A-Z (name) sorting
    sortEasements();
  });