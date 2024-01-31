<?php 
    require_once "../shared/header.php"; 

    if (isset($_SESSION["user"])) header("Location: index.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["email"]) || $_POST["email"] == "") {
            $_SESSION["msg-error"] = "E-mail is required! Try again!";
            header("Refresh:0");
        } else if (!isset($_POST["password"]) || $_POST["password"] == "") {
            $_SESSION["msg-error"] = "Password is required! Try again!";
            header("Refresh:0");
        } else {
            $user = UserService::login($_POST["email"], $_POST["password"]);

            if (isset($user)) {
                $_SESSION["msg-success"] = "Succesfully logged in!";
                $_SESSION["user"] = $user;
                header("Location: index.php");
            } else {
                $_SESSION["msg-error"] = "Error occured while trying to log in!";
                header("Refresh:0");
            }
        }
    }
?>

<h2 class="text-center mb-5">Login</h2>

<form class="w-50 mx-auto" action="" method="POST">
    <div class="form-floating mb-3">
        <input type="email" id="email" name="email" class="form-control" autofocus>
        <label for="email">E-mail</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" id="password" name="password" class="form-control" autofocus>
        <label for="password">Password</label>
    </div>
    <div class="w-100 d-flex justify-content-between">
        <a href="views/register.php">Register</a>
        <input type="submit" value="Login" class="btn btn-primary">
    </div>
</form>

<?php require_once "../shared/footer.php"; ?>