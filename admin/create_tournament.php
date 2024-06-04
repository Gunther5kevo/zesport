<?php
include('includes/header.php');

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?= alertMessage(); ?>
            <h4>Create New Tournament</h4>
            <form method="post" action="admin_functions.php">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="competition" class="form-label">Competition:</label>
                        <input type="text" id="competition" name="competition" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="create_tournament">Create Tournament</button>
            </form>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>
