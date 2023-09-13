<?php
require 'config/database.php';

//get form data if submit button was clicked
if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT); 
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumnail = $_FILES['thumnail'];

    //set is_featured to 0 if uncheceked
    $is_featured = $is_featured == 1 ?: 0;

    //validate input values
    if (!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumnail['name']) {
        $_SESSION['add-post'] = "Choose post thumnail";
    } else {
        //work on thumnail
        //rename the image
        $time = time(); //make each image name unique
        $thumnail_name = $time . $thumnail['name'];
        $thumnail_tmp_name = $thumnail['tmp_name'];
        $thumnail_destination_path = '../images/' . $thumnail_name;

        //make sure file is an image
        $allowed_files = ['png','jpg','jpeg'];
        $extention = explode('.', $thumnail_name);
        $extention = end($extention);
                if (in_array($extention, $allowed_files)) {
                    //make sure image is not too large 2mb++
                    if ($thumnail['size'] < 2_000_000) {
                        //upload avatar
                        move_uploaded_file($thumnail_tmp_name, $thumnail_destination_path);
                    } else {
                        $_SESSION['add-post'] = "File size to big. should be less than 1mb";
                    }
                } else {
                    $_SESSION['add-post'] = "File should be png, jpg, jpeg";
                }
            }

         // redirect back to signup pag eif there was any problem
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        //set is_featured of all posts to 0 id is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        //insert posts into users table
        $insert_query = "INSERT INTO posts (title, body, thumnail, category_id, author_id, is_featured) VALUES
         ('$title', '$body', '$thumnail_name', $category_id, $author_id, $is_featured)";
        //"INSERT INTO posts SET title='$title', body='$body', thumnail='$thumnail_name', category_id=' $category_id', author_id=' $author_id', is_featured=' $is_featured'";
        
        $result = mysqli_query($connection, $insert_query);

        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-success'] = "New post added successfully";
            header('location:' . ROOT_URL . 'admin/');
            die();
        }
    }
}
    header('location:' . ROOT_URL . 'admin/add-post.php');
    die();


    