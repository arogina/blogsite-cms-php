<?php 
    require_once "../shared/header.php"; 

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            try {
                $post = PostService::get($id, Position::CURRENT);

                if (isset($post)) {
                    $comments = CommentService::get_all($id, 1);
                }

            } catch (ErrorException $ex) {
                $_SESSION["msg-error"] = $ex->getMessage();
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["comment"]) && $_POST["comment"] != "") {
            $parent_id = null;
            if (isset($_POST["parent"]) && $_POST["parent"] != "") {
                $parent_id = $_POST["parent"];
            }
            CommentService::create_comment($_SESSION["user"]->get_id(), $_POST["post"], $_POST["comment"], $parent_id);
        }
        header("Location: post.php?id=" . $_POST["post"]);
    }

    function listReplies($comment) {
        global $post;

        $replies = CommentService::get_replies($post->get_id(), $comment->get_id()); 
        if (!$replies) return;
        foreach($replies as $reply) {
            echo "
                <div class='card mx-5 mb-3'>
                    <div class='card-body'>
                        <h6 class='card-title fw-bold'>" . $reply->get_user() . "</h6>
                        <h6 class='card-subtitle mb-2 text-body-secondary'>Replied to: " . $reply->get_parent_user() . "</h6>
                        <h6 class='card-subtitle mb-2 text-body-secondary'>" . $reply->get_date() . "</h6>
                        <p class='card-text'>" . $reply->get_text() . "</p>" . (isset($_SESSION["user"]) ?
                            "<button id='btn-reply-" . $reply->get_id() . "' class='btn btn-outline-primary mb-3' onclick='toggleReplyVisibility(" . $reply->get_id() . ")'>Reply</button>
                            <div id='form-reply-" . $reply->get_id() . "' style='display: none;'>
                            <form class='mx-4 mb-3 d-flex justify-content-between' action='' method='POST'>
                                <div class='flex-fill mx-4'>
                                    <div class='form-floating'>
                                        <textarea class='form-control h-100' id='comment' name='comment' style='resize:none; padding:10px;'></textarea>                
                                    </div>
                                    <input type='hidden' id='parent' name='parent' value='" . $reply->get_id() . "'>
                                    <input type='hidden' id='post' name='post' value='" . $post->get_id() . "'>
                                </div>    
                                <div><input type='submit' value='Reply' class='btn btn-secondary'></div>
                            </form>
                            </div>" : "") . "
                    </div>
                </div>";

            listReplies($reply);
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
    <div class="container d-flex justify-content-between mb-5">
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

<div class="container-fluid">
    <h5>Comments</h5>
    <hr>
    <?php if (isset($_SESSION["user"])): ?>
        <form class="mx-4 mb-3" action="" method="POST">
            <div class="form-floating mb-3">
                <textarea class="form-control h-100" id="comment" name="comment" style="resize:none; padding:10px;"></textarea>                
            </div>
            <input type="hidden" id="post" name="post" value="<?= $post->get_id() ?>">
            <input type="submit" value="Comment" class="btn btn-primary">
        </form>
    <?php else: ?>
        <div class="mx-2 mb-4 d-flex flex-row">
            <h6 class="mx-2 mb-2 text-body-secondary">You must be logged in to comment.</h6>
            <h6><a href="login.php">Login</a></h6>
        </div>
    <?php endif; ?>

    <?php foreach($comments as $comment): ?>
        <div class="card mx-2 mb-3">
            <div class="card-body">
                <h6 class="card-title fw-bold"><?= $comment->get_user() ?></h6>
                <h7 class="card-subtitle mb-2 text-body-secondary"><?= $comment->get_date() ?></h7>
                <p class="card-text"><?= $comment->get_text() ?></p>
                <?php if (isset($_SESSION["user"])): ?>
                    <button id="btn-reply-<?= $comment->get_id() ?>" class="btn btn-outline-primary mb-3" onclick="toggleReplyVisibility(<?= $comment->get_id() ?>)">Reply</button>
                    <div id="form-reply-<?= $comment->get_id() ?>" style="display: none;">
                    <form class="mx-4 mb-3 d-flex justify-content-between" action="" method="POST">
                        <div class="flex-fill mx-4">
                            <div class="form-floating">
                                <textarea class="form-control h-100" id="comment" name="comment" style="resize:none; padding:10px;"></textarea>                
                            </div>
                            <input type="hidden" id="parent" name="parent" value="<?= $comment->get_id() ?>">
                            <input type="hidden" id="post" name="post" value="<?= $post->get_id() ?>">
                        </div>    
                        <div><input type="submit" value="Reply" class="btn btn-secondary"></div>
                    </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
       <?php listReplies($comment) ?>
    <?php endforeach; ?>
</div>
<?php require_once "../shared/footer.php"; ?>