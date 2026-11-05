<?php include("pdo_connect.php") ?>
<?php include("Classes/UserActions.php") ?>
<?php
session_start();
$user_action = new UserActions($pdo);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(!isset($_POST['email']) || !isset($_POST['password'])){
        // Add toast;
        echo "Must Needed";
    }
    $email= $_POST['email'];
    $password=$_POST['password'];
    $res=$user_action->Login($email,$password);
    if(!$res["success"]){
        //todo
        echo $res["msg"];
    }else{
        header("Location:index.php");
        exit();
    }

}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PageTurn — Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/auth.css">

</head>

<body>
   

    <main class="auth-area px-3 py-5">
        <form class="auth-card surface p-4 p-md-5" method="POST" action="#">
            <div class="navbar-brand d-flex align-items-center mb-4">
                <span class="brand-mark">P</span>PageTurn
            </div>
            <h1 class="h2 fw-bold">
               Welcome back
            </h1>
            <p class="text-secondary mb-4">
                Sign in to see your borrowed books and reading history.
            </p>
            <div class="mb-3">
                <label class="form-label fw-semibold" for="username">Email</label><input
                    id="email"
                    name="email"
                    class="form-control form-control-lg"
                    autocomplete="email"
                    required />
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold" for="password">Password</label><input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control form-control-lg"
          
                    required />
            </div>

            <div class="mb-4"></div>

            <button class="btn btn-primary btn-lg w-100" type="submit">
                Sign in →
            </button>
            <p class="text-center text-secondary mt-4 mb-0">
                New to PageTurn?
                <a
                    href="signup.php"
                    class="fw-bold text-decoration-none">Create an account</a>
            </p>
            <div class="alert alert-info small mt-3 mb-0">
                UI only: authentication and account creation are not implemented yet.
            </div>
        </form>
    </main>










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>