 <?php include "before_content.code"; include "errors.php" ?>

<?php

mb_internal_encoding('UTF-8');

session_start();


$note_text ="";
$check=false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["note_text"])) {
       echo $arr[0][4][0];
	} else {
    	$note_text = corrector($_POST["note_text"]);
        $_SESSION['noteInfo']['note_text'] = $note_text;
        $check = true;
      }
if($check){
    session_write_close();
    header('Location: sql&view.php');
    exit;
  }

}
function corrector($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }

?>

 <div id="content">
 <form action="" method="post" enctype="multipart/form-data">
 <fieldset><legend align="center"> Създаване на потребителска бележка: </legend><br><br>
 
 <table align="center"><tr><td>
Нова бележка:
<br><textarea name="note_text" autofocus="autofocus" rows="10" cols="40"></textarea><br><br>

<input type="submit" value="Запиши">
<input type="submit" value="Допълнителна бележка">
 </form>
 </table>
 </fieldset>
 </div>