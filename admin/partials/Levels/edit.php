<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $levelId = $GET['id'];
        $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Levels/List');
    }else{
        header('Location: ./index.php?p=home&view=Levels/List');
        exit;
    }

    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $levelName = $validator->stringBetween($POST['levelName']) ? $POST['levelName'] : $error['levelName'] = 'Niveau navn må kun indholde bogstaver';

            if(sizeof($error) === 0){
                
                $levelData = array(
                    ':ID' => $levelId,
                    ':NAME' => $levelName
                );
                if($content->updateLevel($levelData)){
                    $success = 'Niveau er blevet ændret.';
                }
            }
        }
    }
    $level = $content->getLevelById($levelId);
?>
<div class="row ">
    <div class="col s6">
        <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
        <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
            <h3>Fejl</h3>
            <?=@$error['seesion']?>
        </div>
        <form action="" method="post">
            <h3>Redigér Niveau</h3>
            <?=$token->createTokenInput()?><br>
            <div class="input-field col s12">
                <label for="levelName">Niveau navn</label>
                <input type="text" name="levelName" id="levelName" value="<?=$level->levelName?>">
                <?= isset($error['levelName']) ? '<p class="red-text text-ligthen-2">' . $error['levelName'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn" name="createLevel">Ret<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>