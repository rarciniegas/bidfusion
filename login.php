<?php
include('lib/common.php');

if ($showQueries) {
    array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $enteredUserName = mysqli_real_escape_string($db, $_POST['user_name']);
    $enteredPassword = mysqli_real_escape_string($db, $_POST['password']);

    $isValidUsername = !is_null($enteredUserName) && (trim($enteredUserName) != '');
    $isValidPassword = !is_null($enteredPassword) && (trim($enteredPassword) != '');

    if (!$isValidUsername) {
        array_push($error_msg, "Please enter an user name.");
    }

    if (!$isValidPassword) {
        array_push($error_msg, "Please enter a password.");
    }

    if ($isValidUsername && $isValidPassword) {

        $query = "SELECT password FROM User WHERE user_name='$enteredUserName'";

        $result = mysqli_query($db, $query);
        include('lib/show_queries.php');
        $count = mysqli_num_rows($result);

        if (!empty($result) && ($count > 0)) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $storedPassword = $row['password'];

            $options = [
                'cost' => 8,
            ];
            //convert the plaintext passwords to their respective hashses
            $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT, $options);   //may not want this if $storedPassword are stored as hashes (don't rehash a hash)
            $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT, $options);


            // Debugging info
            if ($showQueries) {
                array_push($query_msg, "Plain text entered password: " . $enteredPassword);
                //Note: because of salt, the entered and stored password hashes will appear different each time
                array_push($query_msg, "Entered Hash:" . $enteredHash);
                array_push($query_msg, "Stored Hash:  " . $storedHash . NEWLINE);  //note: change to storedHash if tables store the plaintext password value
                //unsafe, but left as a learning tool uncomment if you want to log passwords with hash values
                //error_log('email: '. $enteredEmail  . ' password: '. $enteredPassword . ' hash:'. $enteredHash);
            }

            //depends on if you are storing the hash $storedHash or plaintext $storedPassword 
            if (password_verify($enteredPassword, $storedHash)) {
                array_push($query_msg, "Password is Valid! ");
                $_SESSION['user_name'] = $enteredUserName;
                array_push($query_msg, "logging in... ");
                header(REFRESH_TIME . 'url=welcome.php');        //to view the password hashes and login success/failure

            } else {
                array_push($error_msg, "Login failed: " . $enteredUserName . NEWLINE);
            }

        } else {
            array_push($error_msg, "The username entered does not exist: " . $enteredUserName);
        }
    }
}
?>

<?php include("lib/header.php"); ?>
<title>Bid Fusion Login</title>
</head>

<body>
<script type="text/javascript">
    document.onkeydown = function (e) {
        var keyCode = e ? (e.which ? e.which : e.keyCode) : event.keyCode;
        if (keyCode == 13) {
            //your function call here
            document.login_form.submit();
        }
    }
</script>
<div id="main_container">
    <div id="header">
        <div class="logo">
            <img src="img/Bid_Fusion.png" style="opacity:0.8;background-color:E9E5E2;" alt=""
                 title="Bid Fusion Logo"/>
        </div>
    </div>

    <div class="center_content">
        <div class="center_left">
            <form name="login_form" action="login.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <table>
                        <legend><b>Bid Fusion Login</b></legend>
                        <tr>
                            <td class="item_label">User Name</td>
                            <td>
                                <input type="text" name="user_name" value="" class="login_input" autofocus/>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Password</td>
                            <td>
                                <input type="password" name="password" value="" class="login_input"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="register.php" class="fancy_button">Register</a>
                            </td>
                            <td>
                                <a href="javascript:login_form.submit();"
                                   class="fancy_button">Login</a>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>

        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>

    <?php include("lib/footer.php"); ?>

</div>
</body>
</html>