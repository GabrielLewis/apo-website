<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>
    <div class="row">
        <div class="large-6 medium-9 small-12 small-centered columns text-center">
            <h1> Fall 2011</h1>
                <p>  <br>
                <a href="#" ></a>
                </p>
<?php 
$selectm = "SELECT firstname, lastname, major, minor, status, position, pledgesem, pledgeyear FROM contact_information WHERE pledgesem=Fall AND pledgeyear=2011 ORDER BY lastname ASC, firstname ASC";	
$querym = $db->query($selectm) or die("If you encounter problems, please contact the webmaster.");
while ($t = mysqli_fetch_array($querym)){
	echo "<p>" . $t['firstname'] . " " . $t['lastname'] . "</p>";
}
?>
            <hr>
            <h1> Spring 2012 </h1>
                <p>  <br>
                <a href="#"></a></p>
            <hr>
            <h1> Fall 2012 </h1>
                <p> <br>
                <a href="#"></a>
                </p>
            <hr>
            <h1> Spring 2013 </h1>
                <p>  <br>
                <a href="#"></a>
                </p>
            <hr>
            <h1> Fall 2013 </h1>
                <p> <br>
                <a href="#"></a>
                </p>
            <hr>
            <h1> Spring 2014 </h1>
                <p> <br>
                <a href="#"></a>
                </p>
            <hr>
            <h1> Fall 2014 </h1>
                <p>  <br>
                <a href="#"></a>
                </p>
            <hr>
            <h1> Spring 2015 </h1>
                <p>  <br>
                <a href="#"></a>
                </p>
           
        </div>
</body>
</html>
