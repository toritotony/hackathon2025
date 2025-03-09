<!-- <!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title> Admin Update Tools</title>
    <meta charset="utf-8" />


    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />

</head>

<body>
    <h1>Admin Update Tool</h1>
    <form method="GET" action="update.php">
    <fieldset>
        <label for="idBox">Enter Property ID </label>
        <input type="number" id="idBox" placeholder="ID" required="required" max="99" />
    </feildset>
    <fieldset>
        <legend>Submit Query to get current values</legend>
        <input type="submit" />
    </fieldset>
    </form>
    <form method="GET" action="update.php">
    <fieldset>
        <p><strong>Clicking this button will update your record with the new values</strong></p>
        <p>
            <label for="propName">Property Name</label>
            <input type="text" id="propName"/>
        </p>
        <p>
            <label for="propAcre">Property Acre</label>
            <input type="number" id="propAcre"/>
        </p>
        <p>
            <label for="propConType">Property Conservation Type</label>
            <input type="text" id="propConType"/>
        </p>
        <p>
            <label for="propDesc">Property Description</label>
            <input type="text" id="propDesc"/>
        </p>
        <p>
            <label for="propDateCon">Property Date of Conservation</label>
            <input type="text" id="propDateCon"/>
        </p>
        <p>
            <label for="propPubAccess">Property Is Publicly Accessible? (0 or 1)</label>
            <input type="number" id="propPubAccess" min="0" max="1"/>
        </p>
        <p>
            <label for="propConStatus">Property Conservation Status</label>
            <input type="text" id="propConStatus"/>
        </p>
        <p>
            <label for="updateIsOwned">Property Is Owned by NCRLT? (0 or 1)</label>
            <input type="number" id="propIsOwned" min="0" max="1"/>
        </p>
    </fieldset>
    <fieldset>
        <legend>Submit Changes</legend>
        <input type="submit" />
    </fieldset>
    </form>
</body>
</html>
-->

<?php
// admin_tools.php
ini_set('display_errors', 1);

// Initialize variables for the property values.
$property_id = "";
$property_name = "";
$property_acre = "";
$property_con_type = "";
$property_desc = "";
$property_date_con = "";
$property_pub_access = "";
$property_con_status = "";
$property_is_owned = "";
$errorMsg = "";

// If the user submitted an ID, query the database.
if (isset($_POST["idBox"]) && is_numeric($_POST["idBox"])) {
    $property_id = $_POST["idBox"];
    
    // Connect to Oracle using your connection function.
    require_once("../conn.php");
    $conn = hum_conn_no_login();
    if (!$conn) {
        $errorMsg = "Error connecting to the database.";
    } else {
        // Adjust the query and column names to match your table.
        $sql = "SELECT prop_name, prop_acre, prop_con_type, prop_desc, 
                       prop_date, prop_pub_acc, prop_con_status, prop_is_owned 
                FROM property
                WHERE prop_id = :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $property_id);
        oci_execute($stmt, OCI_DEFAULT);
        
        if ($row = oci_fetch_assoc($stmt)) {
            $property_name      = $row["PROP_NAME"];
            $property_acre      = $row["PROP_ACRE"];
            $property_con_type  = $row["PROP_CON_TYPE"];
            $property_desc      = $row["PROP_DESC"];
            $property_date_con  = $row["PROP_DATE"];
            $property_pub_access= $row["PROP_PUB_ACC"];
            $property_con_status= $row["PROP_CON_STATUS"];
            $property_is_owned  = $row["PROP_IS_OWNED"];
        } else {
            $errorMsg = "No property found with ID: " . htmlspecialchars($property_id);
        }
        oci_free_statement($stmt);
        $sql2 = "SELECT x_coord, y_coord, ord_num 
             FROM coordinates 
             WHERE prop_id = :id 
             ORDER BY ord_num";
        $stmt2 = oci_parse($conn, $sql2);
        oci_bind_by_name($stmt2, ":id", $property_id);
        oci_execute($stmt2, OCI_DEFAULT);
    
        while ($row2 = oci_fetch_assoc($stmt2)) {
            $coordinateRecords[] = $row2;
        }
        oci_free_statement($stmt2);
        oci_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Admin Tools</title>
    <meta charset="utf-8" />
    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css" type="text/css" rel="stylesheet" />
    <style>
      body { font-family: Arial, sans-serif; margin: 20px; }
      fieldset { margin-bottom: 20px; padding: 10px; }
      label { display: inline-block; width: 250px; }
    </style>
</head>
<body>
    <h1>Admin Update Tool</h1>
    <?php
      if ($errorMsg !== "") {
          echo "<p style='color:red;'>" . $errorMsg . "</p>";
      }
    ?>
    <!-- First Form: Submit ID Query -->
    <form method="POST" action="updateForm.php">
        <fieldset>
            <label for="idBox">Enter Property ID</label>
            <input type="number" id="idBox" name="idBox" placeholder="ID" required="required" max="99" value="<?php echo htmlspecialchars($property_id); ?>" />
        </fieldset>
        <fieldset>
            <legend>Submit Query to get current values</legend>
            <input type="submit" value="Get Current Values" />
        </fieldset>
    </form>
    
    <!-- Second Form: Update Record (Pre-populated) -->
    <form method="POST" action="parser.php">
        <fieldset>
            <p><strong>Clicking this button will update your record with the new values</strong></p>
            <p>
                <label for="updateName">Property Name</label>
                <input type="text" id="updateName" name="updateName" value="<?php echo htmlspecialchars($property_name); ?>" />
            </p>
            <p>
                <label for="updateAcre">Property Acre</label>
                <input type="number" id="updateAcre" name="updateAcre" value="<?php echo htmlspecialchars($property_acre); ?>" />
            </p>
            <p>
                <label for="updateConType">Property Conservation Type</label>
                <input type="text" id="updateConType" name="updateConType" value="<?php echo htmlspecialchars($property_con_type); ?>" />
            </p>
            <p>
                <label for="updateDesc">Property Description</label>
                <input type="text" id="updateDesc" name="updateDesc" value="<?php echo htmlspecialchars($property_desc); ?>" />
            </p>
            <p>
                <label for="updateDateCon">Property Date of Conservation</label>
                <input type="text" id="updateDateCon" name="updateDateCon" value="<?php echo htmlspecialchars($property_date_con); ?>" />
            </p>
            <p>
                <label for="updatePubAccess">Property Is Publicly Accessible? (0 or 1)</label>
                <input type="number" id="updatePubAccess" name="updatePubAccess" min="0" max="1" value="<?php echo htmlspecialchars($property_pub_access); ?>" />
            </p>
            <p>
                <label for="updateConStatus">Property Conservation Status</label>
                <input type="text" id="updateConStatus" name="updateConStatus" value="<?php echo htmlspecialchars($property_con_status); ?>" />
            </p>
            <p>
                <label for="updateIsOwned">Property Is Owned by NCRLT? (0 or 1)</label>
                <input type="number" id="updateIsOwned" name="updateIsOwned" min="0" max="1" value="<?php echo htmlspecialchars($property_is_owned); ?>" />
            </p>
            <!-- Hidden field to pass the property ID -->
            <input type="hidden" name="idBox" value="<?php echo htmlspecialchars($property_id); ?>" />
            <!-- Hidden field so parser knows its a delete -->
            <input type="hidden" name="crud" value="update" />
        </fieldset>

        <fieldset>
            <legend>Coordinates</legend>
            <?php if (!empty($coordinateRecords)) : ?>
                <?php foreach ($coordinateRecords as $record) : ?>
                    <div class="coordinate-record">
                        <p>
                            <strong>Order Number: <?php echo htmlspecialchars($record["ORD_NUM"]); ?></strong>
                        </p>
                        <p>
                            <label for="coord_<?php echo $record["ORD_NUM"]; ?>_x">X Coordinate</label>
                            <input type="number" id="coord_<?php echo $record["ORD_NUM"]; ?>_x" 
                                   name="coordinates[<?php echo $record["ORD_NUM"]; ?>][x_coord]" 
                                   value="<?php echo htmlspecialchars($record["X_COORD"]); ?>" step="any" />
                        </p>
                        <p>
                            <label for="coord_<?php echo $record["ORD_NUM"]; ?>_y">Y Coordinate</label>
                            <input type="number" id="coord_<?php echo $record["ORD_NUM"]; ?>_y" 
                                   name="coordinates[<?php echo $record["ORD_NUM"]; ?>][y_coord]" 
                                   value="<?php echo htmlspecialchars($record["Y_COORD"]); ?>" step="any" />
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No coordinates found for this property.</p>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Submit Changes</legend>
            <input type="submit" value="Update Record" />
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

