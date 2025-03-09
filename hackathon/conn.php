<?php
    /*-----
        Adapted from hum_conn_no_login.php provided by Dr. Sharon Tuttle

        function: hum_conn_no_login: void -> connection
        purpose: expects nothing,

            has the side-effect of trying to connect to
            Humboldt's Oracle student database using the new
            no-end-user-login approach (logging in based on where
            the PHP file resides),

            and, if successful, returns the resulting connection object,

            but, if NOT successful, ENDS the document and exits the
            current PHP document...! (yes, it can do that...!)

        last modified: 2025-03-09
    -----*/

    function hum_conn_no_login()
    {
        // get part of the username from where this is installed

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

        $connectn = oci_connect($conn_username, $ora_php_password, null,
                               "AL32UTF8", OCI_DEFAULT);

        if (! $connectn)
        {
            echo json_encode(["message" => "Failed to connect to database"]);

            // exit this PHP now -- this is reasonable
            //     when you have hit an error and there is NO
            //     point in going forward

            exit;
        }

        // if reach here, I connected!

        return $connectn;
    }
?>