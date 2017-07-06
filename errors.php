<?php
  $user_registration_empty = array(
  'Въведете собствено име',
  'Въведете презиме',
  'Въведете фамилия',
  'Въведете потребителско име',
  'Въведете имейл адрес',
  'Въведете телефонен номер'
  );
  $user_registration_wrong_imput = array(
	'Само букви са позволени!',
	'Невалиден имейл',
	'Невалиден телефонен номер'
  	);
  $user_address_empty = array(
  'Въведете адрес',
  'Въведете пощенски код',
  'Въведете населоно място',
  'Въведете област',
  'Въведете Държава'
  );
  $user_address_wrong_imput = array(
  'Грешен пощенски код',
  'Само букви са позволени!',
  );
  $user_note_empty = array(
  'Попълнете бележката!'
  );
 
     $arr[] = array (
     	$user_registration_empty,
     	$user_registration_wrong_imput,
     	$user_address_empty,
     	$user_address_wrong_imput,
      $user_note_empty);
   //echo '<pre>'.print_r($arr,true).'</pre>';
     //foreach ($user_registration_empty as $k => $v) {
     //			echo k."----->".$v.'<br>';
     //	     }
    ?>