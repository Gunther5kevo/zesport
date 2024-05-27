<?php 
    include('functions.php');
    $pageTitle = 'Login';

    if(isset($_SESSION['auth'])){
        redirect('../presentationlayer/index.php', 'You are already logged in');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Zesport Login</title>
</head>
<body>
<div class="py-4 bg-secondary text-center">
    <h4 class="text-white">Login </h4>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
            </div>
            
                <div class="card-body">
                    <?= alertMessage();?>
                    <form action="login-code.php" method="POST">
                        <div class="mb-3">
                            <label >Email Address</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label >Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn bt-primary w-100" name="login" >Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>


</body>
</html>


<?php include('includes/footer.php'); ?>