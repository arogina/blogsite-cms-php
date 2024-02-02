<?php 
    require_once "../shared/header.php"; 

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            try {
                $post = PostService::get($id, Position::CURRENT);
            } catch (ErrorException $ex) {
                $_SESSION["msg-error"] = $ex->getMessage();
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    }
?>

<div class="container-fluid">
    <h2> <?= $post->get_title() ?> </h2>
    <h6 class="mt-2 text-body-secondary">Published: <?= $post->get_date() ?> </h6>
    <hr>
    <div class="container-md mb-5 mt-5">
        <p style="text-align: justify;"><?= $post->get_content() ?></p>
    </div>
    <h5 class="mt-2 text-body-secondary text-end mb-5">Written by: <?= $post->get_author() ?> </h5>
    <div class="container d-flex justify-content-between">
        <a class="page-link" href="post.php?id=<?php 
            try {
                $post_prev = PostService::get($post->get_id(), Position::PREVIOUS);
                echo $post_prev->get_id();
            } catch (ErrorException $ex) {
                echo $post->get_id();
            }
        ?>">&laquo; Previous post</a>
        <a class="page-link" href="post.php?id=<?php 
            try {
                $post_next = PostService::get($post->get_id(), Position::NEXT);
                echo $post_next->get_id();
            } catch (ErrorException $ex) {
                echo $post->get_id();
            }
        ?>">Next post &raquo;</a>
    </div>
</div>

<?php require_once "../shared/footer.php"; ?>