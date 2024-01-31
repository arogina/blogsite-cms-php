<?php require_once "shared/header.php"; ?>

<?php if (isset($_SESSION["user"])) : ?>
<h2>Welcome, <?= $_SESSION["user"]->get_username() ?>!</h2>
<?php endif; ?>

<?php require_once "shared/footer.php"; ?>