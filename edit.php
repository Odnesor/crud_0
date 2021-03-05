<?php

define("HOST","localhost");
define("DB_USER",'root1');
define("DB_PASSWORD",'12345');
define("DB_NAME","CRUD");
$connection = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME);


if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    mysqli_query($connection,"UPDATE crud_table SET email='$email',password='$pass' WHERE id=$id");
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
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <label>email</label>
        <input type="email" name="email" >
        <label >password</label>
        <input type="password" name="pass" >
        <input type="submit" name="submit" value="ADD">
        <input type="hidden" name="id" value="<?=$_GET['edit']?>">
    </form>
</div>


</body>
</html>
