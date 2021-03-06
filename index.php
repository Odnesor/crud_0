<?php
define("HOST","localhost");
define("DB_USER",'root1');
define("DB_PASSWORD",'12345');
define("DB_NAME","CRUD");
$connection = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(isset($_GET['action'])){
   switch ($_GET['action']){
       case 'delete': {
           $obj = unserialize(urldecode($_GET['obj']));
           $obj->delete();
           break;
       }
       case 'edit': {
           $obj = unserialize(urldecode($_GET['obj']));
           $obj->edit();
           break;
       }
       case 'create': {
           User::create();
           break;
       }
   }
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
    private function obj_url(){
        return urlencode(serialize($this));
    }
    //функція для вставки інформації про об'єкт в html
    public function output(){
        echo "<td>{$this->email}</td><td>{$this->pass}</td><td>{$this->time}</td><td></td>";
    }
    //функція для вставки html-коду кнопок(посиланнь) з передачою url-закодованого об'єкту
    public function edit_button(){
        $uri = "index.php?action=edit&obj={$this->obj_url()}";
        echo "<td><a href=$uri class='edit'>EDIT</a></td>";
    }
    public function delete_button(){
        $uri = "index.php?action=delete&obj={$this->obj_url()}";
        echo "<td><a href=$uri class='delete'>DELETE</a></td>";
    }
    public function edit(){
        header("location: edit.php?id={$this->id}&email={$this->email}&pass={$this->pass}");
    }
    public function delete(){
        $connection = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME);
        mysqli_query($connection,"DELETE FROM crud_table WHERE id=$this->id");
        header("location: index.php");
    }
    static function create(){
        header("location: edit.php");
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
    <a href="index.php?action=create">CREATE</a>
</div>
<div>
<table class="info">
    <?php
    while($input = mysqli_fetch_assoc($response)):
        $u = User::array_input($input);?>
    <tr>
        <?php $u->output();$u->edit_button();$u->delete_button();?>
    </tr>
    <?php endwhile;?>

</table>
</div>

</body>
</html>
