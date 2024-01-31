<?php 
  include_once __DIR__ . "/../global.php";

  spl_autoload_register(function ($class) {
    $class = str_replace(array('_', '\\'), '/', $class);

    $file = BASE_PATH . "/app/models/$class.class.php";
    if (file_exists($file)) {
      require_once $file;
    }

    $file = BASE_PATH . "/app/config/$class.class.php";
    if (file_exists($file)) {
      require_once $file;
    }

    $file = BASE_PATH . "/app/services/$class.class.php";
    if (file_exists($file)) {
      require_once $file;
    }
  });

  session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BlogSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/style.css">
  </head>
  <body class="my-3 fill-height bg-secondary">
    <main class="container bg-light w-100 pb-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary w-100 mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="/index.php">BlogSite</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if (!isset($_SESSION["user"])) : ?>
                    <li class="nav-item">
                      <a class="nav-link" href="views/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="views/register.php">Register</a>
                    </li>
                    <?php else : ?>
                      <li class="nav-item">
                        <a class="nav-link" href="views/login.php">Profile</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="views/logout.php">Log out</a>
                      </li>
                    <?php endif; ?>
                  </ul>
                  <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
                </div>
            </div>
        </nav>
        
        <?php if (isset($_SESSION["msg-error"])) : ?>
          <div class="alert alert-danger" role="alert">
            <?= $_SESSION["msg-error"] ?>
          </div>
        <?php endif; unset($_SESSION["msg-error"]); ?>

        <?php if (isset($_SESSION["msg-success"])) : ?>
          <div class="alert alert-success" role="alert">
            <?= $_SESSION["msg-success"] ?>
          </div>
        <?php endif; unset($_SESSION["msg-success"]); ?>

        
