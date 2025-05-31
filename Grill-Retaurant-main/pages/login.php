<?php
require_once '../classes/User.php';
require_once '../_functions/debug_to_console.php';;
$user = new User();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center mt-5">
        
        <div class="col-md-6">
            <div class="card">
                <div class="text-start m-3">
                    <a href="../index.php" class="btn btn-secondary">&larr; Back</a>
                </div>
                <div class="card-body">
                    <div id="loginForm">
                        <?php
                        if (!empty($_POST)) {
                            foreach ($_POST as $key => $value) {
                                debug_to_console("$key: $value");
                            }
                            if (isset($_POST['email']) && isset($_POST['password'])) {
                                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                                $password = $_POST['password'];
                                if ($email !== false) {
                                    $user->login($email, $password);
                                }
                            } else if (isset($_POST['reg_email']) && isset($_POST['reg_password'])) {
                                $email = filter_var($_POST['reg_email'], FILTER_SANITIZE_EMAIL);
                                $password = $_POST['reg_password'];
                                $name = $_POST['reg_name'];
                                $description = $_POST['reg_description'];
                                if ($email !== false) {
                                    $clientDB = new UniversalDB('clients');
                                    if (empty($clientDB->getEmail($email))) {
                                        $user->register($name, $email, $password, $description);
                                    } else {
                                        echo '<div class="alert alert-warning">Email already registered</div>';
                                    }
                                }
                            }
                        }
                        ?>
                        <h2 class="text-center mb-4">Login</h2>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <p class="text-center mt-3">Don't have an account?
                            <button onclick="toggleForms()" class="btn btn-link p-0">Register</button>
                        </p>
                        <?php if (isset($_SESSION['email'])): ?>
                            <p class="text-center mt-3">Currently logged in as:
                                <button onclick="window.location.href='../_functions/logout.php'" class="btn btn-link p-0">
                                    Logout from <?php echo $_SESSION['email']; ?>
                                </button>
                            </p>
                        <?php endif; ?>
                        
                    </div>
                    <?php
                    if (isset($_GET['logout'])) {
                            header('Location: logout.php');
                            exit();
                        }
                    ?>
                </div>
                <div id="registerForm" style="display: none;">
                    <h2 class="text-center mb-4">Register</h2>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="reg_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="reg_name" name="reg_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="reg_email" name="reg_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="reg_password" name="reg_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_description" class="form-label">Description</label>
                            <textarea class="form-control" id="reg_description" name="reg_description"
                                      required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <p class="text-center mt-3">Already have an account?
                        <button onclick="toggleForms()" class="btn btn-link p-0">Login</button>
                    </p>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function toggleForms() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        }
    }
</script>
</body>
</html>