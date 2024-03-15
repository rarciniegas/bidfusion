<?php
include('lib/common.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $isValidFirstname = !is_null($firstname) && (trim($firstname) != '');
    $isValidLastname = !is_null($lastname) && (trim($lastname) != '');
    $isValidUsername = !is_null($username) && (trim($username) != '');
    $isValidPassword = !is_null($password) && (trim($password) != '');


    if (!$isValidFirstname) {
        array_push($error_msg, "Please enter a first name.");
    }

    if (!$isValidLastname) {
        array_push($error_msg, "Please enter a last name.");
    }

    if (!$isValidUsername) {
        array_push($error_msg, "Please enter an user name.");
    }

    if (!$isValidPassword) {
        array_push($error_msg, "Please enter a password.");
    }

    if ($isValidUsername && $isValidPassword && $isValidFirstname && $isValidLastname) {
        $created_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO `User` (first_name, last_name, user_name, password, created_at) VALUES ('$firstname',  '$lastname', '$username', '$password', '$created_at')";
        $queryID = mysqli_query($db, $query);
        if ($query) {
            header(REFRESH_TIME . 'url=login.php');
        }
        array_push($error_msg, "Duplicate user name");
    }
}
?>
<?php include("lib/header.php"); ?>
<title>Bid Fusion List Item</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="features">
                <div class="profile_section">
                    <div class="subtitle">Item Search</div>
                    <form name="user_registration_form" action="register.php" method="post">
                        <table>
                            <tr>
                                <td class="item_label">First Name</td>
                                <td>
                                    <input type="text" name="firstname" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="item_label">Last Name</td>
                                <td>
                                    <input type="text" name="lastname" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td class="item_label">User Name</td>
                                <td>
                                    <input type="text" name="username" value="">
                                </td>
                            </tr>

                            <tr>
                                <td class="item_label">Password</td>
                                <td>
                                    <input type="password" name="password" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="login.php" class="fancy_button">Cancel</a>
                                </td>
                                <td>
                                    <a href="javascript:user_registration_form.submit();" class="fancy_button">Register</a>
                                </td>
                            </tr>
                        </table>


                    </form>
                </div>

            </div>
        </div>

        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>

    <?php include("lib/footer.php"); ?>

</div>
</body>
</html>
