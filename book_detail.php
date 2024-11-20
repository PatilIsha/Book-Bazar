<?php
    include("includes/header.php");
    include("includes/connection.php");

    // Check if $_GET['id'] is set and is numeric
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $bid = $_GET['id'];

        // SQL query with JOIN operation and WHERE clause
        $book_query = "SELECT * FROM book WHERE b_id = $bid";


        // Execute the query
        $book_res = mysqli_query($mysqli, $book_query);

        // Check if any rows are returned
        if(mysqli_num_rows($book_res) > 0) {
            // Fetch the row as an associative array
            $book_row = mysqli_fetch_assoc($book_res);
            $category_id = $book_row['b_cat'];
            $category_query = "SELECT * FROM category WHERE cat_id = $category_id";
            $category_res = mysqli_query($mysqli, $category_query);
            $category_row = mysqli_fetch_assoc($category_res);
            
?>      
    <div id="content">
        <div class="post">
            <h2 class="title"><a href="#"><?php echo $category_row['cat_nm']; ?></a></h2>
            <p class="meta"></p>
            <div class="entry">
                <table class="book_detail" width="100%" border="0px">
                    <tr valign="top">
                        <td width="48%"><img class="book_img" src="<?php echo $book_row['b_img']; ?>" width="280px" height="350px"></td>
                        <td>
                            <h1><?php echo $book_row['b_nm']; ?></h1>
                            <p class="desc"><?php echo $book_row['b_desc']; ?></p>
                            <p class="price">Rs. <?php echo $book_row['b_price']; ?></p>
                            <?php

$is_cart=0;

if(isset($_SESSION['cart']))
{
    foreach($_SESSION['cart'] as $id=>$val)
    {
        if($val['img'] == $book_row['b_img'])
        {	
            $is_cart=1;
            break;
        }
    }
}

if(isset($_SESSION['client']['status']))
{
    if($is_cart==0)
    {
        echo '<a href="addtocart.php?bcid='.$book_row['b_id'].'" class="cart_btn">Add to Cart</a>';
    }
    else
    {
        echo "Already in Cart";
    }
}
else
{
    echo '<a href="#" class="cart_btn">Add to Cart</a><a style="text-decoration: none" href="login.php"><h2>Click here Login..</h2></a>';
}
?>


                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div><!-- end #content -->
<?php
        } else {
            echo "No book found with the provided ID.";
        }
    } else {
        echo "Invalid book ID.";
    }

    include("includes/footer.php");
?>
