<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $teamId = $GET['id'];
    }else{
        header('Location: ./index.php?p=Styles/Index');
        exit;
    }
    ?>
<div class="row container">
    <div class="col s12 m10">
    <?php
    if($teams->unregisterUser($_SESSION['userId'], $teamId)){
        $teamInfo = $teams->getTeamById($teamId);
        ?>
        <div class="card-panel blue lighten-2">
            <h4>Afmelding fuldført</h4>
            <p>
                Du er nu afmeldt fra hold <?=$teamInfo->teamName?> (<?=$teamInfo->stylesName . ' ' . $teamInfo->ageGrpName?>)
                <br>
                Niveau: <?=$teamInfo->levelName?>
                <br>
                Instruktør: <?=$teamInfo->firstname . ' ' . $teamInfo->lastname?>
            </p>
        </div>
        <?php
    }else{
        ?>
        <div class="card-panel yellow lighten-1">
            <h4>Fejl</h4>
            <p>Det var ikke muligt at afmelde fra pågældende hold.</p>
        </div>
        <?php
    }
    ?>
    </div>
</div>