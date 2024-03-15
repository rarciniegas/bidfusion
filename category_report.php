<?php

include('lib/common.php');

if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

?>

<?php include("lib/header.php"); ?>
		<title>Bid Fusion Category Report</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					         
					
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">Category Report</div>   
							<table>
								<tr>
									<td class="heading">Category</td>
									<td class="heading">Total Items</td>
									<td class="heading">Min Price</td>
									<td class="heading">Max Price</td>
									<td class="heading">Average Price</td>
								</tr>
                                <tr>
                                    <?php

                                        $query = "SELECT category, COUNT(itemID) AS total_items, MIN(get_it_now) 
                                                    AS min_price, MAX(get_it_now) AS max_price,AVG(get_it_now) 
                                                    AS average_price
                                                  FROM Item
                                                  GROUP BY category
                                                  ORDER BY category" ;

                                    $result = mysqli_query($db, $query);
                                    if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                        array_push($error_msg,  "SELECT ERROR:  <br>" . __FILE__ ." line:". __LINE__ );
                                    }

                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['category']}</td>";
                                        print "<td>{$row['total_items']}</td>";
                                        print "<td>{$row['min_price']}</td>";
                                        print "<td>{$row['max_price']}</td>";
                                        $avg = number_format($row['average_price'],2);
                                        print "<td>{$avg}</td>";
                                        print "</tr>";
                                    }
                                    ?>

                                </tr>
																

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