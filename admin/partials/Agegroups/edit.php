<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $ageId = $GET['id'];
        $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Levels/List');
    }else{
        header('Location: ./index.php?p=home&view=Agegroups/List');
        exit;
    }

    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $ageName = $validator->stringBetween($POST['ageName'], 2, 15) ? $POST['ageName'] : $error['ageName'] = 'Aldersgruppe navn må kun indholde bogstaver';

            if(sizeof($error) === 0){
                $ageData = array(
                    ':ID' => $ageId,
                    ':NAME' => $ageName
                );
                if($content->updateAgeGroup($ageData)){
                    $success = 'Aldersgruppen er blevet ændret.';
                }
            }
        }
    }
    $ageGroup = $content->getAgeGroupById($ageId);
?>
<div class="row ">
    <div class="col s6">
        <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
        <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
            <?=@$error?>
        </div>
        <form action="" method="post">
            <h3>Aldersgruppe redigér</h3>
            <?=$token->createTokenInput()?><br>
            <div class="input-field col s12">
                <label for="levelName">Aldersgruppe navn</label>
                <input type="text" name="ageName" id="levelName" value="<?=@$ageGroup->ageGrpName?>">
                <?= isset($error['ageName']) ? '<p class="red-text text-ligthen-2">' . $error['ageName'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn" name="createAgegroup">Ret<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>