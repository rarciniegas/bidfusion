<?php

include('lib/common.php');

if (!isset($_SESSION['user_name'])) {
	header('Location: login.php');
	exit();
}
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
        $keyword = mysqli_real_escape_string($db, $_POST['keyword']);
        $category= mysqli_real_escape_string($db, $_POST['category']);  
        $min_price = number_format($_POST['min_price'],2);
        $max_price = number_format( $_POST['max_price'], 2);
        $shape = mysqli_real_escape_string($db, $_POST['shape']);

        if (empty($keyword)) {
                array_push($error_msg,  "Please enter a keyword.");
        } 

         if (empty($min_price)) {
            array_push($error_msg,  "Please enter a minimum price.");
        }
        
        if (empty($max_price)) {
                array_push($error_msg,  "Please enter a maximum price.");
        }
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
        $_SESSION['keyword'] = $keyword;
        $_SESSION['category'] = $category;
        $_SESSION['min_price'] = $min_price;
        $_SESSION['max_price'] = $max_price;
        $_SESSION['shape'] = $condition;

        header(REFRESH_TIME . 'url=search_results.php');

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
							<div class="subtitle">Item Search</div>    
							<form name="item_search_form" action="item_search.php" method="post">
								<table>
									<tr>
										<td class="item_label">Keyword</td>
										<td>
											<input type="text" name="keyword" value="" />
										</td>
									</tr>
									<tr>
										<td class="item_label">Category</td>
										<td>
										    <select class="form-control" name="category">
									            <option></option>
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
										<td class="item_label">Minimum Price</td>
										<td>
											<input name="min_price" type="number" value="0.00">
										</td>
									</tr>

									<tr>
										<td class="item_label">Maximum Price</td>
										<td>
											<input name="max_price" type="number">
										</td>
									</tr>

                                    <tr>
                                        <td class="item_label">Condition</td>
                                        <td>
                                            <select class="form-control" name="shape">
                                                <option></option>
                                                <option>New</option>
                                                <option>Very Good</option>
                                                <option>Good</option>
                                                <option>Fair</option>
                                                <option>Poor</option>
                                            </select>
                                        </td>
                                    </tr>

									<tr>
										<td>
											<a href="welcome.php" class="fancy_button">Cancel</a> 
										</td>
										<td>
											<a href="javascript:item_search_form.submit();" class="fancy_button">Search</a> 
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