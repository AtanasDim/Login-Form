<?php 

session_start();

mb_internal_encoding('UTF-8');


$errors = array();

if(!empty($_SESSION['personalInfo']['user_fname']) || !empty($_SESSION['personalInfo']['user_lname']) 
           || !empty($_SESSION['personalInfo']['user_login']) || !empty($_SESSION['personalInfo']['email'])){
    
//Database information    
$serverName = 'localhost';
$userName = 'root';
$password = '';
$database = 'phplab_course_project';

//Create connection
$conn = mysqli_connect($serverName,$userName,$password,$database);

//Check connection
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

//mysqli_real_escape_string
$user_fname = $_SESSION['personalInfo']['user_fname'];
$user_mname = $_SESSION['personalInfo']['user_mname'];
$user_lname = $_SESSION['personalInfo']['user_lname'];
$user_login = $_SESSION['personalInfo']['user_login'];
$user_email = mysqli_escape_string($conn, $_SESSION['personalInfo']['user_email']);
$user_phone = $_SESSION['personalInfo']['user_phone'];

$sqlUsers = "INSERT INTO users("
    . "user_fname, user_mname, user_lname,"
    . " user_login, user_email, user_phone) "
    . "VALUES("
    . "'$user_fname', '$user_mname', '$user_lname', '$user_login', '$user_email', '$user_phone')";

    
if(mysqli_query($conn,$sqlUsers)){
    $user_id = mysqli_insert_id($conn);
} else {
    echo "Error: ".$sqlUsers."<br />".mysqli_error($conn);
}

    foreach ($_SESSION['addressInfo'] as $address) {
        $address1 = $_SESSION['addressInfo']['address1'];
        $address2 = $_SESSION['addressInfo']['address2'];
        $post_code = $_SESSION['addressInfo']['post_code'];
        $populated_place = $_SESSION['addressInfo']['populated_place'];
        $area = $_SESSION['addressInfo']['area'];
        $country = $_SESSION['addressInfo']['country'];
        $sqlAddresses = "INSERT INTO addresses("
            . "address_line_1, address_line_2, address_zip,"
            . " address_city, address_province, address_country) "
            . "VALUES("
            . "'$address1', '$address2', '$post_code', '$populated_place', '$area',"
            . "'$country')";

        if(mysqli_query($conn,$sqlAddresses)){
           $address_id = mysqli_insert_id($conn);
        } else {
            echo "Error: ".$sqlAddresses."<br />".mysqli_error($conn);
        }
    
        $sqlUsersAddr = "INSERT INTO users_addresses("
            . "ua_user_id, ua_address_id ) "
            . "VALUES('$user_id', '$address_id')";
    
        if(mysqli_query($conn,$sqlUsersAddr)){
        } else {
            echo "Error: ".$sqlUsersAddr."<br />".mysqli_error($conn);
        }
    }

    foreach ($_SESSION['noteInfo']['note_text'] as $key => $note) {
        $textArea = $_SESSION['noteInfo']['note_text']['textArea'];

        $sqlNotes = "INSERT INTO notes("
            . "note_user_id, note_text) "
            . "VALUES("
            . "'$user_id', '$textArea')";

        if(mysqli_query($conn,$sqlNotes)){
        } else {
            echo "Error: ".$sqlNotes."<br />".mysqli_error($conn);
        }
    }   

//Outputs data about personal info
$queryInfo = "SELECT * FROM users WHERE user_id = $user_id";
$resultInfo = mysqli_query($conn, $queryInfo);

//Outputs data about addresses
$queryAddr = "SELECT * FROM addresses "
        . "JOIN users_addresses "
        . "ON addresses.address_id = users_addresses.ua_address_id "
        . "WHERE users_addresses.ua_user_id = $user_id";
$resultAddr = mysqli_query($conn, $queryAddr);


//Outputs data about notes
$queryNote = "SELECT * FROM notes "
        . "WHERE note_user_id = $user_id";
$resultNote = mysqli_query($conn, $queryNote);


mysqli_close($conn);

session_destroy();

} //end if-validation for the data
else {
   $msg = "Трябва да са налични всички задължителни полета, за да се запише информацията в базата данни.";
   array_push($errors, $msg);           
}
?>
<section>
    <header>
        <h1>Добавен потребител:</h1>
        <h3>Запис на данните за потребителя в MySQL БД</h3>
    </header>
        <div>
            <?php if(!empty($errors) && is_array($errors)){
                foreach($errors as $msg){
                    echo "<span>$msg</span>";
                    session_destroy();
                    die();
                }
            }
        ?>
        </div>
    <h5>Следната информация беше успешно записана в MySQL:</h5>
    <h2>Лични данни</h2>
    <hr id="mainHr" />
    <table><tr>
        <td colspan="2">
            <?php while($row = mysqli_fetch_array($resultInfo)) : ?>
        </td>
        </tr>
        <tr>
            <td>Собствено име</td>
            <td><?php echo $row['user_fname']; ?></td>
        </tr>
        <tr>
            <td>Бащино име</td>
            <td><?php echo $row['user_mname'] ?></td>
        </tr>
        <tr>
            <td>Фамилия</td>
            <td><?php echo $row['user_lname']; ?></td>
        </tr>
        <tr>
            <td>Потребителско име(логин)</td>
            <td><?php echo $row['user_login']; ?></td>
        </tr>
        <tr>
            <td>Електронна поща</td>
            <td><?php echo $row['user_email']; ?></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><?php echo $row['user_phone']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <h2>Адреси</h2>
    <hr id="mainHr" />
   <table>
       <tr>
        <td colspan="2">
            <?php while($row2 = mysqli_fetch_array($resultAddr)) : ?>
        </td>
        </tr>
        <tr>
            <td>Адрес ред 1</td>
            <td><?php echo $row2['address_line_1']; ?></td>
        </tr>
        <tr>
            <td>Адрес ред 2</td>
            <td><?php echo $row2['address_line_2'] ?></td>
        </tr>
        <tr>
            <td>Пощенски код</td>
            <td><?php echo $row2['address_zip']; ?></td>
        </tr>
        <tr>
            <td>Населено място</td>
            <td><?php echo $row2['address_city']; ?></td>
        </tr>
        <tr>
            <td>Регион</td>
            <td><?php echo $row2['address_province']; ?></td>
        </tr>
        <tr>
            <td>Държава</td>
            <td><?php echo $row2['address_country']; ?></td>
        </tr>
        <tr><td colspan="2"><hr /></td> </tr>
        <?php endwhile; ?>
    </table>
    <h2>Бележки</h2>
    <hr id="mainHr" />
    <ul>
        <?php while($row1 = mysqli_fetch_array($resultNote))  : ?>
        <li><?php echo $row1['note_text']; ?></li>
        <li><hr /></li>
        <?php endwhile; ?>
    </ul>
</section>