<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->


<div class="row">
        <div class="large-8 medium-6 small-12 columns">
            <h2>APO Region 8 Conference </h2>
            <h3>Date of Conference Here</h3>
            <br>
            <p>Nice little blurb about the conference here</p>
        </div>
        <div class="small-6 columns">
            <a href="register.php" class="button">Register</a>
        </div>
        <div class="small-6 columns">
            <a href="login.php" class="button">Login</a>
        </div>
    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>