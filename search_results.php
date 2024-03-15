<?php

include('lib/common.php');


if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}
if (!empty($_GET['item_selected'])) {

    $_SESSION['item_selected'] = $_GET['item_selected'];
    header(REFRESH_TIME . 'url=item_for_sale.php');
}
?>

<?php include("lib/header.php"); ?>
<title>Bid Fusion Search Results</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="subtitle">Search Results</div>
            <form name="bid_on_item_form" action="search_results.php" method="post">
                <table>
                    <tr>
                        <td class="heading">ID</td>
                        <td class="heading">Item Name</td>
                        <td class="heading">Current Bid</td>
                        <td class="heading">High Bidder</td>
                        <td class="heading">Get it Now Price</td>
                        <td class="heading">Auction Ends</td>
                    </tr>
                    <tr>
                        <?php
                        $keyword = $_SESSION['keyword'];
                        $category = $_SESSION['category'];
                        $min_price = $_SESSION['min_price'];
                        $max_price = $_SESSION['max_price'];
                        if ($max_price == ''){
                            $max_price = 9999999.00;
                        }
                        $shape = $_SESSION['shape'];
                        if ($category == '') {
                            $query = "SELECT Item.itemID, Item.item_name, Item.get_it_now, Item.ends_in, Bid.user_name, MAX(Bid.bid_amount) AS current_bid
                                        FROM Item LEFT JOIN Bid ON (Item.itemID = Bid.itemID)
                                        WHERE  (item_name LIKE '%$keyword%' OR description LIKE '%$keyword%') 
                                                AND '$shape'<= Item.item_condition       
                                        GROUP BY itemID
                                        ORDER BY ends_in";
                        } else {
                            $query = "SELECT Item.itemID, Item.item_name, Item.get_it_now, Item.ends_in, Bid.user_name, MAX(Bid.bid_amount) AS current_bid
                                        FROM Item LEFT JOIN Bid ON (Item.itemID = Bid.itemID)
                                        WHERE  (item_name LIKE '%$keyword%' OR description LIKE '%$keyword%') 
                                                AND '$category' = Item.category 
                                                AND '$shape'<= Item.item_condition       
                                        GROUP BY itemID
                                        ORDER BY ends_in";
                        }

                        $result = mysqli_query($db, $query);
                        if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                            array_push($error_msg,  "SELECT ERROR: search results <br>" . __FILE__ ." line:". __LINE__ );
                        }
                        $time_now = date("Y-m-d h:i:s");
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            if ($row['ends_in'] > $time_now) {
                                if ((!$row['current_bid']) or (($min_price <= $row['current_bid']) and ($row['current_bid'] <= $max_price))) {
                                    print "<tr>";
                                    print "<td>{$row['itemID']}</td>";

                                    print "<td><a href='search_results.php?item_selected=" . urlencode($row['itemID']) . "'>{$row['item_name']}</a>
                                            </td>";


                                    print "<td>{$row['current_bid']}</td>";
                                    print "<td>{$row['user_name']}</td>";
                                    print "<td>{$row['get_it_now']}</td>";
                                    print "<td>{$row['ends_in']}</td>";
                                    print "</tr>";
                                }
                            }
                        }
                        ?>

                    </tr>

                    <tr>
                        <td></td><td></td><td></td><td></td><td></td>
                        <td>
                            <a href="item_search.php" class="fancy_button">Back to Search</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>

    <?php include("lib/footer.php"); ?>

</div>
</body>
</html>