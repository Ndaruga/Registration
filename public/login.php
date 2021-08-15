<?php
include ("header.php");
include ("../private/autoload.php");
$error = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //print_r($_POST);    //check if something was posted 
    $Email = $_POST['Email'];
    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $Email)){
        $error = "Please enter a valid Email";
    }

    $Password = trim($_POST['Password']);

    if ($error == ""){
       
        $arr['Email'] = $Email;
        $arr['Password'] = $Password;


        $query = "SELECT * FROM user_bio WHERE Email = :Email && Password = :Password limit 1";
        //mysqli_query($connection, $query);
        $stmt = $connection -> prepare($query);
        $check = $stmt -> execute($arr);

        if ( $check){
            $data = $stmt -> fetchAll(PDO::FETCH_OBJ);
            if (is_array($data) && count($data) > 0){

                $data = $data[0];
                $_SESSION['Email'] = $data -> Email;
                header("Location: index.php");
                die;
            }
        }
        
    }
    
}
//echo $_SESSION['Email'];

?>
<form action="" method = "POST">
    <h4 id="form-title"> Login form</h4>
    <label for="error-field"> 
        <div id="error-field-1"></div>
    </label>
    
    <br>
    <label for="first_name"> <strong>Email</strong><span id="asterisk">*</span>
        <input type="email" name="Email" required placeholder="Enter your Email">
    </label>
    <br>
    <label for="first_name"> <strong>Password</strong><span id="asterisk">*</span>
        <input type="password" name="Password" required placeholder="Enter password">
    </label>
    <br>    
    <br> 
    <br>
    <div id="error-field-2"><?php
        if(isset($error) && $error != ""){
            echo $error;
        }
    ?>
    </div>
    <br>
    <label for="signup">
        <button id = "sign_in" type = "submit"> Sign In</button>
    </label>
    
</form>

<?php
include ('footer.php');
?>