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


$address1 = $address2 = $post_code = $populated_place = $area = $country ="";
$check=false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["address1"])) {
       echo $arr[0][2][0];
	} else {
    	$address1 = corrector($_POST["address1"]);
    	if (!preg_match("/^[a-zA-Zа-яА-Я ]*$/",$address1)) {
          echo '<br>'.(" Въведеният адрес'$address1' е грешен. ");
          echo $arr[0][3][1];
    	}
    	else{
        $_SESSION['addressInfo']['address1'] = $address1;
        $check = true;
      }
      }
	if (empty($_POST["post_code"])) {
    	echo '<br>'.$arr[0][2][1];
    } else {
    	$post_code = corrector($_POST["post_code"]);
    	if (!preg_match("/^[0-9 ]*$/",$post_code)) {
            echo '<br>'.("Въведеният пощенски код '$post_code' е грешен. ");
            echo $arr[0][3][0];
      	}
      	else{
        $_SESSION['addressInfo']['post_code'] = $post_code;
        $check = true;
      }
      }
    if (empty($_POST["populated_place"])) {
    	echo '<br>'.$arr[0][2][2];
    } else {
    	$populated_place = corrector($_POST["populated_place"]);
    	if (!preg_match("/^[a-zA-Z ]*$/",$populated_place)) {
            echo '<br>'.("Въведеното населено място '$populated_place' е грешно. ");
            echo $arr[0][3][1];
      	}
      	else{
        $_SESSION['addressInfo']['populated_place'] = $populated_place;
        $check = true;
      }
      }
    if (empty($_POST["area"])) {
    	echo '<br>'.$arr[0][2][3];
    } else {
    	$area = corrector($_POST["area"]);
    	if (!preg_match("/^[a-zA-Z ]*$/",$area)) {
            echo '<br>'.("Въведената област '$area' е грешна. ");
            echo $arr[0][3][0];
      	}
      	else{
        $_SESSION['addressInfo']['area'] = $area;
        $check = true;
      }
      }
      $address2 = corrector($_POST['address2']);
  $_SESSION['addressInfo']['address2'] = $address2;

  $country = corrector($_POST['country']);
  $_SESSION['addressInfo']['country'] = $country;

  //Next step if there are no errors
  if($check){
    session_write_close();
    header('Location: notes.php');
    exit;
}
}
else {
  $address1 = (isset($_SESSION['addressInfo']['address1'])) ? $_SESSION['addressInfo']['address1'] : '';
  $address2 = (isset($_SESSION['addressInfo']['address2'])) ? $_SESSION['addressInfo']['address2'] : '';
  $post_code = (isset($_SESSION['addressInfo']['post_code'])) ? $_SESSION['addressInfo']['post_code'] : '';
  $populated_place = (isset($_SESSION['addressInfo']['populated_place'])) ? $_SESSION['addressInfo']['populated_place'] : '' ;   
  $area = (isset($_SESSION['addressInfo']['area'])) ? $_SESSION['addressInfo']['area'] : '' ; 
  $country = (isset($_SESSION['addressInfo']['country'])) ? $_SESSION['addressInfo']['country'] : '' ;  
    }

function corrector($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
?>

<fieldset><legend align="center">
   Въвеждане на данни за нов потрeбител:
 </legend>
<table align="center"><tr><td>
<h2>Въвеждане на адрес</h2><br><br>
<p><span class="text"><i>Задължителните полета са обозначени с *.</i></span></p>
<form method="post" action="">  

  Адрес: <input type="text" autofocus="autofocus" title="Въведете адрес" name="address1" required="required" value="<?php echo $address1;?>">
  <span class="required">* </span><br><br>
  
  Адрес 2: <input type="text" title="Въведете втори адрес" name="address2" value="<?php echo $address2;?>"><br><br>

  Пощенски код: <input type="text" title="Въведете пощенски код" name="post_code" required="required" value="<?php echo $post_code;?>">
  <span class="required">* </span><br><br>

  Населено място:<input type="text" title="Въведете населено място" name="populated_place" required="required" value="<?php echo $populated_place;?>">
  <span class="required">* </span><br><br>

  Област: <input type="text" title="Въведете област" name="area" required="required" value="<?php echo $area;?>">
  <span class="required">* </span><br><br>

  Държава: <input type="text" title="Въведете държава" name="country" value="<?php echo $country;?>"><br><br>

  <input type="submit" name="submit" value="Submit">  
</form>
</table>
</fieldset>
</body>
</html>