<?php
include 'partials/header.php';

//fetch 9 posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);
?>

    <section class="search-bar">
        <form class="container search-bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
    <!--end search-->


    <section class="posts">
        <div class="container posts-container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post-thumnail">
                <img src="./images/<?= $post['thumnail'] ?>">
            </div>
            <div class="post-info">
                <h3 class="post-title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                <p class="post-body">
                <?= substr($post['body'], 0, 150) ?>...
                </p>
                <div class="post-author">
                <?php
                    //fetch author from users table using author_id
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);

                    ?>
                    <div class="post-author-avatar">
                        <img src="./images/<?= $author['avatar'] ?>">
                    </div>
                    <div class="post-author-info">
                        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small>
                        <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
         </article>
         <?php endwhile ?>
        </div>
    </section>
    <!--end post-->
    <section class="category-buttons">
        <div class="container category-buttons-container">
            <?php
            $all_categories_query = "SELECT * FROM categories";
            $all_categories = mysqli_query($connection, $all_categories_query);
            ?>
            <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>"
            class="category-button"><?= $category['title'] ?></a>
            <?php endwhile ?>
        </div>
    </section>
    <!--end button-->
<?php
include 'partials/footer.php';

?>