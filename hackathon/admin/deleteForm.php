<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<!-- class HTML template: last modified 2025-01-29 -->

<!--
    by:
    last modified:

    you can run this using the URL:

-->

<head>
    <title> Admin Tools</title>
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
    <h1>Admin Delete Tool</h1>
    <form method="post" action="parser.php">
        <!--
    <p>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>
    </p>
    <p>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
    </p>
         -->
    <p>
        <label for="propName">Enter Name</label>
        <input type="text" name="propName" id="propName" placeholder="Name of Property" required="required" />
    </p>
    <p>
        <label for="idBox">Enter ID </label>
        <input type="number" name="idBox" id="idBox" placeholder="ID" required="required" required max="99" />
    </p>
    <p><strong>Clicking submit will delete everyting related that property</strong></p>
    <p>
        <label for="verification">Are you sure</label>
        <input type="checkbox" id="verification" name="verify" required="required" />
    </p>
    <input type="hidden" name="crud" value="delete" />
    <input type="submit" />

    <footer>
        </br>
        <button>
            <a href="index.php"style="text-decoration: none; color: black;">Home Page</a>
        </button>
    </footer>
    
</body>
</html>

