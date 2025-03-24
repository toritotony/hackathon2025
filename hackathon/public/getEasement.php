<?php
if (isset($_GET['id'])) {
    // Sanitize cause people are scary
    $id = $_GET['id'];
    $id = trim($id);
    $id = htmlspecialchars($id);
    $id = ltrim($id, $id[0]);

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

    $some_props_query_stmt = oci_parse($conn, "select prop_name, prop_desc, prop_acre, prop_con_type from property where prop_id = $id");

    if (!oci_execute($some_props_query_stmt, OCI_DEFAULT)) {
        $e = oci_error($some_props_query_stmt);
        echo json_encode(["message" => "Failed to execute query", "error" => $e]);
        exit;
    }

    oci_fetch($some_props_query_stmt);

    $propName = oci_result($some_props_query_stmt, "PROP_NAME");
    $propDesc = oci_result($some_props_query_stmt, "PROP_DESC");
    $propAcre = oci_result($some_props_query_stmt, "PROP_ACRE");

    if ($propAcre == 0){
        $propAcre = "Unknown Size";
    }

    $propConType = oci_result($some_props_query_stmt, "PROP_CON_TYPE");

    $wordImage = "image";

    $image_query_stmt = oci_parse($conn, "select media_url from media where prop_id = $id and media_type = 'image'");

    
    if (!oci_execute($image_query_stmt, OCI_DEFAULT)) {
        $e = oci_error($image_query_stmt);
        echo json_encode(["message" => "Failed to execute query", "error" => $e]);
        exit;
    }

    $imageArray = [];

    while(oci_fetch($image_query_stmt)){
        $url = oci_result($image_query_stmt, "MEDIA_URL");
        $imageArray[] = $url;
    }


    ?>
        <span class="close-button">&times;</span>
        <!--<img src="" alt="Image of ">-->

        <?php
        /* If only one image, just do that */
        if (sizeof($imageArray) == 1){
            ?>
            <img src="<?=$imageArray[0]?>" alt="Image of <?=$propName?>">
        <?php
        }
        else if (sizeof($imageArray) == 0){
            
        }
        else {
        ?>
        <div class="slideshow-container">
        <?php
            
            for ($index = 0; $index < sizeof($imageArray); $index++){
                
                $currImg = $imageArray[$index];
                ?>
                <div class="mySlides fade">
                <div class="numbertext"><?=$index + 1?> / <?=sizeof($imageArray)?></div>
                <img class="slide-img" src="<?=$currImg?>" style="width:100%" alt="Image of <?=$propName?>">
                </div>
            <?php 
            }
            ?>
            
            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>

            </div>
        <br>

        <div style="text-align:center">
        <?php

            for ($index = 0; $index < sizeof($imageArray); $index++){
                
                ?>
                <span class="slide-dot" onclick="currentSlide(<?=$index?>)"></span>
                <?php
            }
        ?>
        </div>
        <?php
        }?>


        <h1><?=$propName?></h1>
        <h2>Conservation Type: <?=$propConType?></h2>
        <h2>Acres: <?=$propAcre?></h2>
        <p><?=$propDesc?></p>

        


    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
        showSlides(slideIndex += n);
        }

        function currentSlide(n) {
        showSlides(slideIndex = n);
        }

        function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("slide-dot");
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" slide-active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " slide-active";
        }
    </script>

    <?php
    }
else {
    echo json_encode(["message" => "No argument given"]);
}?>