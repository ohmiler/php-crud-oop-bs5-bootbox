
<?php 

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


$page_title = "Create Product";
include_once "layout_header.php";

if ($_POST) {
    // set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];

    // create the product
    if ($product->create()) {
        echo "<div class='alert alert-success'>Product was created.</div>";
    } else {
        // if unable to create the product, tell the user
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}

?>

<h3 class="display-4">Create Product</h3>
<hr>

<a href="index.php" class="btn btn-secondary mb-3">Go back</a>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><input type="text" name="name" class="form-control" /></td>
    </tr>
    <tr>
        <td>Price</td>
        <td><input type="text" name="price" class="form-control" /></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><textarea name="description" class="form-control"></textarea></td>
    </tr>
    <tr>
        <td>Category</td>
        <td>
            <!-- Categories from database will be here -->
            <?php 
                
                $stmt = $category->read();
                echo "<select class='form-control' name='category_id'>";
                    echo "<option>Select category...</option>";

                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_category);
                        echo "<option value='${id}'>{$name}</option>";
                    }
                echo "</select>";
            ?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>
            <button type="submit" class="btn btn-primary">Create</button>
        </td>
    </tr>
</table>
</form>

<?php 

include_once "layout_footer.php";

?>