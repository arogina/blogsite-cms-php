<?php 
    require_once "shared/header.php";

    $page = 1;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
    }
    
    $posts = PostService::get_all($page);
    $num_rows = PostService::get_num_rows();
    $pages = ceil($num_rows / PAGE_LENGTH);
?>

<div class="container-fluid">
    <h2>Latest</h2>
    <hr>
    <div class="row">
    <?php foreach($posts as $post): ?>
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-12 mb-4">
            <div class="card" style="width: 25rem; height: 15rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= $post->get_title() ?></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Published: <?= $post->get_date() ?></h6>
                    <p class="card-text"><?= substr($post->get_content(), 0, 70) ?>...</p>
                    <a href="views/post.php?id=<?= $post->get_id() ?>" class="card-link">Read more...</a>
                    <h6 class="card-subtitle mt-2 text-body-secondary text-end">Author: <?= $post->get_author() ?></h6>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page - 1 <= 0 ? 1 : $page - 1?>">Previous</a></li>
            <?php for($i = 1; $i <= $pages; $i++): ?>
                <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page + 1 > $pages ? $pages : $page + 1 ?>">Next</a></li>
        </ul>
    </div>
</div>

<?php require_once "shared/footer.php"; ?>