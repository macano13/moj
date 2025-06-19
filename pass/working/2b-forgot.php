<!DOCTYPE html>
<html>
  <head>
    <title>
      Password Reset Request Demo
    </title>
  </head>
  <body>
    <!-- (A) PASSWORD RESET FORM -->
    <form method="post" target="_self">
      Email:
      <input type="email" name="email" required value="john@doe.com"/>
      <input type="submit" value="Reset Password"/>
    </form>

    <!-- (B) PROCESS PASSWORD RESET REQUEST -->
    <?php 
    if (isset($_POST['email'])) {
      // (B1) CONNECT TO DATABASE
      require "2a-common.php";

      // (B2) CHECK IF VALID USER
      $stmt = $pdo->prepare("SELECT * FROM `tbl_users` WHERE `email`=?");
      $stmt->execute([$_POST['email']]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $result = is_array($user)
              ? "" 
              : $_POST['email'] . " is not registered." ;

      // (B3) CHECK PREVIOUS REQUEST (PREVENT SPAM)
      if ($result == "") {
        $stmt = $pdo->prepare("SELECT * FROM `password_reset` WHERE `id`=?");
        $stmt->execute([$user['id']]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);
        $now = strtotime("now");
        if (is_array($request)) {
          $expire = strtotime($request['reset_time']) + $prvalid;
          if ($now < $expire) { $result = "Please try again later"; }
        }
      }

      // (B4) CHECKS OK - CREATE NEW RESET REQUEST
      if ($result == "") {
        // RANDOM HASH
        $hash = md5($user['email'] . $now);
        
        // DATABASE ENTRY
        $stmt = $pdo->prepare("REPLACE INTO `password_reset` VALUES (?,?,?)");
        $stmt->execute([$user['id'], $hash, date("Y-m-d H:i:s")]);
        
        // SEND EMAIL
        $subject = "Password reset";
        $link = "https://vip.translatesubtitles.co/pass/2c-reset.php?i=".$user['id']."&h=".$hash;
		$message = "Click on the link to reset the password: $link";
        if (!@mail($user['email'], $subject, $message)) {
          $result = "Failed to send email!";
        }
      }
      
      // (B5) RESULTS
      if ($result=="") { $result = "Email has been sent - Please click on the link in the email to confirm."; }
      echo "<div>$result</div>";
    }
    ?>
  </body>
</html>