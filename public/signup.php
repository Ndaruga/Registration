<?php
include ("header.php");
include ("../private/autoload.php");
$error = "";
$First_Name = "";
$Last_Name = "";
$Email = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //print_r($_POST);    //check if something was posted 
    $Email = $_POST['Email'];
    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $Email)){
        $error = "Please enter a valid Email";
    }

    $First_Name = trim($_POST['First_Name']);
    if (!preg_match("/^[a-zA-Z]/", $First_Name)){
        $error = "Please Enter a valid First Name";
    }
    $First_Name = escape_char($First_Name);

    $Last_Name = trim($_POST['Last_Name']);
    if (!preg_match("/^[a-zA-Z]/", $Last_Name)){
        $error = "Please Enter a valid Last Name";
    }
    $Last_Name = escape_char($Last_Name);
    $Password = trim($_POST['Password']);
    $Confirm_Pass = trim($_POST['Confirm_Password']);

        // check if email exists
        $arr = false;

        $arr['Email'] =  $Email;

        $query = "SELECT * FROM user_bio WHERE Email = :Email limit 1";
        //mysqli_query($connection, $query);
        $stmt = $connection -> prepare($query);
        $check = $stmt -> execute($arr);

        if ( $check){
            $data = $stmt -> fetchAll(PDO::FETCH_OBJ);
            if (is_array($data) && count($data) > 0){

                $error = "Email Already Exists. Please Use a different one!";
            }
        }
    }


    if ($error == ""){
        $arr['First_Name'] = $First_Name;
        $arr['Last_Name'] = $Last_Name;
        $arr['Email'] = $Email;
        $arr['Password'] = $Password;


        $query = "INSERT INTO user_bio (First_Name, Last_Name, Email, Password) values (:First_Name, :Last_Name, :Email, :Password)";
        //mysqli_query($connection, $query);
        $stmt = $connection -> prepare($query);
        $stmt -> execute($arr);

        header("Location: login.php"); // redirect after successful login
        die;        //Have a clean break out of the  signup form
    }
    


?>
<form action="" method = "POST">
    <h4 id="form-title"> Registration form</h4>
    <label for="error-field"> 
        <div id="error-field-1"></div>
    </label>
    <br>
    <label for="first_name"> <strong>First Name</strong><span id="asterisk">*</span>
        <input type="text" name="First_Name" value = "<?php $First_Name ?>" required placeholder="Enter your First Name">
    </label>
    <br>
    <label for="last_name"> <strong>Last Name</strong><span id="asterisk">*</span>
        <input type="text" name="Last_Name" value = "<?php $Last_Name ?>" required placeholder="Enter your Last Name">
    </label>
    <br>
    <label for="first_name"> <strong>Email</strong><span id="asterisk">*</span>
        <input type="email" name="Email" value = "<?php $Email ?>" required placeholder="Enter your Email">
    </label>
    <br>
    <label for="first_name"> <strong>Password</strong><span id="asterisk">*</span>
        <input type="password" name="Password" required placeholder="Enter password">
    </label>
    <br>
    <label for="first_name"> <strong>Confirm Password</strong><span id="asterisk">*</span>
        <input type="password" name="Confirm_Password" required placeholder="re-enter password ">
    </label>
    
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
        <button id = "sign_up" type = "submit"> Sign Up</button>
    </label>
    
</form>

<?php
include ('footer.php');
?>