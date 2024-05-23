<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h4>
                edit user
                <a href="users.php" class="btn btn-primary float-end"> Back</a>
            </h4>
            </div>
            <div class="card-body">
            <?= alertMessage();?>
                <form action="admin_functions.php" method="POST">

                <?php
                    $paramResult = checkParamId('id');
                    if (is_numeric($paramResult)) {
                        echo '<h5>' . $paramResult . '</h5>';
                        exit; 
                    }

                    $user= getById('users', checkParamId('id'));
                ?>

                    <div class="row">
                        <div class="col-md-6">
                                <div class="mb-3">
                                <label >Name</label>
                                <input type="text" name="name" required class="form-control">
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="mb-3">
                                <label >Phone No</label>
                                <input type="text" name="phone" required class="form-control">
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="mb-3">
                                <label >Email</label>
                                <input type="email" name="email" required class="form-control">
                                </div>
                                </div>
                        <div class="col-md-6">
                                <div class="mb-3">
                                <label >Password</label>
                                <input type="password" name="password" required class="form-control">
                                </div>
                                </div>
                       
                        <div class="col-md-3">
                                <div class="mb-3">
                                <label >Select Role</label>
                                <select name="role" required class="form-select">
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            
                            </div>
                        </div>
                        <div class="col-md-3">
                                <div class="mb-3">
                                <label >Is Ban</label>
                            </br>
                                <input type="checkbox" name="is_ban" style="width: 30px; height:30px"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="mb-3 text-end">
                            </br>
                                <button type="submit" name="updateUser" class="btn btn-primary">Update User</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>