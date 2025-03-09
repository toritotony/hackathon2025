document.addEventListener("DOMContentLoaded", function() {
    // Get a reference to the dynamic div (modal)
    const dynamicDiv = document.getElementById("dynamicContent");

    if (!dynamicDiv) {
      console.error("❌ Error: Dynamic div with id 'dynamicContent' not found.");
      return;
    } else {
      console.log("✅ Dynamic div found:", dynamicDiv);
    }

    // Use event delegation on the dynamic div to catch clicks on any element with the class "close-button"
    dynamicDiv.addEventListener("click", function(event) {
      // Check if the clicked element (or any parent) has the class "close-button"
      if (event.target.closest(".close-button")) {
        console.log("✅ Close button clicked. Hiding dynamic div.", event.target);
        dynamicDiv.style.display = "none";
        console.log("✅ Dynamic div is now hidden.");
      } else {
        console.log("ℹ️ Click detected within dynamic div. Event target:", event.target);
      }
    });

    // For testing: Uncomment the line below to show the dynamic div on page load
    // dynamicDiv.style.display = "block";
  });