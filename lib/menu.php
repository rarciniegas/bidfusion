
			<div id="header">
                <div class="logo"><img src="img/Bid_Fusion.png" style="opacity:0.8;background-color: #E9E5E2;"  alt="" title="Bid Fusion Logo"/></div>
			</div>
			
			<div class="nav_bar">
				<ul>    
                    <li><a href="welcome.php" <?php if($current_filename=='welcome.php') echo "class='active'"; ?>>Welcome</a></li>                       
					<li><a href="list_item.php" <?php if(strpos($current_filename, 'list_item.php') !== false) echo "class='active'"; ?>>List Item</a></li>  
                    <li><a href="item_search.php" <?php if($current_filename=='item_search.php') echo "class='active'"; ?>>Item Search</a></li>  
                    <li><a href="auction_results.php" <?php if($current_filename=='auction_results.php') echo "class='active'"; ?>>Auction Results</a></li>
                    <?php
                        $user_name = $_SESSION['user_name'];
                        $query = "SELECT user_name, position
                                                FROM AdminUser
                                                WHERE user_name='$user_name'";

                        $result = mysqli_query($db, $query);
                    $count = mysqli_num_rows($result);

                    if (!empty($result) && ($count > 0) ){
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        print "<li><a href='category_report.php'>Category Report</a></li>";
                        print "<li><a href='user_report.php'>User Report</a></li>";
                        print "<li>{$row['position']}</li>";
                        }
                     ?>
                    <li><a href="logout.php"> <span class='glyphicon glyphicon-log-out'></span> Log Out</a></li>
				</ul>
			</div>