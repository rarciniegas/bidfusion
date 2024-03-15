<?php

include('lib/common.php');

if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $user_name = $_SESSION['user_name'];

        $item_name = mysqli_real_escape_string($db, $_POST['item_name']);
        $description = mysqli_real_escape_string($db, $_POST['description']);

        $isValidItemName = !is_null($item_name) && (trim($item_name) != '');
        $isValidDescription = !is_null($description) && (trim($description) != '');

        $category = mysqli_real_escape_string($db, $_POST['category']);
        $shape = mysqli_real_escape_string($db, $_POST['shape']);
        if ($_POST['shape'] == 'New'){
            $condition = '4';
        }
        if ($_POST['shape'] == 'Very Good'){
            $condition = '3';
        }
        if ($_POST['shape'] == 'Good'){
            $condition = '2';
        }
        if ($_POST['shape'] == 'Fair'){
            $condition = '1';
        }
        if ($_POST['shape'] == 'Poor'){
            $condition = '0';
        }
        $start_bid = number_format($_POST['start_bid'],2);
        $reserve = floatval($_POST['reserve']);
        $ends_in = Date('y:m:d H:i:s', strtotime('+'.$_POST['ends_in']));
        $get_it_now = number_format( $_POST['get_it_now'],2);
        if ($_POST['returnable'] == '1'){
            $returnable = '1';
        } else{
            $returnable = '0';
        }

        if (!$isValidItemName) {
            array_push($error_msg, "Please enter item name.");
        }

        if (!$isValidDescription) {
            array_push($error_msg, "Please enter item description.");
        }

        if ($isValidDescription && $isValidItemName) {
            $query = "INSERT INTO `Item` ( `date_time`,`item_name`, `description`, `start_bid`, `reserve`, `ends_in`, `get_it_now`, `returnable`, `category`, `user_name`, `item_condition`)
                  VALUES (now(), '$item_name', '$description', '$start_bid', '$reserve', '$ends_in', '$get_it_now', '$returnable', '$category', '$user_name', '$condition');";

            $result = mysqli_query($db, $query);
            include('lib/show_queries.php');

            if (!empty($result)) {
                header(REFRESH_TIME . 'url=welcome.php');
            } else {
                array_push($error_msg, "Invalid data entry. ");
            }
        }

}  //end of if($_POST)

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
							<div class="subtitle">New Item for Auction</div>   
                            
							<form name="list_item_form" action="list_item.php" method="post">
								<table>
									<tr>
										<td class="item_label">Item Name</td>
										<td>
											<input type="text" name="item_name" value="" />
										</td>
									</tr>
									<tr>
										<td class="item_label">Description</td>
										<td>
                                            <textarea name="description" rows="5" cols="40"></textarea>
										</td>
									</tr>
									<tr>
										<td class="item_label">Category</td>
										<td>
										    <select class="form-control" name="category">
									          <option>Art</option>
									          <option>Books</option>
									          <option>Electronics</option>
									          <option>Home & Garden</option>
									          <option>Sporting Goods</option>
									          <option>Toys</option>
									          <option>Other</option>
									        </select>
									    </td>
									</tr>
									<tr>
										<td class="item_label">Condition</td>
										<td>
											<select class="form-control" name="shape">
									          <option>New</option>
									          <option>Very Good</option>
									          <option>Good</option>
									          <option>Fair</option>
									          <option>Poor</option>
									        </select>
										</td>
									</tr>

									<tr>
										<td class="item_label">Start Bid</td>
										<td>
                                            <input name="start_bid" type="number" value="0.00">
										</td>
									</tr>

									<tr>
										<td class="item_label">Reserve</td>
										<td>
                                            <input type="number" name="reserve" value="0.00">
										</td>
									</tr>
									
									<tr>
										<td class="item_label">Ends in</td>
										<td>
											<select class="form-control" name="ends_in">
									          <option>1 day</option>
									          <option>3 days</option>
									          <option>5 days</option>
									          <option>7 days</option>
									        </select>
											
										</td>
									</tr>
									<tr>
										<td class="item_label">Get it Now</td>
										<td>
											<input type="number" name="get_it_now" value="0.00">
										</td>
									</tr>
									<tr>
										<td class="item_label">Returnable</td>
										<td>
											<input class="form-check-input" type="checkbox" value="1" name="returnable">
										</td>
									</tr>
                                    <tr>
                                        <td>
                                            <a href="welcome.php" class="fancy_button">Cancel</a>
                                        </td>
                                        <td>
                                            <a href="javascript:list_item_form.submit();" class="fancy_button">List</a>
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