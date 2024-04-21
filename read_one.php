<?php 

// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connect to objects;
$product = new Product($db);
$category = new Category($db);

// set id property of product to be edited
$product->id = $id;

// read the defailts of product to be edited
$product->readOne();

$page_title = "Read One Product";
include_once "layout_header.php";

if ($_POST) {
    // update new product details

    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];

    // update the product
    if ($product->update()) {
        echo "<div class='alert alert-success alert-dismissable'>
            Product was updated
        </div>";
    } else {
        // if unable to update the product, tell the user
        echo "<div class='alert alert-danger alert-dismissable'>
            Unable to update product
        </div>";
    }
   
}

?>

    <h3 class="display-4">Read One Product</h3>
    <hr>

    <a href="index.php" class="btn btn-secondary mb-3">Go back</a>

    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Name</td>
            <td><?= $product->name; ?></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><?= $product->price; ?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><?= $product->description; ?></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
                <?php
                    $category->id = $product->category_id;
                    $category->readName();
                    echo $category->name;
                ?>
            </td>
        </tr>
    </table>
<?php 

include_once "layout_footer.php";

?>