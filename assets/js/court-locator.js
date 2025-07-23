// document.addEventListener("DOMContentLoaded", () => {
//   function showOnMap(iframeSrc, courtName) {
//     console.log("showOnMap called with:", iframeSrc, courtName); // Debug
//     const mapIframe = document.getElementById("courtMap");
//     if (mapIframe) {
//       mapIframe.src = iframeSrc;
//       document.title = `${courtName} | Court Locations`;
//       mapIframe.classList.add("loading");
//       mapIframe.onload = () => {
//         console.log("Iframe loaded:", iframeSrc); // Debug
//         mapIframe.classList.remove("loading");
//       };
//     } else {
//       console.error("Map iframe not found");
//     }
//   }

//   function filterCourts() {
//     const courtType = document.getElementById("courtType").value;
//     const location = document.getElementById("locationSearch").value.trim();
//     console.log("Court Type:", courtType, "Location:", location); // Debug
//     const query = new URLSearchParams();

//     // Only add parameters if they have meaningful values
//     if (courtType && ["district", "high", "supreme"].includes(courtType)) {
//       query.set("courtType", courtType);
//     }
//     if (location) {
//       query.set("locationSearch", location);
//     }

//     // Only redirect if there are parameters or if explicitly clearing
//     if (query.toString() || (courtType === "" && !location)) {
//       console.log("Redirecting to:", `court-locator.php?${query.toString()}`); // Debug
//       window.location.href = `court-locator.php?${query.toString()}`;
//     } else {
//       alert("Please select a court type or enter a location to filter.");
//     }
//   }

//   // Attach event listener for the search button
//   document
//     .getElementById("filterCourtsBtn")
//     .addEventListener("click", filterCourts);
// });







// Make showOnMap globally available
function showOnMap(iframeSrc, courtName) {
  console.log("showOnMap called with:", iframeSrc, courtName);
  const mapIframe = document.getElementById("courtMap");
  if (mapIframe) {
    mapIframe.src = iframeSrc;
    document.title = `${courtName} | Court Locations`;
    mapIframe.classList.add("loading");
    mapIframe.onload = () => {
      console.log("Iframe loaded:", iframeSrc);
      mapIframe.classList.remove("loading");
    };
  } else {
    console.error("Map iframe not found");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  function filterCourts() {
    const courtType = document.getElementById("courtType").value;
    const location = document.getElementById("locationSearch").value.trim();
    console.log("Court Type:", courtType, "Location:", location);
    const query = new URLSearchParams();

    if (courtType && ["district", "high", "supreme"].includes(courtType)) {
      query.set("courtType", courtType);
    }
    if (location) {
      query.set("locationSearch", location);
    }

    if (query.toString() || (courtType === "" && !location)) {
      console.log("Redirecting to:", `court-locator.php?${query.toString()}`);
      window.location.href = `court-locator.php?${query.toString()}`;
    } else {
      alert("Please select a court type or enter a location to filter.");
    }
  }

  // Attach event listener for the search button
  document
    .getElementById("filterCourtsBtn")
    .addEventListener("click", filterCourts);
});
