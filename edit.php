<?php

define("HOST","localhost");
define("DB_USER",'root1');
define("DB_PASSWORD",'12345');
define("DB_NAME","CRUD");
$connection = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME);

$old_email = $old_pass ="";
$title = "";
//перевірка на наявність передачі параметрів
//якщо є старі параметри - то поля форми будуть заповнені старими значеннями
//і, відповідно, форма буде використовуватись для реалізації редагування, а не створення
//(див. коментар***)
if(isset($_GET['id'])){
    $old_email = $_GET['email'];
    $old_pass = $_GET['pass'];
    $title = "EDIT";
}
else{
    $title = "CREATE";
}
if(isset($_GET['warning'])){
    if($_GET['warning'] == 2) echo "THIS EMAIL IS ALREADY TAKEN! TRY AGAIN";
}
if(isset($_POST['create'])){
    $email = $_POST['email'];
    $unique_check = mysqli_query($connection,"SELECT * FROM crud_table WHERE email='$email'");
    if(mysqli_num_rows($unique_check) > 0){
        header("location: edit.php?warning=2");
    }else {
        $pass = md5($_POST['pass']);
        date_default_timezone_set('UTC');
        $time = date("H:i:s Y-m-d");
        mysqli_query($connection, "INSERT INTO crud_table (id,email,password,time) VALUES('','$email','$pass','$time')");
        header("location: index.php");
    }
}
if(isset($_POST['edit'])){
    $email = $_POST['email'];
    $unique_check = mysqli_query($connection,"SELECT * FROM crud_table WHERE email='$email'");
    if($email!=$_POST['old_email'] && mysqli_num_rows($unique_check) > 0){
        header("location: edit.php?warning=2");
    }else {
        $pass = md5($_POST['pass']);
        date_default_timezone_set('UTC');
        $time = date("H:i:s d-m-Y");
        $id = $_POST['id'];
        mysqli_query($connection, "UPDATE crud_table SET email='$email',password='$pass', time='$time' WHERE id=$id");
        header("location: index.php");
    }
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD</title>
</head>
<body>
<div>
    <h2><?=$title?></h2>
    <form action="edit.php" method="POST">
        <label>email</label>
        <input type="email" name="email" value="<?=$old_email?>">
        <label >password</label>
        <input type="text" name="pass" value="<?=$old_pass?>">
        <input type="hidden" name="old_email" value="<?=$old_email?>">

        <?php
        //***Перевірка для визначення того, як форма буде обробляти введені дані
        if(isset($_GET['id'])) {
            echo "<input type='hidden' name='id' value={$_GET['id']}>";
            echo "<input type='submit' name='edit' value='EDIT'>";
        }
        else
            echo "<input type='submit' name='create' value='CREATE'>";
        ?>
    </form>
</div>
</body>
</html>
