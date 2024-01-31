<?php 
    require_once "../shared/header.php"; 

    if (isset($_SESSION["user"])) header("Location: index.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $repeat_password = $_POST["repeat-password"] ?? "";

        if ($username == "" || $email == "" || $password == "" || $repeat_password == "") {
            $_SESSION["msg-error"] = "There are empty fields! Try again!";
            header("Refresh:0");
        } else if ($password != $repeat_password) {
            $_SESSION["msg-error"] = "Password and repeated password don't match!";
            header("Refresh:0");
        } else {
            if (UserService::create($username, $email, $password)) {
                $_SESSION["msg-success"] = "User succesfully registered!";
                header("Location: views/login.php");
            } else {
                $_SESSION["msg-error"] = "Error occured! Try again!";
                header("Refresh:0");
            }
        }
    }
?>

<h2 class="text-center mb-5">Register</h2>

<form class="w-50 mx-auto" action="" method="POST">
<div class="form-floating mb-3">
        <input type="text" id="username" name="username" class="form-control" autofocus>
        <label for="username">Username</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" id="email" name="email" class="form-control">
        <label for="email">E-mail</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" id="password" name="password" class="form-control">
        <label for="password">Password</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" id="repeat-password" name="repeat-password" class="form-control">
        <label for="repeat-password">Repeat password</label>
    </div>
    <div class="w-100 d-flex justify-content-end">
        <input type="submit" value="Register" class="btn btn-primary">
    </div>
</form>

<?php require_once "../shared/footer.php"; ?>