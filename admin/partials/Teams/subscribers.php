<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['teamid']) && !empty($GET['teamid'])){
        $teamId = $GET['teamid'];
        $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Teams/List');
    }else{
        header('Location: ./index.php?p=home&view=Teams/List');
        exit;
    }
    $team = $teams->getTeamById($teamId);
    $subscribers = $teams->getSubscribers($teamId);
?>

<div class="row">
    <div class="col s12">
        <h4>Tilmeldte til hold <?=$team->teamName?></h4>
        <a href="./index.php?p=home&view=Teams/AddSubscriber&teamid=<?=$team->teamId?>" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
    </div>
    <div class="col s12">
        <table class="bordered highlight striped responsive-table">
            <thead>
                <tr>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                    <th>E-mail</th>
                    <th>Tlf.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($subscribers as $subscriber){
                ?>
                <tr>
                    <td><?=$subscriber->firstname?></td>
                    <td><?=$subscriber->lastname?></td>
                    <td><?=$subscriber->userEmail?></td>
                    <td><?=$subscriber->phone?></td>
                    <td><a class="btn btn-md" href="./index.php?p=Teams/Unsubscribe&teamid=<?=$teamId?>&userid=<?=$subscriber->userId?>">Afmeld bruger</a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            </table>
    </div>
</div>