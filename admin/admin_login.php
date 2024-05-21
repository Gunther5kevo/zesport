<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body style="background-image: url('../presentationlayer/assets/img/avatar/dashboard.jpg'); background-size: cover;">

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Zesport</h2>
            <form class="mt-4" method="post" action="admin_authenticate.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
