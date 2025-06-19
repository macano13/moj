<!DOCTYPE HTML>
<html>
<title>Reset Password</title>
<head>
<link rel="icon" href="../favicon.png" type="image/ico" sizes="32x32">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<header>
</header>
<body>
<?php

$email = $_GET["email"];
$reset_token = $_GET["reset_token"];

$connection = mysqli_connect("localhost", "c1uploading1", "#Stomornjak111", "c1zvizdoDB");

$sql = "SELECT * FROM tbl_users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$user = mysqli_fetch_object($result);
	if ($user->reset_token == $reset_token)
	{
		?>
		<div class="container padding-bottom-3x mb-2 mt-5">
	    <div class="row justify-content-center">
	        <div class="col-lg-8 col-md-10">
			<div class="card-body">
			
		<form method="POST" action="new-password.php">
			<input type="hidden" name="email" value="<?php echo $email; ?>">
			<input type="hidden" name="reset_token" value="<?php echo $reset_token; ?>">
			
			<input class="input1" type="password" name="new_password" placeholder="Enter new password"><br/><br/>
			<input class="btn btn-success pass-new" type="submit" value="Change password"> 
		</form>
		</div>
		</div>
		</div>
		</div>
		<?php
	}
	else
	{
		echo '<span style="background: red;border-radius: 5px;color: white;display:flex;justify-content:center;max-width:500px;line-height:5vh;margin:auto;margin-top:50px;font-weight:600;
">Recovery email has been expired</span>';
	}
}
else
{
	echo '<span style="background: red;border-radius: 5px;color: white;display:flex;justify-content:center;max-width:500px;line-height:5vh;margin:auto;margin-top:50px;font-weight:600;
">Email does not exists</span>';
}
?>

</body>
</hmtl>