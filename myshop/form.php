<?php
// show php errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();




// GET
if (isset($_GET['edit_id'])) {
    // 1. Get the ID from the URL parameter
    $id = $_GET['edit_id'];

    // 2. Prepare the query to fetch the user data
    $stmt = $objUser->runQuery("SELECT * FROM crud_users WHERE id=:id");

    // 3. Execute the statement, binding the ID parameter
    $stmt->execute(array(":id" => $id));

    // 4. Fetch the data as an associative array
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // If no edit_id is provided in the URL, initialize variables for a new user
    $id = null;
    $rowUser = null;
}



// POST
if (isset($_POST['btn_save'])) {
    // Sanitize and get form data
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);

    try {
        // Check if $id is set (indicating an update operation)
        if ($id != null) {
            if ($objUser->update($name, $email, $id)) {
                // Success: Redirect with 'updated' status
                $objUser->redirect('index.php?updated');
            }
        } else {
            // No $id set: Perform an insert operation (new user)
            if ($objUser->insert($name, $email)) {
                // Success: Redirect with 'inserted' status
                $objUser->redirect('index.php?inserted');
            } else {
                // Failure during insert
                $objUser->redirect('index.php?error');
            }
        }
    } catch (PDOException $e) {
        // Catch and display any database/PDO exceptions
        echo $e->getMessage();
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Head metas, css, and title -->
    <?php require_once 'includes/head.php'; ?>
</head>

<body>
    <!-- Header banner -->
    <?php require_once 'includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar menu -->
            <?php require_once 'includes/sidebar.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h1 style="margin-top: 10px">Add / Edit Users</h1>
                <p>Required fields are in (*)</p>
                <form method="post">
                    <div class="form-group">
                        <label for="id">id</label>
                        <input class="form-control" type="text" name="id" id="id" value="<?php echo $rowUser['id'] ?? ''; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">name *</label>
                        <input class="form-control" type="text" name="name" id="name" value="<?php echo $rowUser['name'] ?? ''; ?>" placeholder="first name and last name" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="email">email *</label>
                        <input class="form-control" type="text" name="email" id="email" value="<?php echo $rowUser['email'] ?? ''; ?>" placeholder="johnjoe@gmail.com" required maxlength="100">
                    </div>

                    <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="save">

                </form>
            </main>
        </div>
    </div>
    <!-- Footer scripts, and functions -->
    <?php require_once 'includes/footer.php'; ?>
</body>

</html>