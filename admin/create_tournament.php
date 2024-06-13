<?php
include('includes/header.php');


// Define form actions for each sport
$formActionFootball = "create_football_competition.php"; 
$formActionBasketball = "create_basketball_competition.php"; 
$formActionRugby = "create_rugby_competition.php"; 
?>

<div class="container">
    <div class="row">
    <div class="col-md-12">
        <?= alertMessage(); ?>
    </div>
        <div class="col-md-6">
            <?php generateCompetitionForm('football', $formActionFootball); ?>
        </div>
        <div class="col-md-6">
            <?php generateCompetitionForm('basketball', $formActionBasketball); ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <?php generateCompetitionForm('rugby', $formActionRugby); ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
