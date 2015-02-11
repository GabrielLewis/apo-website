<?php
require_once ('session.php');
require_once ('mysql_access.php');
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

<div class="row">

<?php
if (!isset($_SESSION['sessionID'])) {
	echo '<div class="entry">You need to <a href="./login.php">login</a> before you can use this page.</div>';
} else {
	if (isset($_POST['update'])) {
		// Update Information
		$_POST = array_map('mysql_real_escape_string', $_POST);
		$user_id = $_SESSION['sessionID'];
$sql = <<<SQL
    UPDATE `contact_information`
    SET `firstname` = '$_POST[first_name]',
    	`lastname` = '$_POST[last_name]',
    	`homeaddress` = '$_POST[homeaddress]',
    	`citystatezip` = '$_POST[citystatezip]',
    	`localaddress` = '$_POST[local_address]',
    	`email` = '$_POST[email]',
    	`phone` = '$_POST[phone]',
    	`schoolyear` = '$_POST[school_year]',
    	`major` = '$_POST[major]',
    	`minor` = '$_POST[minor]',
    	`gradmonth` = '$_POST[grad_month]',
    	`gradyear` = '$_POST[grad_year]',
        `pledgesem` = '$_POST[pledgesem]',
        `pledgeyear` = '$_POST[pledge_year]',
        `famflower` = '$_POST[family_flower]',
        `bigbro` = '$_POST[bigbro]',
        `littlebro` = '$_POST[littlebro]',
        `status` = '$_POST[status]',
        `bday` = '$_POST[bday]',
        `bmonth` = '$_POST[bmonth]',
        `byear` = '$_POST[byear]',
        `active_sem` = '$current_semester',
        `hide_info` = 'F',
        `gender` = '$_POST[gender]',
        `race` = '$_POST[race]',
        `organizations` = '$_POST[organizations]'
    WHERE id = '$user_id' LIMIT 1
SQL;
		$result = $db->query($sql);
		$sql2 = "UPDATE `contact_information` SET visited = '1' WHERE id = '$user_id' LIMIT 1";
		$result2 = $db->query($sql2);
		//stupid code. causes error if nothing changed.
		//if (mysql_affected_rows() == 1) {
		//use this instead
		if($result && $_POST['race'] != "" && $_POST['gender'] != 0){
			echo "Your information has been updated.  Click <a href='./updateinfo.php'>here</a> to make more changes. ";
			$_SESSION['active_sem'] = $current_semester;
			echo $_SESSION['active_sem'];
		} else {
			echo "There may have been an error.  Click <a href='./updateinfo.php'>here</a> to try again.";
			$_SESSION['active_sem'] = $current_semester;
			echo $_SESSION['active_sem'];
		}
	} else {
		$user_id = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `contact_information` WHERE `id` = '$user_id' LIMIT 1";
		$result = $db->query($sql);
		$row = mysqli_fetch_array($result);
		$b_day = mktime(0, 0, 0, $row['bmonth'], 1, 2000);
		$month = date('F', $b_day);
		$selected = $row['hide_info'];
		if($selected == 'F'){
			$selectedF = "checked=\"yes\"";
			$selectedT = "";
		}else{
			$selectedF = "";
			$selectedT = "checked=\"yes\"";
		}
		$gender = $row['gender'];
		if($gender == 2){
			$genderF = "";
			$genderM = "checked=\"yes\"";
		}else if($gender == 1){
			$genderM = "";
			$genderF = "checked=\"yes\"";
		}else{
			$genderM = "";
			$genderF = "";
		}
//List organizations
function list_orgs(){
	include ('mysql_access.php');
$select_orgs = <<<SQL
	SELECT `name`, `id`
	FROM `organizations`
	ORDER BY `name`
	ASC
SQL;
	$query_orgs = $db->query($select_orgs) or die("There was a problem querying the organizations. Contact the webmaster.");
	$i = 1;
	while ($orgs = mysqli_fetch_array($query_orgs)) {
		echo "<option id='$orgs[id]''>$orgs[name]</option>";
		$i = $i + 1;
	}
}
//Force update
	$force = "";
	if (isset($_GET['forced']) == "true") {
		$force = "<div style='margin: 50px; padding: 10px; background: #F08080; '><h1 style='color:red;'>Please update your information for this semester.</h1> Do you have any new <b>Littles</b>, different <b>status</b>, have a new <b>local address</b>, or change your <b>major</b> recently?  You will not be able to access the site until you have clicked 'Update' below.  If you have problems, contact the webmaster!</div>";
	}
echo<<<END
	<h1>Status Change</h1>
	$force
	<p>Please fill out the form to change your status.</p>
	<p>Please verify <b>ALL</b> fields</p>
		<form method="POST">
			<div class='row'>
			<div class='large-6 medium-6 small-12 column'>
				<b>Personal</b>
					<label for="first_name">First Name</label>
						<input type="text" name="first_name" value="$row[firstname]" placeholder="First name" required="" autocomplete="name"/>
					<label for="last_name">Last Name</label>
						<input type="text" name="last_name" value="$row[lastname]" placeholder="Last name" required="" autocomplete="name"/>
				<br>
				<b>Contact</b><br>
					<label for="email">Email</label>
						<input type="text" name="email" value="$row[email]" placeholder="name@example.com" required="" autocomplete="email"/>
					<label for="phone">Phone</label>
						<input type="text" name="phone" value="$row[phone]" placeholder="+1-555-555-1234" required="" pattern="^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$" autocomplete="tel"/>
					<label for="local">Local Address</label>
						<input type="text" name="local_address" value="$row[localaddress]" pattern="[a-zA-Z\d\s\-\,\#\.\+]+" placeholder="123 Any Street" autocomplete="Local street-address"/>
					<label for="perm">Permanent Address</label>
						<input type="text" name="homeaddress" value="$row[homeaddress]" pattern="[a-zA-Z\d\s\-\,\#\.\+]+" placeholder="123 Any Street" autocomplete="Permanent street-address"/>
					<label for="perm"></label>
						<input type="text" name="citystatezip" value="$row[citystatezip]" placeholder="Kirksville, MO 63501"/>
					<!--
					<b>Hide Contact Info</b><br>
					Yes<input type="radio" name="hide_info" value="T" $selectedT/><br>
					No<input type="radio" name="hide_info" value="F" $selectedF/>
					<br>
					-->
				<b>Organizations</b><br>
					<lable for="organizations">Outside of APO</label>
					<select name="organizations" id="organizations">
END;
						list_orgs();
echo<<<END
					</select>
			</div>
			<div class='large-6 medium-6 small-12 column'>
				<b>Nationals Reporting</b>
				<br>
					<label for="gender">Gender<br></label>
					Male<input type="radio" name="gender" value="2" $genderM/>
					Female<input type="radio" name="gender" value="1" $genderF/>
				<br>
				<label for="race">Race/Ethnicity</label>
				<select name="race" id="race">
					<option value="$row[race]">$row[race]</option>
				    <option value="White/Caucasian">White/Caucasian</option>
				    <option value="Hispanic">Hispanic</option>
				    <option value="American Indian or Alaskan Native">American Indian or Alaskan Native</option>
					<option value="Asian">Asian</option>
					<option value="Black or African-American">Black or African-American</option>
					<option value="Native Hawaiian or Other Pacific Islander">Native Hawaiian or Other Pacific Islander</option>
					<option value="Mixed Race">Mixed Race</option>
				    <option value="Prefer not to say">Prefer not to say</option>
				</select>
				<br>
				<b>APO</b>
				<br>
					<label for="pledgesem">Pledge Semester</label>
						<select name="pledgesem">
							<option value="$row[pledgesem]">$row[pledgesem]</option>
							<option value="Fall">Fall</option>
							<option value="Spring">Spring</option>
						</select>
						<select name="pledge_year">
							<option value="$row[pledgeyear]">$row[pledgeyear]</option>
							<option value="2015">2015</option>
							<option value="2014">2014</option>
							<option value="2013">2013</option>
							<option value="2012">2012</option>
							<option value="2011">2011</option>
							<option value="2010">2010</option>
						</select>
					<label for="family_flower">Flower</label>
						<select name="family_flower">
							<option>$row[famflower]</option>
							<option value="Pink Carnation">Pink Carnation</option>
							<option value="Red Carnation">Red Carnation</option>
							<option value="Red Rose">Red Rose</option>
							<option value="White Carnation">White Carnation</option>
							<option value="White Rose">White Rose</option>
							<option value="Yellow Rose">Yellow Rose</option>
						</select>
					<label for="status">Status</label>
						<select name="status">
							<option>$row[status]</option>
							<option value="Active">Active</option>
							<option value="Associate">Associate</option>
							<option value="Pledge">Pledge</option>
							<option value="Alumni">Alumni</option>
							<option value="Early Alum">Early Alum</option>
							<option value="Exec">Executive</option>
							<option value="Advisor">Advisor</option>
							<option value="Inactive">Inactive</option>
						</select>
					<label for="bigbro">Big Brothers</label>
					<textarea name="bigbro" placeholder="First Last, First Last, etc">$row[bigbro]</textarea>
					<label for="lilbro">Little Brothers</label>
					<textarea name="littlebro" placeholder="First Last, First Last, etc">$row[littlebro]</textarea>
					<b>School</b><br>
						<label name="major">Major</label>
							<input type="text" name="major" value="$row[major]"/>
						<label for="minor">Minor</label>
							<input type="text" name="minor" value="$row[minor]"/>
						<label for="grad_month">Graduation Date</label>
							<select name="grad_month">
								<option>$row[gradmonth]</option>
								<option value="May">May</option>
								<option value="August">August</option>
								<option value="December">December</option>
							</select>
							<select name="grad_year">
								<option>$row[gradyear]</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
							</select>
						<label for="school_year">Year</label>
							<select name="school_year">
								<option>$row[schoolyear]</option>
								<option>Freshman</option>
								<option>Sophomore</option>
								<option>Junior</option>
								<option>Senior</option>
								<option>Alumni</option>
								<option>Other</option>
							</select>
			</div>
			<div class='row'>
			<br>
			<input type="hidden" name="update" value="1"/>
			<p align='center'>
				<input type="submit" value="Update" style="font-size: 50px;"/>
			</div>
		</form>
END;
	}
}
?>

</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>