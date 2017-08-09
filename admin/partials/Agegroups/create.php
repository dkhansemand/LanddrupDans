<?php
$user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home');
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $ageName = $validator->stringBetween($POST['ageName'], 2, 15) ? $POST['ageName'] : $error['ageName'] = 'Aldersgruppe navn må kun indholde bogstaver';

            if(sizeof($error) === 0){
                $queryInsertAge = $db->prepQuery("INSERT INTO ageGroups (ageGrpName)VALUES(:NAME)");
                $ageData = array(
                    ':NAME' => $ageName
                );
                if($queryInsertAge->execute($ageData)){
                    $success = 'Aldersgruppe er blevet oprettet.';
                }
            }
        }
    }

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
            <h3>Aldersgruppe opret</h3>
            <?=$token->createTokenInput()?><br>
            <div class="input-field col s12">
                <label for="levelName">Aldersgruppe navn</label>
                <input type="text" name="ageName" id="levelName">
                <?= isset($error['ageName']) ? '<p class="red-text text-ligthen-2">' . $error['ageName'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn" name="createAgegroup">Opret<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>