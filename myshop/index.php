<?php
// show php errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/user.php';
$objUser = new User();

// GET: Handles the deletion request
if (isset($_GET['delete_id'])) {

    // Get the ID of the user to be deleted
    $id = $_GET['delete_id'];

    var_dump($id);

    try {
        // Check if the ID is valid (not null)
        if ($id != null) {

            // Call the delete method on the User object
            if ($objUser->delete($id)) {

                // Success: Redirect the user to index.php with a 'deleted' status
                $objUser->redirect('index.php?deleted');
            }
        }
    } catch (PDOException $e) {
        // Catch and display any database-related errors
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
                <h1 style="margin-top: 10px">DataTable</h1>

                <?php
                // Check if the 'updated' parameter exists in the URL
                if (isset($_GET['updated'])) {
                    // Echo an HTML alert box with a success message
                    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong>User!</strong> Updated with success.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else if (isset($_GET['deleted'])) {
                    // Echo an HTML alert box with a success message
                    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong>User!</strong> deleted with success.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else if (isset($_GET['inserted'])) {
                    // Echo an HTML alert box with a success message
                    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong>User!</strong> inserted with success.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else if (isset($_GET['error'])) {
                    // Echo an HTML alert box with a success message
                    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong>DB error!</strong> something went wrong with your action, try again.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
                ?>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>full name</th>
                                <th>email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php
                        $query = "SELECT * FROM crud_users";
                        $stmt = $objUser->runQuery($query);
                        $stmt->execute();
                        ?>
                        <tbody>
                            <?php if ($stmt->rowCount() > 0) {
                                while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td><?php print($rowUser['id']); ?> </td>

                                        <td>
                                            <!-- Link to the edit form, passing the user's ID as the 'edit_id' parameter -->

                                            <a href="form.php?edit_id=<?php print($rowUser['id']); ?>">
                                                <?php print($rowUser['name']); ?>
                                            </a>
                                        </td>

                                        <td><?php print($rowUser['email']); ?> </td>


                                        <td>
                                            <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['id']); ?>">
                                                <span data-feather="trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }   // <-- closes while loop
                            }       // <-- closes if rowCount
                            ?>
                        </tbody>

                    </table>
                </div>

            </main>
        </div>
    </div>
    <!-- Footer scripts, and functions -->
    <?php require_once 'includes/footer.php'; ?>

    <!-- Custom scripts -->
    <script>
        // jQuery confirmation for delete actions
        $('.confirmation').on('click', function() {
            return confirm('Are you sure you want to delete this user?');
        });
    </script>
</body>

</html>