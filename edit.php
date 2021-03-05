<?php

define("HOST","localhost");
define("DB_USER",'root1');
define("DB_PASSWORD",'12345');
define("DB_NAME","CRUD");
$connection = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME);

$old_email = $old_pass ="";
$title = "";
if(isset($_GET['id'])){
    $old_email = $_GET['email'];
    $old_pass = $_GET['pass'];
    $title = "EDIT";
}
else{
    $title = "CREATE";
}
if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    mysqli_query($connection,"UPDATE crud_table SET email='$email',password='$pass' WHERE id=$id");
    header("location: index.php");
}
if(isset($_POST['create'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    mysqli_query($connection,"INSERT INTO crud_table (id,email,password,time) VALUES('','$email','$pass','---')");
    header("location: index.php");
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

        <?php
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
