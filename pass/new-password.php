<!DOCTYPE HTML>
<html>
<title>New Password Sent</title>
<head>
<link rel="icon" href="../favicon.png" type="image/ico" sizes="32x32">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<header>
</header>
<body>
<?php

$email = $_POST["email"];
$reset_token = $_POST["reset_token"];
$new_password = $_POST["new_password"];

$connection = mysqli_connect("localhost", "c1uploading1", "#Stomornjak111", "c1zvizdoDB");

$sql = "SELECT * FROM tbl_users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$user = mysqli_fetch_object($result);
	if ($user->reset_token == $reset_token)
	{
		$sql = "UPDATE tbl_users SET reset_token='', password='$new_password' WHERE email='$email'";
		mysqli_query($connection, $sql);

		echo '<span style="background: green;border-radius: 5px;color: white;display:flex;justify-content:center;max-width:500px;line-height:5vh;margin:auto;margin-top:50px;font-weight:600;
">Password has been changed</span>';
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
<a href="https://vip.translatesubtitles.co" class="btn btn-dark sent-msg" role="button" aria-pressed="true">Back to Login</a>
</body>
</hmtl>