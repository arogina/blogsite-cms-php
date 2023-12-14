<?php 
    require_once "../shared/header.php"; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION["msg-error"] = "ERROR MESSAGE!!";
        $_SESSION["msg-success"] = "SUCCESS MESSAGE!!";
        header("Refresh:0");
    }
?>

<h2 class="text-center mb-5">Register</h2>

<form class="w-50 mx-auto" action="" method="POST">
<div class="form-floating mb-3">
        <input type="text" id="username" class="form-control" autofocus>
        <label for="username">Username</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" id="email" class="form-control" autofocus>
        <label for="email">E-mail</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" id="password" class="form-control" autofocus>
        <label for="password">Password</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" id="repeat-password" class="form-control" autofocus>
        <label for="repeat-password">Repeat password</label>
    </div>
    <div class="w-100 d-flex justify-content-end">
        <input type="submit" value="Register" class="btn btn-primary">
    </div>
</form>

<?php require_once "../shared/footer.php"; ?>