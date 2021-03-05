<?php
define("HOST","localhost");
define("DB_USER",'root1');
define("DB_PASSWORD",'12345');
define("DB_NAME","CRUD");
$connection = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($connection,"DELETE FROM crud_table WHERE id=$id");
    header("location: index.php");
}
if(isset($_POST['add'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    mysqli_query($connection,"INSERT INTO crud_table (id,email,password,time) VALUES('','$email','$pass','---')");
    header("location: index.php");

}
class User{
    private $id,$email,$pass,$time;
    static function array_input($_arr){
        $obj = new User();
        $obj->id = $_arr['id'];
        $obj->email = $_arr['email'];
        $obj->pass = $_arr['password'];
        $obj->time = $_arr['time'];
        return $obj;
    }
    static function args_input($_email,$_pass,$_time){
        $obj = new User();
        $obj->email = $_email;
        $obj->pass = $_pass;
        $obj ->time = $_time;
        return $obj;
    }
    public function output(){
        echo "<td>{$this->email}</td><td>{$this->pass}</td><td>{$this->time}</td><td></td>";
    }
    public function edit(){
        echo "<td><a href='edit.php?edit={$this->id}' class='edit'>EDIT</a></td>";
    }
    public function delete(){
        echo "<td><a href='index.php?delete={$this->id}' class='delete'>DELETE</a></td>";
    }
}


$response = mysqli_query($connection,"SELECT * FROM `CRUD_table`");

?>


<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD</title>
</head>
<body>
<div>
    <form action="index.php" method="POST">
        <label>email</label>
        <input type="email" name="email" >
        <label >password</label>
        <input type="password" name="pass" >
        <input type="submit" name="add" value="ADD">
    </form>
</div>
<div>
<table class="info">
    <?php
    while($input = mysqli_fetch_assoc($response)):
        $u = User::array_input($input);?>
    <tr>
        <?php $u->output();$u->edit();$u->delete();?>
    </tr>
    <?php endwhile;?>

</table>
</div>

</body>
</html>
