<?php
    include('server.php');

    function validate_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $registerErr = $registerSucc = $username = $email = $phone = $password = $rePassword = "";

    if(isset($_POST['register'])){
        //GET FORM DATA!
        $username = validate_input($_POST['username']);
        $email = validate_input($_POST['email']);
        $password = validate_input($_POST['password']);
        $rePassword = validate_input($_POST['re-password']);

        //LOW SEC TO PREVENT SQL INJECTIONG
        $username = addslashes($username);
        $email = addslashes($email);
        $password = addslashes($password);
        $rePassword = addslashes($rePassword);
        
        //CHECK WHETHER IF USER CHANGE THE CLIENT SIDE DATA
        if(!empty($username) || !empty($email) || !empty($phone) || !empty($password) || !empty($rePassword)){
            
            //CHECK FOR DUP EMAIL
            $sql_checkEmail = "SELECT * FROM user WHERE email='$email'";
            $res_checkEmail = mysqli_query($conn, $sql_checkEmail);
            
            if(mysqli_num_rows($res_checkEmail) > 0){
                $registerErr = "Email already been registered!";
            }

            //CHECK FOR PASSWORD
            if($password != $rePassword){
                $registerErr = "Password is not same!";
            }

            //I ALLOW DUP USERNAME, SO THE SYSTEM WILL NOT CHECK FOR DUP USERNAME :3, its not an error!

            if(empty($registerErr)){
                $sql_insertData = "INSERT INTO user (email, username, password) VALUES ('$email', '$username', '$password')";

                if(mysqli_query($conn, $sql_insertData)){
                    $registerSucc = "Register successful!";
                }else{
                    $registerErr = "Ops! Something Error!";
                }
            }



        }else{
            $registerErr = "Error! Some of your information is missing!";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
    <script src="js/javascript.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="body">
    <section>
        <div id="register-container">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" style="max-width:500px;margin:auto" method="post" enctype="multipart/form-data">
                <h2>Register Form</h2>
                <p>Please fill in this form to create an account.</p>

                <hr>

                <div class="input-container">
                    <i class='bx bx-user icon'></i>
                    <input class="input-field" type="text" placeholder="Username" name="username">
                </div>

                <div class="input-container">
                    <i class='bx bx-envelope icon'></i>
                    <input class="input-field" type="email" placeholder="Email" name="email">
                </div>

                <div class="input-container">
                    <i class='bx bx-lock-alt icon'></i>
                    <input class="input-field" type="password" placeholder="Password" name="password">
                </div>

                <div class="input-container">
                    <i class='bx bx-lock-alt icon'></i>
                    <input class="input-field" type="password" placeholder="Repeat Password" name="re-password">
                </div>

                <hr>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
                <button type="submit" name="register" class="btn">Register</button>
                <?php if(!empty($registerErr)){ ?>
                    <p style="color: red; text-align: center;"><?php echo $registerErr ?></p>;
                <?php }; if(!empty($registerSucc)){ ?>
                    <p style="color: green; text-align: center;"><?php echo $registerSucc ?></p>;
                <?php }; ?>
                <br><br>
                <hr>
                <div id="back-home" onclick="window.location='homepage.php'">Back to HomePage</div>
            </form>
        </div>
    </section>

    <footer>

    </footer>
</body>

</html>