<?php
    //START A SESSION
    session_start();

    include('server.php');

    $username = $permission = $staffID = $profilePicture = "";

    //CHECK IF THE USER IS LOGGED IN
    if($_SESSION["admin"] !== true){
        header("location: login.php");
        exit;
    }

    $permission = $_SESSION["permission"];
    $uid = $_SESSION["uid"];

    //GET USER INFORMATION
    $sql_userInformation = "SELECT * FROM user WHERE uid='$uid'";
    $res_userInformation = mysqli_query($conn, $sql_userInformation);
    $row_userInformation = mysqli_fetch_array($res_userInformation);

    $username = $row_userInformation['username'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="js/javascript.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="body">
    <header>
        <div class="container-wrapper">
            <div id="container-wrapper-item1">
                <span id="admin-panel">Admin Panel</span>
            </div>

            <div id="container-wrapper-item2">
                <span id="wrapper-username"><?php echo $username; ?></span>
                <img id="wrapper-staff-pic" src="resource/staff_pic/default.png"></img>
            </div>
        </div>
    </header>

    <div style="height: 60px; width: 100%;"></div>

    <section id="main-container">
        <div class="nav-menu">
            <a style="text-decoration: none;" href="dashboard.php">
                <div class="nav-menu-items">
                    <i class='bx bxs-dashboard icon'></i>
                    <span>Dashboard</span>
                </div>
            </a>

            <hr>

            <a href="shipment_information.php" style="text-decoration: none;">
                <div class="nav-menu-items">
                    <i class='bx bxs-ship icon'></i>
                    <span>Shipment</span>
                </div>
            </a>

            <hr>

            <a href="product_information.php" style="text-decoration: none;">
                <div style="background-color: rgb(218, 218, 218); border-radius: 10px; color: #282730;" class="nav-menu-items">
                    <i class='bx bxs-box icon'></i>
                    <span>Products</span>
                </div>
            </a>
            <hr>

            <a href="category_information.php" style="text-decoration: none;">
                <div class="nav-menu-items">
                    <i class='bx bxs-component icon'></i>
                    <span>Categories</span>
                </div>
            </a>

            <hr>

            <a href="logout.php">
                <div id="logout-menu" class="nav-menu-items">
                    <hr>
                    <i class='bx bxs-log-out icon'></i>
                    <span>Logout</span>
                    <hr>
                </div>
            </a>
        </div>
        

        <div class="nav-bar-breaker">
        </div>

        <div class="main-container">
            <div class="container-nav-bar">
                <div style="border-bottom: 2px solid white;" class="container-nav-bar-items">
                    <span>Product Information</span>
                </div>

                <div class="container-nav-bar-items">
                    <span>|</span>
                </div>

                <a style="text-decoration: none;" href="product_create.php">
                    <div class="container-nav-bar-items">
                        <span>Create Product</span>
                    </div>
                </a>

                <div class="container-nav-bar-items">
                    <span>|</span>
                </div>

                <a style="text-decoration: none;" href="product_manage.php">
                    <div class="container-nav-bar-items">
                        <span>Manage Product</span>
                    </div>
                </a>
            </div>

            <div class="container-items">
                <div style="width: 95%; margin: auto;">
                    <br>
                    <table id="styling-table1">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                        </tr>
                            <?php
                                $sqll = "Select count(*) from product";
                                $retnum = mysqli_query($conn,$sqll);
                                $count = mysqli_fetch_array($retnum, MYSQLI_NUM);
                                $rec_count = $count['0'];
                                $rec_limit = 6;
                                $last_page = ceil($rec_count/$rec_limit);
                                
                                if(!empty($_REQUEST["page"])){
                                $page = $_REQUEST['page'];
                                $offset = ($page - 1) * $rec_limit;
                                }else{
                                    $page= 1;
                                    $offset = 0;
                                }
                                $postp = $page + 1;
                                $prevp = $page - 1;

                                $sql2 = "Select * from product limit $offset, $rec_limit";
                                $result = mysqli_query($conn,$sql2);
                            

                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        $categoryID = $row['categories_id'];

                                        $sql_categoryName = "SELECT * FROM categories WHERE categories_id='$categoryID'";
                                        $res_categoryName = mysqli_query($conn, $sql_categoryName);
                                        $row_categoryName = mysqli_fetch_array($res_categoryName);

                                        echo "<tr>";
                                            echo "<td>".$row['product_id']."</td>";
                                            echo "<td style='text-align: center;'><img style='margin: auto; width: 35px; height: 35px;' src='resource/product_pic/".$row['picture']."'></img></td>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['description']."</td>";
                                            echo "<td>".$row_categoryName['name']."</td>";
                                            echo "<td style='text-align: right;'>RM".$row['price']."</td>";
                                        echo "</tr>";
                                    }
                                }else{
                                    echo "<tr>";
                                        echo "<td style='text-align: center;' colspan='7'>Empty!</td>";
                                    echo "</tr>";
                                }

                                echo "</table>";
                                
                                echo "<div class='all-course-pagination-btn'>";
                                    //For the pagination...
                                    if ($page > 1){
                                    echo "<div class='all-course-pagination-previous-btn'>";
                                        echo "<a style='color: white; background-color: #59761E; padding: 10px; margin: auto; border: black 2px solid;' href = '".$_SERVER['PHP_SELF']."?page=$prevp'>Previous Page</a>";
                                    echo "</div>";
                                    }
                                    if ($prevp < $last_page-1){ 
                                    echo "<div class='all-course-pagination-next-btn'>";
                                        echo "<a style='color: white; background-color: #59761E; padding: 10px; margin: auto; border: black 2px solid;' href = '".$_SERVER['PHP_SELF']."?page=$postp'>Next Page</a>";
                                    echo "</div>";
                                    }
                                echo "</div>";
                            ?>
                </div>
            </div>
        </div>
    </section>

    <!-- <footer>
        <span><i class='bx bx-copyright icon'></i> Copyright 2022</spam>
    </footer> -->
</body>

</html>