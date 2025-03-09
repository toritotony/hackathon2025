/*
MAP FILE
*/

var map = L.map('map', {
    center: [40.7, -123.9],
    zoom: 9,
    minZoom: 9,
    maxZoom: 11,
    maxBounds: [[41.96, -126.008], [39.9166, -122.1933]]
});
// var map = L.map('map').setView([40.7, -123.9], 8.25);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  }).addTo(map);

  //start title
  // Add a title to the map with a single-line constraint
  var titleDiv = document.createElement("div");
  titleDiv.innerHTML = "<strong>Northcoast Regional Land Trust Conservation Easements</strong>";
  titleDiv.style.position = "absolute";
  titleDiv.style.top = "10px";  // Adjust vertical position
  titleDiv.style.left = "50%";
  titleDiv.style.transform = "translateX(-50%)";  // Centers it horizontally
  titleDiv.style.background = "white";
  titleDiv.style.padding = "10px 20px";  // Added horizontal padding for spacing
  titleDiv.style.border = "1px solid black";
  titleDiv.style.borderRadius = "5px";
  titleDiv.style.boxShadow = "0px 0px 5px rgba(0,0,0,0.3)";
  titleDiv.style.fontSize = "16px";
  titleDiv.style.fontFamily = "Times New Roman, serif";  // Set font to Times New Roman
  titleDiv.style.color = "#333";
  titleDiv.style.textAlign = "center";
  titleDiv.style.zIndex = "1000";  // Ensures it stays above the map
  titleDiv.style.whiteSpace = "nowrap";  // Prevents line breaks
  
  // Add the title to the map container
  map.getContainer().appendChild(titleDiv);
  // end title
  
  // start legend
  var legend = L.control({ position: 'bottomleft' });

  legend.onAdd = function(map) {
      var div = L.DomUtil.create('div', 'legend'),
          labels = [
              { type: "NRLT Completed CE", color: "#D134A9", border: true },
              { type: "NRLT CE in Progress", color: "#F4C360", border: true },
              { type: "NRLT Property", icon: "star" },
              { type: "Public Lands", color: "#A6D39A" },
              { type: "Tribal Lands", color: "#E0A2A7" },
              { type: "Additional CE's", color: "#D8CCFB" },
              { type: "Highways", icon: "highwayline" },
              { type: "Rivers", icon: "riverline" },
              { type: "Counties", icon: "box" }
          ];

      // Apply styles to the legend
      div.style.background = "white";
      div.style.padding = "10px";
      div.style.border = "1px solid black";
      div.style.borderRadius = "5px";
      div.style.boxShadow = "0px 0px 5px rgba(0,0,0,0.3)";
      div.style.fontSize = "14px";
      div.style.color = "#333";
      div.style.position = "relative";
      div.style.fontFamily = "Times New Roman, serif";

      div.innerHTML += "<strong>Map Legend</strong><br>";

      labels.forEach(function(item) {
          if (item.color) {
              let borderStyle = item.border ? "border: 1px solid black;" : "";
              div.innerHTML += `<i style="width: 15px; height: 15px; background:${item.color}; ${borderStyle} display: inline-block; margin-right: 8px;"></i> ${item.type}<br>`;
            } else if (item.icon === "star") {
              div.innerHTML += `<svg width="16" height="16" viewBox="0 0 24 24" style="margin-right: 6px; vertical-align: middle;">
                                  <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" fill="blue"/>
                                </svg> ${item.type}<br>`;
          } else if (item.icon === "box") {
              div.innerHTML += `<i style="width: 18px; height: 12px; display: inline-block; margin-right: 8px; 
                  background: transparent; border: 2px solid gray; border-radius: 2px;"></i> ${item.type}<br>`;  
          } else if (item.icon === "highwayline") {
              div.innerHTML += `<svg width="20" height="12" style="margin-right: 8px;">
                                  <polyline points="0,10 7,3 14,8 20,0" stroke="#D9886D" stroke-width="2" fill="none"/>
                                </svg> ${item.type}<br>`;
          } else if (item.icon === "riverline") {
              div.innerHTML += `<svg width="20" height="12" style="margin-right: 8px;">
                                  <path d="M0 8 Q5 2, 10 8 T20 4" stroke="#73B3E7" stroke-width="2" fill="none"/>
                                </svg> ${item.type}<br>`;
          }
      });

      return div;
  };

  legend.addTo(map);
//end legend  

  // start of the polygon creation
  
  

  var conservationStatusColors = {
    "Complete": "#D134A9",
    "inProgress": "#F4C360",
    "Additional_CE": "#D8CCFB",
    "Tribal": "#E0A2A7",

  };
  

  fetch("geoJSON.php")
  .then(function(response) {
    return response.json();
  })
  .then(function(response) {
    L.geoJSON(response, {
      style: function(feature) {
        var color = conservationStatusColors[feature.properties.conservationStatus] || "black"; // default to black if not matched
        return {
          color: color,
          fillColor: color,
          weight: 2,
          fillOpacity: 0.7
        };
      },
      onEachFeature: function (feature, layer) {
        var desc = feature.properties.description || "";
        if (desc.length > 100) {
          desc = desc.substring(0, 100) + "...";
        }
        else {
        }
        layer.bindPopup("<b> Name: " + feature.properties.name + "</b><br />" +
                          "Acres: " + feature.properties.acres + "<br />" +
                          "Conservation Type: " + feature.properties.conservationType + "<br />" +
                          "Description: " + desc);
        
      }
    }).addTo(map);
  })
  .catch(function(error) {
    console.error("Error fetching GeoJSON:", error);
  });






  

  /*
  var latlngs = [[37, -109.05],[41, -109.03],[41, -102.05],[37, -102.04]];
  var polygon = L.polygon(latlngs, {color: conserved}).addTo(map);
  var personName = "Tony"
  var desc ="Moonlight whispers over barren fields, dreams bloom in hidden shadows, time slips softly, echoing hopes and memories that never fade."
  // zoom the map to the polygon
  
  map.fitBounds(polygon.getBounds());

  polygon.bindPopup("<p>" + personName + "</p>" + "<br />" + desc);
*/
  // End of the polygon creation




  
