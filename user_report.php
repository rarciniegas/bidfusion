<?php


include('lib/common.php');


if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}

?>

<?php include("lib/header.php"); ?>
		<title>Bid Fusion User Report</title>
	</head>
	
	<body>
        <div id="main_container">
		    <?php include("lib/menu.php"); ?>
            
			<div class="center_content">
				<div class="center_left">
					<div class="features">   	
						<div class="profile_section">
                        	<div class="subtitle">User Report</div>   
							<table>
								<tr>
									<td class="heading">Username</td>
									<td class="heading">Listed</td>
									<td class="heading">Sold</td>
									<td class="heading">Purchased</td>
									<td class="heading">Rated</td>
								</tr>
                                <tr>
                                    <?php
                                    $sql = "CREATE OR REPLACE VIEW q1\n"
                                        . "    AS SELECT itemID, MAX(bid_amount) as sold_for\n"
                                        . "    FROM Bid\n"
                                        . "    GROUP BY itemID";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW q2\n"

                                        . "    AS  SELECT q1.itemID, Item.user_name, q1.sold_for\n"

                                        . "    FROM q1, Item\n"

                                        . "    WHERE q1.itemID = Item.itemID AND q1.sold_for >= Item.reserve";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW q3\n"

                                        . "    AS SELECT Item.user_name, COUNT(Item.user_name) AS sold\n"

                                        . "    FROM Item JOIN q2 ON Item.ItemID = q2.ItemID\n"

                                        . "    GROUP BY user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW q4\n"

                                        . "    AS SELECT Bid.itemID,Bid.user_name\n"

                                        . "    FROM q2, Bid\n"

                                        . "    WHERE q2.itemID = Bid.itemID AND q2.sold_for = Bid.bid_amount";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW q5\n"

                                        . "    AS SELECT user_name, COUNT(user_name) as purchased\n"

                                        . "    FROM q4\n"

                                        . "    GROUP BY user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW q6\n"

                                        . "    AS SELECT user_name, COUNT(user_name)as rated\n"

                                        . "    FROM Rating\n"

                                        . "    GROUP BY user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW q7\n"

                                        . "    AS SELECT user_name, COUNT(user_name)as listed\n"

                                        . "    FROM Item\n"

                                        . "    GROUP BY user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW r1\n"

                                        . "    AS SELECT User.user_name, q7.listed\n"

                                        . "    FROM  User LEFT JOIN q7 ON User.user_name = q7.user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW r2\n"

                                        . "    AS SELECT r1.user_name, r1.listed, q3.sold\n"

                                        . "    FROM  r1 LEFT JOIN q3 ON r1.user_name = q3.user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "CREATE OR REPLACE VIEW r3\n"

                                        . "    AS SELECT r2.user_name, r2.listed, r2.sold, q5.purchased\n"

                                        . "    FROM  r2 LEFT JOIN q5 ON r2.user_name = q5.user_name";
                                    $result = mysqli_query($db, $sql);
                                    $sql = "SELECT r3.user_name, r3.listed, r3.sold, r3.purchased, q6.rated\n"

                                        . "    FROM  r3 LEFT JOIN q6 ON r3.user_name = q6.user_name\n"

                                        . "    ORDER BY r3.listed DESC";

                                    $result = mysqli_query($db, $sql);

                                    if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                        array_push($error_msg,  "SELECT ERROR:  <br>" . __FILE__ ." line:". __LINE__ );
                                    }

                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['user_name']}</td>";
                                        print "<td>{$row['listed']}</td>";
                                        if (!$row['sold']){
                                            print "<td>0</td>";
                                        } else {
                                            print "<td>{$row['sold']}</td>";
                                        }
                                        if (!$row['purchased']){
                                            print "<td>0</td>";
                                        } else {
                                            print "<td>{$row['purchased']}</td>";
                                        }
                                        if (!$row['rated']){
                                            print "<td>0</td>";
                                        } else {
                                            print "<td>{$row['rated']}</td>";
                                        }
                                        print "</tr>";
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