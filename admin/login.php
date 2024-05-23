<?php include('includes/header.php');?>

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
                            <button type="submit" class="btn bt-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>



<?php include('includes/footer.php'); ?>