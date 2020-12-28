<?php

// Database connection
session_start();
$server = "localhost";
$username = "root";
$password = "";
$dbname = "misc";
$message="";
$conn = new PDO("mysql:host=$server; dbname=$dbname", $username, $password);  
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
	$_SESSION['p_id'] =$_GET['id'];  // get id through query string
	$uid=$_SESSION['user_id'];

if(isset($_POST["cancel"]))  
      { 
		header("location:index.php"); 
	  }
if(isset($_POST["Save"]))  { 
		
	
		$fname=htmlentities($_POST["first_name"]);
		$lname=htmlentities($_POST["last_name"]);
		$headline=htmlentities($_POST["headline"]);
		$email=htmlentities($_POST["email"]);
		$summary=htmlentities($_POST["summary"]);
		$query = "UPDATE profile SET  user_id=:uid ,first_name=:fname,last_name=:lname,email=:email,headline=:headline
		,summary=:summary WHERE profile_id = :id";
		 
		try{
		$statement = $conn->prepare($query);  
        $statement->execute(array( 
						'uid'       =>     $uid,
						'fname'     =>     $fname,  
						'lname'     =>     $lname,
                        'email'     =>     $email,
						'headline'  =>     $headline,
                        'summary'   =>     $summary,
						'id'        =>     $_SESSION['p_id'])); 
		$statement=null;
		
		$_SESSION['toast']='profile Edited';
		header("location:index.php"); 
		}
		catch(PDOException $error){
			$_SESSION['error']='Unable to edit';	
		}
		
 }
 ?>
 
 <!DOCTYPE html>
<html>
<head>
<title>Aleena C R</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<?php
if(isset($_SESSION["user_id"]))  
	{
		
?>

<h1>Adding Profile for <?php echo $_SESSION["name"];
	try{
	$id=$_SESSION['p_id'];
	$sql = "SELECT profile_id,first_name,last_name,email,headline,summary FROM profile WHERE profile_id='$id'";
	$q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
	$row = $q->fetch();
	if ( $row !== false ) {
?></h1>
 
<form method="POST" >
<label for="frist_name" >Frist Name :</label>
<input type="text" name="first_name" id="f_name" style="width:500px;" value="<?php echo $row['first_name']; ?>"><br/><br/>
<label for="last_name">Last Name :</label>
<input type="text" name="last_name" id="l_name" style="width:500px;" value="<?php echo $row['last_name']; ?>"><br/><br/>
<label for="email">Email :</label>
<input type="text" name="email" id="email" style="width:500px;" value="<?php echo $row['email']; ?>"><br/><br/>
<label for="headline">Headline :</label>
<input type="text" name="headline" id="headline" style="width:500px;" value="<?php echo $row['headline']; ?>"><br/><br/>
<label for="summary">Summary :</label><br><br/>
<textarea  name="summary" id="summary" rows="10" cols="100" >
<?php echo $row['summary']; ?>
</textarea><br/><br/>



<input type="submit"  value="Save" name="Save" onclick="return doValidate();" >
<input type="submit" name="cancel" value="Cancel">
</form>
<?php  }  
                else  
                {  
                     $message = '<label>Invalid Data</label>';  
                } 
} catch(PDOException $error)  
 {  
      echo $error->getMessage();  
 } }?>
</div>
<!--<script>
function doValidate() {
    console.log('Checking...');
    try {
        first_name = document.getElementsByName('first_name')[0].value;
        last_name = document.getElementsByName('first_name')[0].value;
		email = document.getElementsByName('email')[0].value;
		headline = document.getElementsByName('headline')[0].value;
		summary = document.getElementsByName('summary')[0].value;
        console.log("Checking all feilds.....");
        if (first_name == null || first_name == "" || last_name == null || last_name == ""|| email == null 
		|| email == ""|| headline == null || headline == ""|| summary == null || summary == "") {
            alert("All values are required");
            return false;
        }
        if ( email.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script> edit-->
</body>
</html>
