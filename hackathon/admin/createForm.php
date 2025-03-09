<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title> Admin Create Tool</title>
    <meta charset="utf-8" />

    <!-- (you can REMOVE THIS COMMENT when using this template)
         =============================================
         class style standard: you are required to link to normalize.css
         *before* your personal/additional external CSS files

         to play it safe, I linked to a copy of normalize.css I *know*
         exists, in my directory; you may change this to your local copy

         also note: CSS validator (can be used for your .css files):
         https://jigsaw.w3.org/css-validator/
    -->

    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />

</head>

<body>
    <h1>Admin Tools</h1>
    <form action="c" method="post">
    <fieldset>
    <!--
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>
        <br />
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
        <br />
         -->
        <p>
            <label for="propName">Property Name</label>
            <input type="text" id="propName" name="propName" placeholder="Name of Property" required="required" />
        </p>
        <p>
            <label for="idBox">Property ID</label>
            <input type="number" id="idBox" name="idBox" placeholder="ID" required="required" max="99" />
        </p>
        <p>
            <label for="propAcre">Property Acre</label>
            <input type="number" id="propAcre" name="propAcre"/>
        </p>
        <p>
            <label for="propConType">Property Conservation Type</label>
            <input type="text" id="propConType" name="propConType"/>
        </p>
        <p>
            <label for="propDesc">Property Description</label>
            <input type="text" id="propDesc" name="propDesc"/>
        </p>
        <p>
            <label for="propDateCon">Property Date of Conservation</label>
            <input type="text" id="propDateCon" name="propDateCon"/>
        </p>
        <p>
            <label for="propPubAccess">Property Is Publicly Accessible? (0 or 1)</label>
            <input type="number" id="propPubAccess" name="propPubAccess" min="0" max="1"/>
        </p>
        <p>
            <label for="propConStatus">Property Conservation Status</label>
            <input type="text" id="propConStatus" name="propConStatus"/>
        </p>
        <p>
            <label for="propIsOwned">Property Is Owned by NCRLT? (0 or 1)</label>
            <input type="number" id="propIsOwned" name="propIsOwned"/>
        </p>
        <h2>Enter up to 20 Coordinates</h2>
        <div id="coordinate-container"></div>
        <button type="button" id="add-coordinate">Add Coordinate</button>
        <p>Total coordinates: <span id="total-coords">0</span> (Max 20)</p>
        <script>
        const coordinateContainer = document.getElementById('coordinate-container');
        const addCoordinateBtn = document.getElementById('add-coordinate');
        const totalCoordsSpan = document.getElementById('total-coords');
        let count = 0;
        
        addCoordinateBtn.addEventListener('click', function() {
            if (count >= 20) {
            alert("Maximum 20 coordinates reached.");
            return;
            }
            count++;
            totalCoordsSpan.textContent = count;
            
            const rowDiv = document.createElement('div');
            rowDiv.className = "coordinate-row";
            rowDiv.innerHTML = `
            <label>Coordinate ${count}:</label>
            <input type="number" name="x_${count}" placeholder="X" step="any" required>
            <input type="number" name="y_${count}" placeholder="Y" step="any" required>
            <input type="number" name="z_${count}" value="${count}" readonly>
            `;
            coordinateContainer.appendChild(rowDiv);
        });
        </script>
        <input type="hidden" name="crud" value="create" />
    </fieldset>
    <fieldset>
        <legend>Submit Changes</legend>
        <input type="submit" />
    </fieldset>
    </form>

    <footer>
        </br>
        <button>
            <a href="index.php"style="text-decoration: none; color: black;">Home Page</a>
        </button>
    </footer>

    </body>
</html>

