<?php include "before_content.code"; include "errors.php"; ?>

<!DOCTYPE HTML>  
<html>
<head>
<meta charset="UTF-8">
<style>
.required {color: #FF0000;}
</style>
</head>
<body> 

<?php

mb_internal_encoding('UTF-8');

session_start();

// define variables
$user_fname = $user_mname = $user_lname = $user_login = $user_email = $user_phone ="";
$check = false;
//define The entered
$evalidation = "Въведеното";

//Validation and POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["user_fname"])) {
       echo $arr[0][0][0];
  } else {
      $user_fname = corrector($_POST["user_fname"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$user_fname)) {
          echo '<br>'.("$evalidation '$user_fname' е грешно. ");
          echo $arr[0][1][0];
      }else{
        $_SESSION['personalInfo']['user_fname'] = $user_fname;
        $check = true;
      }
  }

  if (empty($_POST["user_lname"])) {
    echo '<br>'.$arr[0][0][2];
  } else {
      $user_lname = corrector($_POST["user_lname"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$user_lname)) {
          echo '<br>'.("$evalidation '$user_lname' е грешно. ");
          echo $arr[0][1][0];
      }else{
        $_SESSION['personalInfo']['user_lname'] = $user_lname;
        $check = true;
      }
    }

  if (empty($_POST["user_login"])) {
    echo '<br>'.$arr[0][0][3];
  } else {
      $user_login = corrector($_POST["user_login"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$user_login)) {
          echo '<br>'.("$evalidation '$user_login' е грешно. ");
          echo $arr[0][1][0];
      }else{
        $_SESSION['personalInfo']['user_login'] = $user_login;
        $check = true;
      }
    }


  if (empty($_POST["user_email"])) {
    echo '<br>'.$arr[0][0][4];
  } else {
      $user_email = corrector($_POST["user_email"]);
      if (!filter_var($user_email,FILTER_VALIDATE_EMAIL)) {
          echo '<br>'.$arr[0][1][1];
      }
      else{
        $_SESSION['personalInfo']['user_email'] = $user_email;
        $check = true;
      }
    }

  $user_mname = corrector($_POST['user_mname']);
  $_SESSION['personalInfo']['user_mname'] = $user_mname;

  $user_mname = corrector($_POST['user_phone']);
  $_SESSION['personalInfo']['user_phone'] = $user_mname;

  //Next step if there are no errors
  if($check){
    session_write_close();
    header('Location: address.php');
    exit;
  }
}// end request method
else {
  $user_fname = (isset($_SESSION['personalInfo']['user_fname'])) ? $_SESSION['personalInfo']['user_fname'] : '';
  $user_mname = (isset($_SESSION['personalInfo']['user_mname'])) ? $_SESSION['personalInfo']['user_mname'] : '';
  $user_lname = (isset($_SESSION['personalInfo']['user_lname'])) ? $_SESSION['personalInfo']['user_lname'] : '' ;   
  $user_login = (isset($_SESSION['personalInfo']['user_login'])) ? $_SESSION['personalInfo']['user_login'] : '' ; 
  $user_email = (isset($_SESSION['personalInfo']['user_email'])) ? $_SESSION['personalInfo']['user_email'] : '' ;  
  $user_phone = (isset($_SESSION['personalInfo']['user_phone'])) ? $_SESSION['personalInfo']['user_phone'] : '' ;  
    }

function corrector($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
?>

<fieldset><legend align="center">Въвеждане на данни за нов потрebител:</legend>
<table align="center"><tr><td>
<h2>Регистрационна форма</h2><br><br>
<p><span class="text"><i>Задължителните полета са обозначени с *.</i></span></p>
<form method="post" action="">
  
  Собствено име: <input type="text" autofocus="autofocus" required="required" title="Въведете собствено име" name="user_fname" value="<?php echo $user_fname;?>">
  <span class="required">*</span>
  <br><br>
  
  Бащино име: <input type="text" title="Въведете презиме" name="user_mname" value="<?php echo $user_mname;?>">
  <br><br>

  Фамилия: <input type="text" title="Въведете фамилия" required="required" name="user_lname" value="<?php echo $user_lname;?>">
  <span class="required">*</span>
  <br><br>


  Потребителско име: <input type="text" title="Въведете потребителско име" required="required" name="user_login" value="<?php echo $user_login;?>">
  <span class="required">*</span>
  <br><br>

  E-mail: <input type="text" title="Въведете имейл" required="required" name="user_email" value="<?php echo $user_email;?>">
  <span class="required">*</span>
  <br><br>

  Телефон: <input type="text" title="Въведете телефонен номер" name="user_phone" value="<?php echo $user_phone;?>">
  <br><br>

  <input type="submit" name="submit" value="Submit">  

</form>
</table>
</fieldset>
</body>
</html>