<?ph
    //START A SESSION
    session_start();

    include('server.php');

    $uid = "";

    if(isset($_SESSION["member"]) === true){
        //SET USER INFORMATION
        $uid = $_SESSION['uid'];
        
        $sql_userInformation = "SELECT * FROM user WHERE uid='$uid'";
        $res_userInformation = mysqli_query($conn, $sql_userInformation);
        $row_userInformation = mysqli_fetch_array($res_userInformation);

        $username = $row_userInformation['username'];
    }

    //TO GET AMOUNT OF UNPAID CART
    $cartAmount = 0;
    
    $sql_getCartAmount = "SELECT * FROM cart WHERE uid='$uid' AND status='unpaid'";
    $res_getCartAmount = mysqli_query($conn, $sql_getCartAmount);

    if(mysqli_num_rows($res_getCartAmount) > 0){
        while($row = mysqli_fetch_array($res_getCartAmount)){
            $cartAmount = $cartAmount + 1;
        }
    }

    //TO GET AMOUNT OF UNPAID CART
    $cartAmount = 0;
    
    $sql_getCartAmount = "SELECT * FROM cart WHERE uid='$uid' AND status='unpaid'";
    $res_getCartAmount = mysqli_query($conn, $sql_getCartAmount);

    if(mysqli_num_rows($res_getCartAmount) > 0){
        while($row = mysqli_fetch_array($res_getCartAmount)){
            $cartAmount = $cartAmount + 1;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/javascript.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="body">
    <header>
        <div class="container-wrapper">
             <div class="homepage"><img src ="../shopping_system/css/images/logo1.png"  width="200" height="100" alt="mars bg" /><ul></div>
            <div class="nav-bar">
                <div class="nav-bar-items" onclick="window.location='homepage.php'">
                    <p>Home</p>
                </div>

                <div class="nav-bar-items" onclick="window.location='product.php'">
                    <p>Products</p>
                </div>
            </div>

            <div class="cart-items">
                <?php if(empty($uid)){ ?>
                    <span id="login-register" onclick="openForm()">Login/Register</span>
                <?php }else{ ?>
                    <span id="login-register" onclick="openForm()"><?php echo $username;?></span>
                <?php } ?>
                <i onclick="window.location='mycart.php'" class='bx bx-cart'></i>
                <span id="cart-items-circle">
                    <?php echo $cartAmount; ?>
                </span>
            </div>
        </div>
    </header>

    <?php if(empty($uid)){ ?>
        <div class="form-popup" id="myForm">
            <form action="login_member.php" class="form-container">
                <h1>Login</h1>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <p id="form-popup-register">Don't have account? <a href="register.php" style="text-decoration: none; color: black;"><b>Register Here</b></a></p>

                <button type="submit" class="btn">Login</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    <?php }else{ ?>
        <div style="width: 220px; right: 11%;" class="form-popup" id="myForm">
            <form action="logout.php" class="form-container">
                <!-- Uncomment to enable the feature, profile feature not working ya :3 -->
                <!-- <div onclick="window.location='mycart.php'" id="form-container-items"><span>My Purchase</span></div>
                <div onclick="window.location='myprofile.php'" id="form-container-items"><span>Profile</span></div> -->

                <button type="submit" class="btn">Logout</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    <?php } ?>

    <section>
        <br>
        <p id="product-header">Products</p>
        <div id="product-container">
            <div class="product-grid-container">
                <?php
                    //SELECT ALL THE PRODUCT AND SHOW THEM
                    $sql_selectProduct = "SELECT * FROM product";
                    $res_selectProduct = mysqli_query($conn, $sql_selectProduct);
                    
                    if(mysqli_num_rows($res_selectProduct) > 0){
                        while($row = mysqli_fetch_array($res_selectProduct)){
                            echo "<a style='text-decoration: none; color: black;' href='product_buy_information.php?productID=".$row['product_id']."'>";
                                echo "<div class='grid-item'>";
                                    echo "<div class='grid-item-picture'>";
                                        echo "<image id='product-grid-picture' src='resource/product_pic/".$row['picture']."'></image>";
                                    echo "</div>";

                                    echo "<div id='product-grid-information'>";
                                        echo "<span id='grid-product-name'>".$row['name']."</span>";
                                        echo "<br>";
                                        echo "<span id='grid-product-price'>RM".$row['price']."</span>";
                                        echo "<br>";
                                        echo "<br>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        }
                    }
                ?>
            </div>
        </div>
    </section>

    <footer>
        <span><i class='bx bx-copyright icon'></i> Copyright 2022</spam>
    </footer>
</body>

</html>