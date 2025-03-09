<?php

/*
    geoJSON.php 

    This file handles any request to this file and always returns (if successful)
    an array of JSON objects that attempt to adhere to the geoJSON format.

    GET /hackathon/geoJSON.php 

    Returns -> 

*/

header('Content-type: application/json; charset: utf-16');

/* Imporant Variables */

$arrayOfJSON = [];

/*
// The following code is adapted from try-orcale-no-login.php 
// provided by Dr. Sharon Tuttle

$os_username = substr($_SERVER["CONTEXT_PREFIX"], 2);

// but the Oracle account you can log into is your username plus
//    _php

$ora_php_username = "{$os_username}_php";

// but to ask to use blah_php's password to log in as blah,
// we need to express it in the form BLAH_PHP[BLAH]

$conn_username = "{$ora_php_username}[{$os_username}]";

// grab the password from this user's .oraauth

$ora_php_password =
    trim(file_get_contents("/home/{$os_username}/.oraauth"));

// oci_connect expects a username,
//    then a password,
//    then a connection string (can be null in this particular approach,
//                              so PHP can build it from env variables),
//    then the desired character encoding (we'll use "AL32UTF8"),
//    then the desired session mode (we'll use the default, the constant
//                                   OCI_DEFAULT)

$conn = oci_connect($conn_username, $ora_php_password, null,
                    "AL32UTF8", OCI_DEFAULT);

*/
require_once("conn.php");
$conn = hum_conn_no_login();

if (! $conn)
{
    echo json_encode(["message" => "Failed to connect to database"]);

    // exit this PHP now -- this is reasonable
    //     when you have hit an error and there is NO
    //     point in going forward
    
    exit;
}
/* Test stuff
$check = oci_parse($conn, "select count(*) from property");

oci_execute($check, OCI_DEFAULT);

oci_fetch($check);

$test = oci_result($check, 1);

oci_free_statement($check);
  
echo $test;
*/

$all_props_query_stmt = oci_parse($conn, "select * from property");

if (!oci_execute($all_props_query_stmt, OCI_DEFAULT)) {
    $e = oci_error($all_props_query_stmt);
    echo json_encode(["message" => "Failed to execute query", "error" => $e]);
    exit;
}

// loop through all rows of all props
while (oci_fetch($all_props_query_stmt)) {

    $tempID = oci_result($all_props_query_stmt, "PROP_ID");
    $tempName = oci_result($all_props_query_stmt, "PROP_NAME");
    $tempType = oci_result($all_props_query_stmt, "PROP_TYPE");
    $tempAcre = oci_result($all_props_query_stmt, "PROP_ACRE");
    $tempConType = oci_result($all_props_query_stmt, "PROP_CON_TYPE");
    $tempDesc = oci_result($all_props_query_stmt, "PROP_DESC");
    $tempDate = oci_result($all_props_query_stmt, "PROP_DATE");
    $tempPubAcc = oci_result($all_props_query_stmt, "PROP_PUB_ACC");
    $tempGeoType = oci_result($all_props_query_stmt, "PROP_GEO_TYPE");
    $tempConStatus = oci_result($all_props_query_stmt, "PROP_CON_STATUS");
    $tempIsOwned = oci_result($all_props_query_stmt, "PROP_IS_OWNED");

    $coordArray = [];

    $prop_coords_query_stmt = oci_parse($conn, "select x_coord, y_coord
                                         from coordinates
                                         where prop_id = $tempID
                                         order by ord_num");

    if (!oci_execute($prop_coords_query_stmt, OCI_DEFAULT)) {
        $e = oci_error($prop_coords_query_stmt);
        echo json_encode(["message" => "Failed to execute coordinates query", "error" => $e]);
        exit;
    }

    // loop through all rows of coords that go with curr prop
    while (oci_fetch($prop_coords_query_stmt)) {

        $tempX = oci_result($prop_coords_query_stmt, "X_COORD");
        $tempY = oci_result($prop_coords_query_stmt, "Y_COORD");

        $coordArray[]= [$tempX, $tempY];
    }

    //$coordArray[] = $coordArray[0]; //obselete

    if ($tempGeoType != "Point"){
        $tempJSON = array(
            "type" => $tempType,
            "properties" => array(
                "id" => $tempID,
                "name" => $tempName,
                "acres" => $tempAcre,
                "conservationType" => $tempConType,
                "description" => $tempDesc,
                "publicAccess" => $tempPubAcc,
                "dateConserved" => $tempDate,
                "conservationStatus" => $tempConStatus,
                "isOwned" => $tempIsOwned
            ),
            "geometry" => array(
                "type" => $tempGeoType,
                "coordinates" => array($coordArray)
            ));
    }
    else{
        $tempJSON = array(
            "type" => $tempType,
            "properties" => array(
                "id" => $tempID,
                "name" => $tempName,
                "acres" => $tempAcre,
                "conservationType" => $tempConType,
                "description" => $tempDesc,
                "publicAccess" => $tempPubAcc,
                "dateConserved" => $tempDate,
                "conservationStatus" => $tempConStatus,
                "isOwned" => $tempIsOwned
            ),
            "geometry" => array(
                "type" => $tempGeoType,
                "coordinates" => array($coordArray[0][0], $coordArray[0][1])
        ));
    }

    $arrayOfJSON[] = $tempJSON;
}


//echo count($arrayOfJSON);


echo json_encode($arrayOfJSON, JSON_NUMERIC_CHECK);

?>