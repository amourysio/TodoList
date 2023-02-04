<?php
include "../includes/config.php";
include "../includes/func.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

$msg = "";

if (isset($_POST["addTodo"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

    // Get User Id based on user email
    $sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $user_id = $row["id"];
    } else {
        $user_id = 0;
    }
    $sql = null;

    // Inserting task
    $sql = "INSERT INTO todos (title, description, user_id) VALUES ('$title', '$desc', '$user_id')";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $_POST["title"] = "";
        $_POST["desc"] = "";
        $msg = "<div class='alert alert-success'>Task is created.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Task is not created.</div>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body class="bg-light">
    <?php getHeaderCrud(); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card bg-white rounded border shadow">
                    <div class="card-header px-4 py-3">
                        <h4 class="card-title">Create Task</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php echo $msg; ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Write Task Title" value="<?php if (isset($_POST["addTodo"])) {
                                                                                                                                                    echo $_POST["title"];
                                                                                                                                                } ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea class="form-control" id="desc" name="desc" placeholder="Write Task Description" rows="3" required><?php if (isset($_POST["addTodo"])) {
                                                                                                            echo $_POST["title"];
                                                                                                        } ?></textarea>
                            </div>
                            <div>
                                <button type="submit" name="addTodo" class="btn btn-success me-2">Create</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php getScript(); ?>
</body>

</html>