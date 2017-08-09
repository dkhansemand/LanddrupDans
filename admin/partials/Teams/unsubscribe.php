<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['teamid']) && !empty($GET['teamid'])
        && isset($GET['userid']) && !empty($GET['userid'])){
        $teamId = $GET['teamid'];
        $userId = $GET['userid'];

        $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Teams/List');
    }else{
        header('Location: ./index.php?p=home&view=Teams/List');
        exit;
    }

?>

<div class="row container">
    <div class="col s12 m10">
    <?php
    if($teams->unregisterUser($userId, $teamId)){
        $teamInfo = $teams->getTeamById($teamId);
        $userInfo = $user->getProfileById($userId);
        ?>
        <div class="card-panel blue lighten-2">
            <h4>Afmelding fuldført</h4>
            <p>
                <strong><?=$userInfo->firstname . ' ' . $userInfo->lastname?></strong> er nu afmeldt fra hold <?=$teamInfo->teamName?> (<?=$teamInfo->stylesName . ' ' . $teamInfo->ageGrpName?>)
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