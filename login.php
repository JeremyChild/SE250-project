<!--login.php-->

<?php
//sara hartley - page format and content
//krithik raja - sql database connection and modification
require_once "config.php";

$conn=mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); //seems like in order to insert data, you need to connect to the databse regardless if the config file already did
    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }
session_start();
$preError = "Enter your login information to continue.";		//Condition
if ($_SERVER["REQUEST_METHOD"] == "POST") { 					//catches POST
	if((empty($_POST['username'])) or (empty($_POST['password']))){
		$error = "You are missing some of the information. Please try again.";
	}
    else
    {
		//TODO:Database Validation code
        $myusername = mysqli_real_escape_string($conn,$_POST['username']);
        $mypassword = mysqli_real_escape_string($conn,$_POST['password']); 
        $sqlquery = "SELECT * FROM account WHERE user='$myusername' AND password='$mypassword'";
        $result = mysqli_query($conn,$sqlquery);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);
        // If result matched $myusername and $mypassword, table row must be 1 row 
        if($count == 1) {
            $_SESSION['username'] = $myusername;
  	        $_SESSION['success'] = "You are now logged in";
  	        header('location: order.php');
        }else {
            $error = "Your Login Name or Password is invalid";
        }
    }
		// $username = test_input($_POST['username']);
        // $password = test_input($_POST['password']);
        // $sql = "SELECT username, password FROM account WHERE username = $username";
		// $tempBool = true;
		// if ($tempBool==true){
		// 	header('Location: order.php');
		// }else{
		// 	$error = "There was a Problem processing your order. Please contact the administration";
		// }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<body>

<h1>SCSU Pizzeria</h1>

<h2>Welcome to the SCSU Pizzeria</h2>

<p>
  <label>
    <?php if (isset($error)) {
      echo $error;
    } else {
      echo $preError;
    } ?>
  </label>
</p>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<!--<form method = "Post" action = "order.php">--> 				<!-- Skips condition-->
	<label for="username">Username:</label><br>
	<input type="text" id="username" name="username"><br>
	<label for="pwd">Password:</label><br>
	<input type="password" id="pwd" name="password"><br><br>
	<input type="submit" value="Login"/> <br><br>
</form>

<form method = "Post" action = "createAccount.php">
	<input type="submit" value="Create Account"/><br><br>
</form>

</body>
</html>