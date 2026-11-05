<?php include("pdo_connect.php") ?>
<?php include("Classes/UserActions.php") ?>
<?php
$user_action = new UserActions($pdo);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (
    empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    empty($_POST['confirmPassword'])
  ) {
    echo "All field must be filled";
  } else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    echo $name . $email . $password . $confirm_password;
    $res = $user_action->CreateUser($name, $email, $password);

    if (!$res["success"]) {
      echo $res["msg"];
    }
    echo $res["msg"];
    header("Location:login.php");
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
    <form class="auth-card surface p-4 p-md-5" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="navbar-brand d-flex align-items-center mb-4">
        <span class="brand-mark">P</span>PageTurn
      </div>
      <h1 class="h2 fw-bold">
        Create your account'
      </h1>
      <p class="text-secondary mb-4">
        Join the library and keep your books together.
      </p>
      <div class="mb-3">
        <label class="form-label fw-semibold" for="name">Name</label><input
          id="name"
          name="name"
          class="form-control form-control-lg"
          autocomplete="name"
          required />
      </div>
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
          autocomplete="new-password"
          required />
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold" for="confirmPassword">Confirm password</label><input
          id="confirmPassword"
          name="confirmPassword"
          type="password"
          class="form-control form-control-lg"
          required />
      </div>

      <button class="btn btn-primary btn-lg w-100" type="submit">
        Create account →
      </button>
      <p class="text-center text-secondary mt-4 mb-0">
        Already a member?
        <a
          href="login.php"
          class="fw-bold text-decoration-none">Sign in</a>
      </p>
      <div class="alert alert-info small mt-3 mb-0">
        UI only: authentication and account creation are not implemented yet.
      </div>
    </form>
  </main>










  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>