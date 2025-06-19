
<!DOCTYPE HTML>
<html>
<title>Reset Your Password</title>
<head>
<link rel="icon" href="../favicon.png" type="image/ico" sizes="32x32">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<header>
</header>

<body>
<div class="container padding-bottom-3x mb-2 mt-5">
	    <div class="row justify-content-center">
	        <div class="col-lg-8 col-md-10">
	            <div class="forgot">
				<h2>Forgot your password?</h2>
	                <p>Change your password in three easy steps. This will help you to secure your password!</p>
	                <ol class="list-unstyled">
	                    <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
	                    <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
	                    <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
	                </ol>
	            </div>

<div class="card-body">
<form method="POST" action="send-recovery-mail.php">
<h5>Enter your Email address</h5>
	<input type="email" name="email" class="input1"></br>
	<h6 class="small-font">Enter the email address you used during the registration on vip.translatesubtitles.co. Then we'll email a link to this address.</h6>
	<input type="submit" value="Send recovery email" class="btn btn-success"><a href="https://vip.translatesubtitles.co" class="btn btn-dark" role="button" aria-pressed="true">Back to Login</a>
</form>
	        </div>
	    </div>
	</div>

</body>
</html>






