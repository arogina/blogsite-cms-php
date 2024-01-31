<?php 
    require_once "shared/header.php"; 

    $posts = PostService::get_all(1);
?>

<div class="container-fluid">
  <div class="row">
    <?php foreach($posts as $post): ?>
        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card" style="width: 18rem; height: 13rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $post->get_title() ?></h5>
                <p class="card-text"><?= substr($post->get_content(), 0, 70) ?>...</p>
                <a href="#" class="card-link">Read more...</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once "shared/footer.php"; ?>