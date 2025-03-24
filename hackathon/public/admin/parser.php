<?php

    if (isset($_POST["crud"]) == 0) {
        echo json_encode(["error" => "API does not support GET requests or incorrect POST, PUT, etc. requests"]);
        exit;
    }
    
    require_once("../conn.php");
    $conn = hum_conn_no_login();

    $theCrud = trim($_POST["crud"]);
    $theCrud = htmlspecialchars($theCrud);

    if(strcmp($theCrud,"create") == 0 ){
        // Get the input values
        $property_name      = $_POST["updateName"];
        $property_acre      = $_POST["updateAcre"];
        $property_con_type  = $_POST["updateConType"];
        $property_desc      = $_POST["updateDesc"];
        $property_date_con  = $_POST["updateDateCon"];
        $property_pub_access= $_POST["updatePubAccess"];
        $property_con_status= $_POST["updateConStatus"];
        $property_is_owned  = $_POST["updateIsOwned"];
        $theID              = $_POST["idBox"];
        $coordinates        = $_POST["coordinates"];
    
        // Prepare and bind the update query for the property
        $insertPropQuery = oci_parse($conn, "INSERT INTO property values(prop_name, prop_acre, prop_con_type, prop_desc, prop_date, prop_pub_acc, prop_con_status, prop_is_owned, prop_id)
                prop_name = :prop_name, 
                prop_acre = :prop_acre, 
                prop_con_type = :prop_con_type, 
                prop_desc = :prop_desc, 
                prop_date = :prop_date_con, 
                prop_pub_acc = :prop_pub_access, 
                prop_con_status = :prop_con_status, 
                prop_is_owned = :prop_is_owned 
                 prop_id = :id");
    
        oci_bind_by_name($insertPropQuery, ":prop_name", $property_name);
        oci_bind_by_name($insertPropQuery, ":prop_acre", $property_acre);
        oci_bind_by_name($insertPropQuery, ":prop_con_type", $property_con_type);
        oci_bind_by_name($insertPropQuery, ":prop_desc", $property_desc);
        oci_bind_by_name($insertPropQuery, ":prop_date_con", $property_date_con);
        oci_bind_by_name($insertPropQuery, ":prop_pub_access", $property_pub_access);
        oci_bind_by_name($insertPropQuery, ":prop_con_status", $property_con_status);
        oci_bind_by_name($insertPropQuery, ":prop_is_owned", $property_is_owned);
        oci_bind_by_name($insertPropQuery, ":id", $theID);
    
        if (!oci_execute($insertPropQuery, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($insertPropQuery);
            echo json_encode(["message" => "Failed to execute query", "error" => $e]);
            exit;
        }
        oci_free_statement($insertPropQuery);
    
        // Update coordinates if provided
        if (!empty($coordinates)) {
            foreach ($coordinates as $coord) {
                $inserCoordQuery = oci_parse($conn, "INSERT coordinates (x_coord, y_coord, prop_id, ord_num) values
                        (x_coord = :x_coord, 
                        y_coord = :y_coord 
                        prop_id = :id, 
                        ord_num = :ord_num)");
    
                oci_bind_by_name($updateCoordQuery, ":x_coord", $coord['x_coord']);
                oci_bind_by_name($updateCoordQuery, ":y_coord", $coord['y_coord']);
                oci_bind_by_name($updateCoordQuery, ":id", $theID);
                oci_bind_by_name($updateCoordQuery, ":ord_num", $coord['ord_num']);
    
                oci_execute($updateCoordQuery, OCI_COMMIT_ON_SUCCESS);
                oci_free_statement($updateCoordQuery);
            }
        }
    
        oci_close($conn);
        echo "Property and coordinates created successfully!";
        header("Location: index.php");
        exit;
    }
    elseif (strcmp($theCrud,"update") == 0) {
            // Get the input values
            $property_name      = $_POST["updateName"];
            $property_acre      = $_POST["updateAcre"];
            $property_con_type  = $_POST["updateConType"];
            $property_desc      = $_POST["updateDesc"];
            $property_date_con  = $_POST["updateDateCon"];
            $property_pub_access= $_POST["updatePubAccess"];
            $property_con_status= $_POST["updateConStatus"];
            $property_is_owned  = $_POST["updateIsOwned"];
            $theID              = $_POST["idBox"];
            $coordinates        = $_POST["coordinates"];
        
            // Prepare and bind the update query for the property
            $updatePropQuery = oci_parse($conn, "UPDATE property 
                SET prop_name = :prop_name, 
                    prop_acre = :prop_acre, 
                    prop_con_type = :prop_con_type, 
                    prop_desc = :prop_desc, 
                    prop_date = :prop_date_con, 
                    prop_pub_acc = :prop_pub_access, 
                    prop_con_status = :prop_con_status, 
                    prop_is_owned = :prop_is_owned 
                WHERE prop_id = :id");
        
            oci_bind_by_name($updatePropQuery, ":prop_name", $property_name);
            oci_bind_by_name($updatePropQuery, ":prop_acre", $property_acre);
            oci_bind_by_name($updatePropQuery, ":prop_con_type", $property_con_type);
            oci_bind_by_name($updatePropQuery, ":prop_desc", $property_desc);
            oci_bind_by_name($updatePropQuery, ":prop_date_con", $property_date_con);
            oci_bind_by_name($updatePropQuery, ":prop_pub_access", $property_pub_access);
            oci_bind_by_name($updatePropQuery, ":prop_con_status", $property_con_status);
            oci_bind_by_name($updatePropQuery, ":prop_is_owned", $property_is_owned);
            oci_bind_by_name($updatePropQuery, ":id", $theID);
        
            if (!oci_execute($updatePropQuery, OCI_COMMIT_ON_SUCCESS)) {
                $e = oci_error($updatePropQuery);
                echo json_encode(["message" => "Failed to execute query", "error" => $e]);
                exit;
            }
            oci_free_statement($updatePropQuery);
        
            // Update coordinates if provided
            if (!empty($coordinates)) {
                foreach ($coordinates as $coord) {
                    $updateCoordQuery = oci_parse($conn, "UPDATE coordinates 
                        SET x_coord = :x_coord, 
                            y_coord = :y_coord 
                        WHERE prop_id = :id AND ord_num = :ord_num");
        
                    oci_bind_by_name($updateCoordQuery, ":x_coord", $coord['x_coord']);
                    oci_bind_by_name($updateCoordQuery, ":y_coord", $coord['y_coord']);
                    oci_bind_by_name($updateCoordQuery, ":id", $theID);
                    oci_bind_by_name($updateCoordQuery, ":ord_num", $coord['ord_num']);
        
                    oci_execute($updateCoordQuery, OCI_COMMIT_ON_SUCCESS);
                    oci_free_statement($updateCoordQuery);
                }
            }
        
            oci_close($conn);
            echo "Property and coordinates updated successfully!";
            header("Location: index.php");
            exit;
    }
    elseif (strcmp($theCrud, "delete") == 0) {
        $theID = trim(htmlspecialchars($_POST["idBox"]));
    
        // Delete coordinates
        $deleteQueryCo = oci_parse($conn, "DELETE FROM coordinates WHERE prop_id = :id");
        oci_bind_by_name($deleteQueryCo, ":id", $theID);
        if (!oci_execute($deleteQueryCo, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($deleteQueryCo);
            echo json_encode(["message" => "Failed to delete coordinates", "error" => $e]);
            oci_free_statement($deleteQueryCo);
            oci_close($conn);
            exit;
        }
        oci_free_statement($deleteQueryCo);
    
        // Delete media records
        $deleteQueryM = oci_parse($conn, "DELETE FROM media WHERE prop_id = :id");
        oci_bind_by_name($deleteQueryM, ":id", $theID);
        if (!oci_execute($deleteQueryM, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($deleteQueryM);
            echo json_encode(["message" => "Failed to delete media", "error" => $e]);
            oci_free_statement($deleteQueryM);
            oci_close($conn);
            exit;
        }
        oci_free_statement($deleteQueryM);
    
        // Delete the property record
        $deleteQuery = oci_parse($conn, "DELETE FROM property WHERE prop_id = :id");
        oci_bind_by_name($deleteQuery, ":id", $theID);
        if (!oci_execute($deleteQuery, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($deleteQuery);
            echo json_encode(["message" => "Failed to delete property", "error" => $e]);
            oci_free_statement($deleteQuery);
            oci_close($conn);
            exit;
        }
        oci_free_statement($deleteQuery);
        oci_close($conn);
    
        // Redirect back to the home page after successful deletion
        header("Location: index.php");
        exit;
    }

    else{
        echo json_encode(["error" => "Invalid value for crud operation"]);
        exit(1);
    }
?>