<!DOCTYPE html>
<html lang="en">
<!-- Load Dependencies First -->
<script src="popUp.js"></script>
<script src="dynamo.js"></script>
<script src="sort.js"></script>
<script src="nav.js"></script>
<script src="search.js"></script>




<head>  
  <title>Conserved Properties – Northcoast Regional Land Trust</title>
  <meta charset="utf-8">
  <link href="style.css" rel="stylesheet" type="text/css">
  <!-- You can also include the updated CSS snippet here in a <style> block if desired -->
</head>
<body>
  <header>
    <a href="https://ncrlt.org/" class="logo-link">
      <img src="logoImg/2-lines-color-transparent.png" alt="Northcoast Regional Land Trust Logo">
    </a>
    <div>
      <a href="https://www.facebook.com/northcoastregionallandtrust" target="_blank">
        <button class="social-button">
          <img class="social-img" src="socialImg/facebook.png" alt="Facebook">
        </button>
      </a>
      <a href="https://www.instagram.com/northcoastregionallandtrust/" target="_blank">
        <button class="social-button">
          <img class="social-img" src="socialImg/instagram.png" alt="Instagram">
        </button>
      </a> 
      <a href="https://www.youtube.com/channel/UCqd29Ot2A1Ll79GdHY31_GQ/videos" target="_blank">
        <button class="social-button">
          <img class="social-img" src="socialImg/youtube.png" alt="YouTube">
        </button>
      </a>
    </div>
    <div class="donate-btn">
      <a target="_blank" href="https://form-renderer-app.donorperfect.io/give/northcoast-regional-land-trust/general-donation-form">
        DONATE
      </a>
    </div>
  </header>
 
  <!-- Navbar Start -->
  <nav class="navbar navbar-dark sticky-top">
    <div class="container-fluid">
      <!-- Hamburger Toggle Button (for mobile) -->
      <button class="navbar-toggler" id="navbar-toggler">
        ☰
      </button>

      <!-- Collapsible Menu -->
      <div id="main-nav" class="navbar-collapse">
        <ul class="navbar-nav">
          <!-- ABOUT Dropdown -->
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              About <span class="dropdown-icon">▼</span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="https://ncrlt.org/about/mission-and-vision/" class="dropdown-item">Mission and Vision</a></li>
              <li><a href="https://ncrlt.org/about/history/" class="dropdown-item">History</a></li>
              <li><a href="https://ncrlt.org/about/board-of-directors/" class="dropdown-item">Board of Directors</a></li>
              <li><a href="https://ncrlt.org/about/staff/" class="dropdown-item">Staff</a></li>
              <li><a href="https://ncrlt.org/about/jobs/" class="dropdown-item">Jobs</a></li>
            </ul>
          </li>

          <!-- WHAT WE DO Dropdown -->
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              What We Do <span class="dropdown-icon">▼</span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="https://ncrlt.org/what-we-do/conserved-properties/" class="dropdown-item">Conserved Properties</a></li>
              <li><a href="https://ncrlt.org/what-we-do/land-stewardship-and-restoration/" class="dropdown-item">Land Stewardship</a></li>
              <li><a href="https://ncrlt.org/what-we-do/conservation-easements/" class="dropdown-item">Conserving Land</a></li>
              <li><a href="https://ncrlt.org/education-programs/" class="dropdown-item">Education Programs</a></li>
            </ul>
          </li>

          <!-- WAYS TO GIVE Dropdown -->
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              Ways to Give <span class="dropdown-icon">▼</span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="https://ncrlt.org/ways-to-give/donate/" class="dropdown-item">Donate</a></li>
              <li><a href="https://ncrlt.org/ways-to-give/business-partners/" class="dropdown-item">Business Partners</a></li>
              <li><a href="https://ncrlt.org/ways-to-give/events/" class="dropdown-item">Events</a></li>
              <li><a href="https://ncrlt.org/ways-to-give/planned-giving/" class="dropdown-item">Planned Giving</a></li>
              <li><a href="https://ncrlt.org/ways-to-give/donate-land/" class="dropdown-item">Donate Land</a></li>
            </ul>
          </li>

          <!-- NEWS & EVENTS Dropdown -->
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              News & Events <span class="dropdown-icon">▼</span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="https://ncrlt.org/news-announcments/" class="dropdown-item">News & Announcements</a></li>
              <li><a href="https://ncrlt.org/events/" class="dropdown-item">Events</a></li>
              <li><a href="https://ncrlt.org/newsletters/" class="dropdown-item">Newsletters</a></li>
            </ul>
          </li>

          <!-- CONTACT US -->
          <li class="nav-item">
            <a href="https://ncrlt.org/contact-us/" class="nav-link">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <div id="dynamicContent" style="display: none;">
  <button id="closeModal" class="close-button">✖️</button>
  <button id="downloadPdf" class="download-button">
    <a href="generate_pdf.php?title=Conserved+Properties&description=This+is+dynamic+content&date=2024-03-09">
        <img src="https://www.citypng.com/public/uploads/preview/download-downloading-save-black-icon-button-png-701751694964960mnimcmxgyh.png" 
             alt="Download" 
             style="width:20px; height:20px;">
    </a>
  </button>
  <button class="share-button">Share</button>

  <!-- Other dynamic content goes here -->
  </div>

  <div>
    <img class="banner" 
         src="backgroundImg/background.jpg" 
         alt="Beautiful waterfall banner">
  </div>
  
  <div class="content-wrapper">
    <h1 class="entry-title">Conserved Properties</h1>
    <p>The Northcoast Regional Land Trust has permanently protected more than 65,000 acres throughout northwestern California. Most of this land belongs to private landowners and is not open to the public but we invite you to read about these special properties by exploring the map below.</p>
    <br>
    <p>Want to get out on a public access trail?&nbsp; Visit our Freshwater Farms Reserve property.</p>
    <br>
    <p>This branch of the website was created by students and is completely experimental and has bugs, especially with the download/share. Keep that in mind.</p>
  </div>
  
  <!-- LEAFLET LINKING  -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

  <!-- flex begin -->
  <div class="flex-container">
    <!-- Left of map start -->
    <div id="leftSide">
      <!-- Sorting and Search Options Container -->
      <div class="sort-search-container">
        <!-- Search Bar Section (dynamically filtering as you type) -->
        <div class="search-container">
          <label for="searchInput">Search Easements:</label>
          <input type="text" id="searchInput" name="search" placeholder="Enter search term...">
        </div>
        <!-- Sorting Options (will sort dynamically on selection change) -->
        <div class="sort-container">
          <label for="sortOption">Sort by:</label>
          <select id="sortOption" name="sort">
            <option value="name">Alphabetical (default)</option>
            <option value="size">Size in Acres (descending)</option>
            <option value="type">Property Type</option>
            <option value="accessibility">Public Accessibility</option>
          </select>
        </div>
      </div>



      
      <!-- Conservation Easement List Section -->
      <div id="conservationListSection">
        <h3 style="font-size: 1.5em; color: #333; margin-bottom: 1em; border-bottom: 2px solid #ddd; padding-bottom: 0.5em;">
          Available Conservation Easements:
        </h3>
        <ol id="conservationList" class="no-list-style">
          <?php include "easementInfo.php" ?>
        </ol>
      </div>
      <!-- end Conservation Easement List Section -->
    </div>
    <!-- Left of map end -->

    <!-- Map Section -->
    <div id="map"></div>
  </div>
  <!-- flex end -->
<script src="map.js"></script>
</body>
</html>