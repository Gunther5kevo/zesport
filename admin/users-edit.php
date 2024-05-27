<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit User
                    <a href="users.php" class="btn btn-primary float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <?= alertMessage(); ?>
                <form action="admin_functions.php" method="POST">
                    <?php
                        $id = checkParamId('id');
                        if (!is_numeric($id)) {
                            echo '<h5>Invalid User ID</h5>';
                            exit;
                        }

                        $user = getById($pdo, 'users', $id);

                        if ($user['status'] == 200) {
                    ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?= htmlspecialchars($user['data']['name']); ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Phone No</label>
                                    <input type="text" name="phone" value="<?= htmlspecialchars($user['data']['phone']); ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['data']['email']); ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" value="<?= htmlspecialchars($user['data']['password']); ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Select Role</label>
                                    <select name="role" required class="form-select">
                                        <option value="">Select Role</option>
                                        <option value="admin" <?= $user['data']['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        <option value="user" <?= $user['data']['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Is Ban</label><br>
                                    <input type="checkbox" name="is_ban" value="1" <?= $user['data']['is_ban'] == 1 ? 'checked' : ''; ?> style="width: 30px; height: 30px;"/>
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <div class="mb-3">
                                    <input type="hidden" name="user_id" value="<?= $id; ?>">
                                    <button type="submit" name="updateUser" class="btn btn-primary">Update User</button>
                                </div>
                            </div>
                        </div>
                    <?php
                        } else {
                            echo '<h5>' . htmlspecialchars($user['message']) . '</h5>';
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
