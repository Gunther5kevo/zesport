<?php
include('includes/header.php');

// Fetch competitions from the database (if tournaments are associated with competitions)
$sql_competitions = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
$stmt_competitions = $pdo->query($sql_competitions);
$competitions = $stmt_competitions->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?= alertMessage();?>
            <h4>Create New Tournament</h4>
            <form method="post" action="admin_functions.php">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tournament_name">Tournament Name:</label>
                        <input type="text" id="tournament_name" name="tournament_name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="competition">Competition:</label>
                        <select id="competition" name="competition" class="form-control">
                            <option value="" selected>No competition</option>
                            <?php foreach ($competitions as $competition): ?>
                                <option value="<?= htmlspecialchars($competition['id']) ?>"><?= htmlspecialchars($competition['competition_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="create_tournament">Create Tournament</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
