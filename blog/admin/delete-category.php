<?php
require 'config/database.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // FOR LATER
    //update category_id of posts that belong to this category to id of uncategorized category
    $update_query = "UPDATE posts SET category_id=5 WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    if (!mysqli_errno($connection)){
    //delete category
    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $_SESSION['delete-category-success'] = "Category deleted successfully";
    }
}


//delete user from database
$delete_user_query = "DELETE FROM users WHERE id=$id";
$delete_user_result = mysqli_query($connection, $delete_user_query);
if (mysqli_errno($connection)) {
    $_SESSION['delete-user'] = "Couldnt delete '{$user['firstname']} '{$user['lastname']}'";
} else {
    $_SESSION['delete-user-success'] = "{$user['firstname']} {$user['lastname']} deleted successfully";
}

header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();