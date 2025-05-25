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
                <div class="card-body">
                    <div id="loginForm">
                        <h2 class="text-center mb-4">Login</h2>
                        <form method="POST" action="">
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
                    </div>
                    <div id="registerForm" style="display: none;">
                        <h2 class="text-center mb-4">Register</h2>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="reg_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="reg_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="reg_email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="reg_password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
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
