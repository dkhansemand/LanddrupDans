<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['teamid']) && !empty($GET['teamid'])){
        $teamId = $GET['teamid'];
        $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Teams/List');
    }else{
        header('Location: ./index.php?p=home&view=Teams/List');
        exit;
    }
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            if(isset($POST['newSubscribers'])){
                foreach ($POST['newSubscribers'] as $new) {
                    $newMember = $user->getProfileById($new);
                    if($teams->registerUserOnTeam($new, $teamId)){
                        $success .= $newMember->firstname . ' ' . $newMember->lastname . ' er nu blevet tilføjet til holdet. <br>';
                    }else{
                        $error .= $newMember->firstname . ' ' . $newMember->lastname . ' kunne ikke tilføjes.';
                    }
                }
            }
        }
    }
    $team = $teams->getTeamById($teamId);
    $nonSubscribers = $teams->getNonSubscribers($teamId);
?>
<div class="row">
    <div class="col s12">
        <h4>Tilmeld bruger til hold <?=$team->teamName?></h4>
    </div>
    <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
        <?=@$success?>
    </div>
    <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
        <h4>Fejl</h4>
        <?=@$error['msg']?>
    </div>
    <form action="" method="post" class="col s12">
        <div class="col s12">
            <?=$token->createTokenInput()?>
        </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="newsTitle" name="team" type="text" class="validate" disabled value="<?=$team->teamName?>">
          <label for="newsTitle">Hold</label>
        </div>
      </div>
      <div class="row">
        <div class="col s6">
            <div class="input-field col s12">
                <select multiple name="newSubscribers[]">
                <option value="0" disabled>Vælg bruger(e)</option>
                <?php
                    foreach($nonSubscribers as $nonSub){
                ?>
                    <option value="<?=$nonSub->userId?>"><?=$nonSub->firstname . ' ' . $nonSub->lastname?></option>
                <?php
                    }
                ?>
                </select>
                <label>Vælg medlemmer</label>
            </div>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-md">Tilføj bruger(e)<i class="material-icons right">send</i></button>
    </div>
    </form>
</div>