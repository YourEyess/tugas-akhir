<?php
require 'config/database.php';

//get form data if submit button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumnail_name = filter_var($_POST['previous_thumnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT); 
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumnail = $_FILES['thumnail'];

    //set is_featured to 0 if uncheceked
    $is_featured = $is_featured == 1 ?: 0;

    //validate input values
    if (!$title) {
        $_SESSION['edit-post'] = "Couldnt update post. invalid form data on edit post page";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldnt update post. invalid form data on edit post page";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldnt update post. invalid form data on edit post page";
    } else {
        //delete existing thumnail if new thumnail is available
        if ($thumnail['name']) {
            $previous_thumnail_path = '../images/' . $previous_thumnail_name;
            if ($previous_thumnail_path) {
                unlink($previous_thumnail_path);
            }
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
                    if ($thumnail['size'] < 2000000) {
                        //upload avatar
                        move_uploaded_file($thumnail_tmp_name, $thumnail_destination_path);
                    } else {
                        $_SESSION['edit-post'] = "File size to big. should be less than 1mb";
                    }
                } else {
                    $_SESSION['edit-post'] = "File should be png, jpg, jpeg";
                }
            }
        }

         // redirect back to signup pag eif there was any problem
    if ($_SESSION['edit-post']) {
        header('location:' . ROOT_URL . 'admin/');
        die();
    } else {
        //set is_featured of all posts to 0 id is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }
        
        //set thumnail name if a new one was uploaded, else keep old thumnail name
        $thumnail_to_insert = $thumnail_name ?? $previous_thumnail_name;

        //insert posts into users table
        $update_query = "UPDATE posts SET title='$title', body='$body', thumnail='$thumnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $update_query);
    }

        if (!mysqli_errno($connection)) {
            $_SESSION['edit-post-success'] = "Post updated successfully";
        }
    }
    
    header('location:' . ROOT_URL . 'admin/');
    die();


    