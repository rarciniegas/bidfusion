<?php

include('lib/common.php');

if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $user_name = $_SESSION['user_name'];
        $itemID = $_SESSION['item_selected'];
        $item_name = mysqli_real_escape_string($db, $_POST['item_name']);
        $description = mysqli_real_escape_string($db, $_POST['description']);


        $query = "UPDATE Item SET description='$description' WHERE itemID='$itemID'";

        $result = mysqli_query($db, $query);
        include('lib/show_queries.php');

        if (!empty($result) ) {
            header(REFRESH_TIME . 'url=welcome.php');
        } else {
            array_push($error_msg, "Invalid data entry. ");
        }

}  //end of if($_POST)

?>

<?php include("lib/header.php"); ?>
		<title>Art Bid List Item</title>
	</head>
	
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>
    
			<div class="center_content">	
				<div class="center_left">         
					<div class="features">   
                        <div class="profile_section">
							<div class="subtitle">Edit Description</div>

                            <form name="edit_description_form" action="edit_description.php" method="post">
                                <table>
                                    <?php
                                    $itemID = $_SESSION['item_selected'];

                                    $query = "SELECT itemID, item_name, description, category, ends_in, get_it_now, returnable, user_name, item_condition FROM Item WHERE itemID = $itemID";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                                        print "<tr>";
                                        print"<td class=\"item_label\">Item ID</td>";
                                        print "<td>{$row['itemID']}</td>";
                                        print "</tr>";
                                        print "<tr>";
                                        print"<td class=\"item_label\">Item Name</td>";
                                        print "<td>{$row['item_name']}</td>";
                                        print "</tr>";
                                        print "<tr>";
                                        print"<td class=\"item_label\">Description</td>";

                                        print "<td>";
                                        print "<textarea name='description' rows='5' cols='40'></textarea>";
                                        print "</td>";

                                        print "</tr>";
                                        print "<tr>";
                                        print"<td class=\"item_label\">Category</td>";
                                        print "<td>{$row['category']}</td>";
                                        print "</tr>";
                                        print "<tr>";
                                        print"<td class=\"item_label\">Condition</td>";

                                        if ($row['item_condition'] == '4'){
                                            $condition = 'New';
                                        }
                                        if ($row['item_condition'] == '3'){
                                            $condition = 'Very Good';
                                        }
                                        if ($row['item_condition'] == '2'){
                                            $condition = 'Good';
                                        }
                                        if ($row['item_condition'] == '1'){
                                            $condition = 'Fair';
                                        }
                                        if ($row['item_condition'] == '0'){
                                            $condition = 'Poor';
                                        }

                                        print "<td>{$condition}</td>";
                                        print "</tr>";
                                        print "<tr>";
                                        if ($row['returnable'] == 1){
                                            print "<td class='item_label'>Returnable</td>";

                                        } else {
                                            print "<td class='item_label'>Not returnable</td>";
                                        }
                                        print "<td>";
                                        print "</td>";
                                        print "</tr>";

                                        print "<tr>";
                                        print"<td class=\"item_label\">Get it now price  </td>";
                                        print "<td>{$row['get_it_now']}</td>";
                                        print "</tr>";

                                        print "<tr>";
                                        print"<td class=\"item_label\">Auction Ends: </td>";
                                        print "<td>{$row['ends_in']}</td>";
                                        print "</tr>";

                                        print "<tr>";
                                        print "<td>";
                                        print "<a href= 'welcome.php' class='fancy_button'>Cancel</a>";
                                        print "</td>";

                                        print "<td>";
                                        print "<a href='javascript:edit_description_form.submit();' class='fancy_button'>List</a>";

                                        print "</td>";
                                        print "</tr>";


                                    }
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