<?php

include('lib/common.php');

if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_name = $_SESSION['user_name'];
    $comments = mysqli_real_escape_string($db, $_POST['comments']);
    $stars = mysqli_real_escape_string($db, $_POST['stars']);
    $itemID = $_SESSION['item_selected'];

    $query = "INSERT INTO `Rating` ( `rating_date_time`, `stars`, `comments`, `itemID`, `user_name`) VALUES (now(), '$stars', '$comments', '$itemID', '$user_name');";

    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');

    if (!empty($result) ) {
        header(REFRESH_TIME . 'url=welcome.php');
    } else {
        array_push($error_msg, "Invalid data entry. ");
    }

}  //end of if($_POST)

if (!empty($_GET['delete_my_rating'])) {
    $ratingID = $_GET['delete_my_rating'];
    $sql = "DELETE  FROM Rating WHERE ratingID='$ratingID'";
    $result = mysqli_query($db, $sql);

    header(REFRESH_TIME . 'url=welcome.php');
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
							<div class="subtitle">Bid Fusion Item for Sale</div>

                            <form name="item_ratings_form" action="item_ratings.php" method="post">
                                <table>
                                    <?php
                                    $itemID = $_SESSION['item_selected'];

                                    $query = "SELECT itemID, item_name FROM Item WHERE itemID = $itemID";
                                    $result = mysqli_query($db, $query);
                                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                                    print "<tr>";
                                    print"<td class=\"item_label\">Item ID</td>";
                                    print "<td>{$row['itemID']}</td>";
                                    print "</tr>";
                                    print "<tr>";
                                    print"<td class=\"item_label\">Item Name</td>";
                                    print "<td>{$row['item_name']}</td>";
                                    print "</tr>";
                                    $sql = "SELECT ratingID, user_name,stars,rating_date_time,comments FROM Rating WHERE itemID = $itemID";
                                    $result = mysqli_query($db, $sql);
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        if ($user_name == $row['user_name']){
                                            print "<td><a href='item_ratings.php?delete_my_rating=" .
                                                urlencode($row['ratingID']) . "'>Delete My Rating</a></td>";
                                        }
                                        print "<tr>";
                                            print "<td>Rated by:</td>";
                                            print "<td>{$row['user_name']}</td>";
                                            print "<td>{$row['stars']} stars</td>";
                                        print "</tr>";
                                        print "<tr>";
                                            print "<td>Date:</td>";
                                            print "<td>{$row['rating_date_time']}</td>";
                                            print "<td></td>";
                                        print "</tr>";
                                        print "<tr>";
                                            print "<td>{$row['comments']}</td>";
                                        print "</tr>";
                                    }
                                    print "<tr>";
                                    print "<td class='item_label'>Stars</td>";
                                    print "<td>";
                                    print "<select class='form-control' name='stars'>";
                                    print "<option>0</option>";
                                    print "<option>1</option>";
                                    print "<option>2</option>";
                                    print "<option>3</option>";
                                    print "<option>4</option>";
                                    print "<option>5</option>";
                                    print "</select>";
                                    print "</td>";
                                    print "</tr>";
                                    print "<tr>";
                                    print"<td class=\"item_label\">Comments</td>";
                                    print "<td>";
                                    print "<textarea name='comments' rows='5' cols='40'></textarea>";
                                    print "</td>";
                                    print "<tr>";
                                    print "<td>";
                                    print "<a href= 'welcome.php' class='fancy_button'>Cancel</a>";
                                    print "</td>";
                                    print "<td>";
                                    print "<a href='javascript:item_ratings_form.submit();' class='fancy_button'>Rate</a>";
                                    print "</td>";
                                    print "</tr>";
                                    ?>
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