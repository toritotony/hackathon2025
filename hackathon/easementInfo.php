<?php

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

if (! $conn)
{
    echo json_encode(["message" => "Failed to connect to database"]);

    // exit this PHP now -- this is reasonable
    //     when you have hit an error and there is NO
    //     point in going forward
    
    exit;
}

$all_props_query_stmt = oci_parse($conn, "select * from property");

if (!oci_execute($all_props_query_stmt, OCI_DEFAULT)) {
    $e = oci_error($all_props_query_stmt);
    echo json_encode(["message" => "Failed to execute query", "error" => $e]);
    exit;
}


while (oci_fetch($all_props_query_stmt)) {

    $tempID = oci_result($all_props_query_stmt, "PROP_ID");
    $tempName = oci_result($all_props_query_stmt, "PROP_NAME");
    $tempAcre = oci_result($all_props_query_stmt, "PROP_ACRE");
    $tempConType = oci_result($all_props_query_stmt, "PROP_CON_TYPE");

    if ($tempConType == null){
        $tempConType = "Unknown";
    }

    $tempDesc = oci_result($all_props_query_stmt, "PROP_DESC");
    $tempDate = oci_result($all_props_query_stmt, "PROP_DATE");
    $tempPubAcc = oci_result($all_props_query_stmt, "PROP_PUB_ACC");

    if ($tempPubAcc == 0){
        $tempPubAcc = "Private";
    }
    else {
        $tempPubAcc = "Public";
    }

    $tempConStatus = oci_result($all_props_query_stmt, "PROP_CON_STATUS");
    $tempIsOwned = oci_result($all_props_query_stmt, "PROP_IS_OWNED");
?>

<li class="easement-box">
    <a href="#" class="easement-item"
        data-title="<?= $tempName ?>"
        data-size="<?= $tempAcre ?> acres"
        data-type="<?= $tempConType ?>"
        data-access="<?= $tempPubAcc ?>"
        data-id = "p<?= $tempID ?>">
        <?= $tempName ?>
    </a>
</li>
<?php
}
?>