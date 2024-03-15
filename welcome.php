<?php

include('lib/common.php');
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}
?>

<?php include("lib/header.php"); ?>
<title>Bid Fusion Welcome</title>
</head>

<body>
		<div id="main_container">
            <?php include("lib/menu.php"); ?>

            <div class="center_content">
                <div class="center_left">
                 
                    <div class="features">   
                    
                        <div class="profile_section">
                            <div class="subtitle">Bid Fusion Gallery Overview</div>   
          					<p>Bid Fusion is a dynamic online auction platform designed to cater to both Regular Users and Administrative Users, offering a seamless auction experience for buyers and sellers alike. Regular Users have the ability to list their items for sale, browse a wide array of listings, place bids on desired items, rate their auction experiences, leave comments for sellers, and complete purchases securely. With a user-friendly interface and intuitive search functionality, finding the perfect item has never been easier.

                            Administrative Users enjoy enhanced privileges, including access to comprehensive administrative reports for informed decision-making. These reports provide valuable insights into user activity, sales trends, and other key metrics, empowering administrators to optimize the platform's performance and ensure a smooth operation.

                            Bid Fusion prioritizes user satisfaction and security, employing robust measures to safeguard transactions and protect user data. Whether you're a seasoned auction enthusiast or a newcomer to the world of online bidding, Bid Fusion offers a welcoming environment for all users to buy, sell, and engage in the excitement of online auctions.</p>	
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