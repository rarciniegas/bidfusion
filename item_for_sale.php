<?php

include('lib/common.php');


if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_SESSION['user_name'];
    $itemID = $_SESSION['item_selected'];
    $your_bid = $_POST['your_bid'];

    $query = "INSERT INTO `Bid` ( `bid_date_time`,`bid_amount`, `itemID`, `user_name`)
              VALUES (now(), '$your_bid', '$itemID', '$user_name');";

    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');

    if (!empty($result) ) {
        header(REFRESH_TIME . 'url=welcome.php');
    } else {
        array_push($error_msg, "Invalid data entry. ");
    }

}  //end of if($_POST)

if (!empty($_GET['item_ratings'])) {


    header(REFRESH_TIME . 'url=item_ratings.php');
}

if (!empty($_GET['edit_description'])) {

 //   $_SESSION['item_selected'] = $_GET['item_selected'];
    header(REFRESH_TIME . 'url=edit_description.php');
}

if (!empty($_GET['get_it_now'])) {
    $user_name = $_SESSION['user_name'];
    $itemID = $_SESSION['item_selected'];
    $your_bid = $_GET['get_it_now'];

    $query = "INSERT INTO `Bid` ( `bid_date_time`,`bid_amount`, `itemID`, `user_name`)
              VALUES (now(), '$your_bid', '$itemID', '$user_name');";
    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');

    $query = "UPDATE Item SET ends_in=now() WHERE itemID='$itemID'";

    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');

    if (!empty($result) ) {
        header(REFRESH_TIME . 'url=welcome.php');
    } else {
        array_push($error_msg, "Invalid data entry. ");
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
							<div class="subtitle">Bid Fusion Item for Sale</div>
                            
							<form name="item_for_sale_form" action="item_for_sale.php" method="post">
                                <table>
                                    <?php
                                        $itemID = $_SESSION['item_selected'];

                                        $query = "SELECT itemID, item_name, description, category, ends_in, get_it_now, returnable, user_name, item_condition FROM Item WHERE itemID = $itemID";
                                        $result = mysqli_query($db, $query);
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            print "<tr>";
                                                print"<td class=\"item_label\">Item ID</td>";
                                                print "<td>{$row['itemID']}</td>";
                                            print "<td><a href='item_for_sale.php?item_ratings=" .
                                                urlencode($row['itemID']) . "'>View Ratings</a></td>";
                                            print "</tr>";
                                            print "<tr>";
                                                print"<td class=\"item_label\">Item Name</td>";
                                                print "<td>{$row['item_name']}</td>";
                                            print "</tr>";
                                            print "<tr>";
                                                print"<td class=\"item_label\">Description</td>";
                                                print "<td>{$row['description']}</td>";
                                                if ($_SESSION['user_name'] == $row['user_name']) {
                                                    print "<td><a href='item_for_sale.php?edit_description=" .
                                                        urlencode($row['itemID']) . "'>Edit Description</a></td>";
                                                }
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
                                            $value_now = floatval($row['get_it_now']);
                                            if ($value_now > 0){
                                            print "<tr>";
                                                print"<td class=\"item_label\">Get it now price  </td>";
                                                print "<td>{$row['get_it_now']}</td>";

                                                print "<td><a href='item_for_sale.php?get_it_now=" .
                                                    urlencode($row['get_it_now']) . "'>Get It Now!</a></td>";

                                                    //print "<a href='javascript:list_item_form.submit();'
                                                    //name='buy_now' value='1' class='fancy_button' type='submit'>Buy Now</a>";


                                                print "</tr>";
                                            }


                                            print "<tr>";
                                                print"<td class=\"item_label\">Auction Ends: </td>";
                                                print "<td>{$row['ends_in']}</td>";
                                            print "</tr>";


                                            print "<tr>";
                                            print"<td class=\"item_label\">Bid Amount  </td>";
                                            print"<td class=\"item_label\">Time of Bid </td>";
                                            print"<td class=\"item_label\">Username  </td>";
                                            print "</tr>";
                                            $itemID = $_SESSION['item_selected'];
                                            $sql = "SELECT bid_amount,bid_date_time,user_name\n"

                                                . "FROM Bid\n"

                                                . "WHERE itemID = $itemID\n"

                                                . "ORDER BY bid_amount DESC";
                                            $result = mysqli_query($db, $sql);
                                            $i = 0;
                                            $minimum_bid = 0;
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                if ($i < 4) {
                                                    print "<tr>";

                                                    print "<td>{$row['bid_amount']}</td>";
                                                    print "<td>{$row['bid_date_time']}</td>";
                                                    print "<td>{$row['user_name']}</td>";
                                                    print "</tr>";
                                                    if ($i == 0) {
                                                        $minimum_bid = $row['bid_amount'] + 1.00;
                                                    }
                                                    $i += 1;
                                                }
                                            }

                                            print "<tr>";
                                                print "<td class = 'item_label'>Your Bid $ </td>";
                                                print "<td>
                                                    <input name='your_bid' type= 'number'>
										        </td>";
                                            print "</tr>";

                                            print "<tr>";
                                            print "<td class = 'item_label'>minimum bid $ </td>";
                                            if ($minimum_bid == 0){
                                                $minimum_bid = 1.00;
                                            }
                                            print "<td>{$minimum_bid}</td>";
                                            print "</tr>";


                                            print "<tr>";
                                                print "<td>";
                                                    print "<a href= 'welcome.php' class='fancy_button'>Cancel</a>";
                                                print "</td>";

                                                print "<td>";
                                                    print "<a href= 'javascript:item_for_sale_form.submit();'
                                                            class='fancy_button'>Bid</a>";
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