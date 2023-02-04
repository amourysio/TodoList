<?php

//Check email is valid or not function
function emailIsValid($email)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}


//Check login details is valid or not function
function checkLoginDetails($email)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}


//Create user function
function createUser($email, $password)
{
    $conn = dbConnect();
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $sql);
    return $result;
}


//Get Header function
function getHead()
{
    $pageTitle = dynamicTitle();
    $output = '<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>'. $pageTitle .' - List</title>';

    echo $output;
}


//Get Header function
function getHeader()
{
    $output = '<header class="py-3 mb-4 border-bottom bg-white">
        <div class="d-flex flex-wrap justify-content-center container">
            <a href="todos.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">Task List</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="crud/create.php" class="nav-link bg-success text-white">Create New Task</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link bg-danger text-white">Logout</a></li>
            </ul>
        </div>
    </header>';

    echo $output;
}

//Get Header function for CRUD Directory
function getHeaderCrud()
{
    $output = '<header class="py-3 mb-4 border-bottom bg-white">
        <div class="d-flex flex-wrap justify-content-center container">
            <a href="../todos.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">Task List</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="../index.php" class="nav-link active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="create.php" class="nav-link bg-success text-white">Create New Task</a></li>
                <li class="nav-item"><a href="../logout.php" class="nav-link bg-danger text-white">Logout</a></li>
            </ul>
        </div>
    </header>';

    echo $output;
}



/* Text Limit function */
function textLimit($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . "...";
    } else {
        return $string;
    }
}


//Get todo task function
function getTodo($todo)
{
    $output = '<div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">'. textLimit($todo['title'], 28) .'</h4>
            <p class="card-text">'. textLimit($todo['description'], 75) .'</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="crud/read.php?id='. $todo['id'] .'" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="crud/update.php?id='. $todo['id'] .'" class="btn btn-sm btn-outline-secondary">Update</a>
                </div>
                <small class="text-muted">'. $todo['date'] .'</small>
            </div>
        </div>
    </div>';

    echo $output;
}


//Dynamic Title function
function dynamicTitle()
{
    global $conn;
    $filename = basename($_SERVER["PHP_SELF"]);
    $pageTitle = "";
    switch ($filename) {
        case 'index.php':
            $pageTitle = "Home";
            break;

        case 'todos.php':
            $pageTitle = "Task List";
            break;

        case 'create.php':
            $pageTitle = "Create Task";
            break;

        case 'update.php':
            $pageTitle = "Update Task";
            break;

        case 'read.php':
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
            $sql1 = "SELECT * FROM todos WHERE id='{$todoId}'";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
                    $pageTitle = $todo["title"];
                }
            }
            break;

        default:
            $pageTitle = "Task List";
            break;
    }

    return $pageTitle;
}

//Script include function
function getScript()
{
    $output = '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>';

    echo $output;
}
