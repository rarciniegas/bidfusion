<?php

include('lib/common.php');


if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

?>

<?php include("lib/header.php"); ?>
		<title>Bid Fusion Auction Results</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					         
					
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">Auction Results</div>   
							<table>
								<tr>
									<td class="heading">ID</td>
									<td class="heading">Item Name</td>
									<td class="heading">Sale Price</td>
									<td class="heading">Winner</td>
									<td class="heading">Auction Ended</td>
								</tr>
                                <?php
                                $time_now = date("Y-m-d h:i:s");

                                $query = "SELECT Item.itemID, Item.item_name, Item.reserve, MAX(Bid.bid_amount)as sale_price, Bid.user_name as winner, Item.ends_in as auction_ended
                                            FROM Item LEFT JOIN Bid ON Item.itemID = Bid.itemID
                                            GROUP BY Item.itemID
                                            ORDER BY ends_in";

                                $result = mysqli_query($db, $query);
                                if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                    array_push($error_msg,  "SELECT ERROR: find Auction results <br>" . __FILE__ ." line:". __LINE__ );
                                }

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                                    if ($row['auction_ended'] < $time_now) {
                                        print "<tr>";
                                        print "<td>{$row['itemID']}</td>";
                                        print "<td>{$row['item_name']}</td>";
                                        if ($row['sale_price'] >= $row['reserve']) {
                                            print "<td>{$row['sale_price']}</td>";
                                            print "<td>{$row['winner']}</td>";
                                        } else {
                                            print "<td></td>";
                                            print "<td></td>";
                                        }
                                        print "<td>{$row['auction_ended']}</td>";
                                        
                                        print "</tr>";

                                    }
                                }
                                ?>

							</table>						
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