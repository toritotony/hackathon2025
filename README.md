# Hackathon for Social Good 2025

Welcome to the project repository for the **Cal Poly Humboldt Hackathon for Social Good 2025**. Our team developed a full-stack solution for the North California Regional Land Trust to enhance their digital presence and streamline property data management. This repository contains the source code for both the interactive map web app and the admin portal for CRUD operations.

---

## Table of Contents

- [Project Overview](#project-overview)
- [Technical Details](#technical-details)
- [Live Demos](#live-demos)
- [Setup & Installation](#setup--installation)

---

## Project Overview

Our solution equips the North California Regional Land Trust with:
- An **interactive map** integrated into their WordPress website using the Leaflet library.
- A backend that connects to an Oracle SQL database containing property information (coordinates, images, and descriptive data).
- A dynamic image carousel that displays property images based on naming conventions and database metadata.
- An **admin portal** that allows authorized users to perform CRUD operations without requiring SQL knowledge.

---

## Technical Details

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP making API calls to the Oracle SQL database 
- **Mapping:** Leaflet library for the interactive map  
- **Database:** Oracle SQL storing property details and image metadata  
- **Hosting:** School servers provided infastructure to run web applications

The PHP backend fetches session-specific data on page load, ensuring users see the latest updates on the interactive property table. The admin portal simplifies database management by providing a user-friendly interface for data manipulation.

---

## Live Demos

- **Interactive Map Web App:** [View Demo](https://nrs-projects.humboldt.edu/~dw251/hackathon/)
- **Admin Portal for CRUD Operations:** [View Admin Portal](https://nrs-projects.humboldt.edu/~dw251/hackathon/admin)

You can also find more details in our [Presentation PDF](hackathon/docs/InteractiveMap.pdf).

---

## Setup & Installation

To run the project locally:

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/toritotony/hackathon2025
   cd hackathon2025
   ```

2. **Server Setup:**
    - Ensure you have local web server (e.g., Apache) with PHP enabled
    - Configure the connection settings for your Oracle SQL database in the provided configuration file

3. **Dependencies:**
    - All front-end dependencies (e.g, Leaflet) are included or linked via CDNs
    - Additional dependencies and instructions are documented in the respective project directories

4. **Run the Application:**
    - Launch your web server and navigate to the project URL
