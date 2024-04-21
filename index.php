<?php 

    $page_title = "Read products";
    include_once "layout_header.php";

    // page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    // set number of records pre page
    $records_per_page = 5;
    // calculate for the query LIMIT clause
    $from_record_num = ($records_per_page * $page) - $records_per_page;

    include_once "config/database.php";
    include_once "objects/product.php";
    include_once "objects/category.php";

    // instantiate database and objects
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    // query products
    $stmt = $product->readAll($from_record_num, $records_per_page);
    $num = $stmt->rowCount();

?>

    <div class="mt-3">
        <a href="create_product.php" class="btn btn-success">Create product</a>
        <hr>
        <h3 class="display-4 mb-5">All Products</h3>

        <?php 
            if ($num > 0) {
                echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th>Product</th>";
                        echo "<th>Price</th>";
                        echo "<th>Description</th>";
                        echo "<th>Category</th>";
                        echo "<th>Actions</th>";
                    echo "</tr>";    

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>";
                            echo "<td>{$name}</td>";
                            echo "<td>{$price}</td>";
                            echo "<td>{$description}</td>";
                            echo "<td>";
                                    $category->id = $category_id;
                                    $category->readName();
                                    echo $category->name; 
                            echo "</td>";

                            echo "<td>";
                                // read one, edit and delete button will be here
                                echo "<a href='read_one.php?id={$id}' class='btn btn-primary mx-1'>Read</a>";
                                echo "<a href='update_product.php?id={$id}' class='btn btn-info mx-1'>Edit</a>";
                                echo "<a delete-id='{$id}' class='btn btn-danger delete-object mx-1'>Delete</a>";
                            echo "</td>";

                        echo "</tr>";
                    }

                echo "</table>";

                // paging buttons will be here
            } else {
                // tell the user there are no products
                echo "<div class='alert alert-info'>No products found.</div>";
            }
        ?>

        <?php 

            // the page where this paging is used
            $page_url = "index.php?";
            // count all products in the database to calculate total pages
            $total_rows = $product->countAll();
            // paging buttons here
            include_once 'paging.php'; 
        
        ?>

    </div>

<?php
    include_once "layout_footer.php";
?>