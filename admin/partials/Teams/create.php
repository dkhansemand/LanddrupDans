<?php

    $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Levels/List');
    
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        //print_r($POST);
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $teamName = $validator->stringBetween($POST['teamName'], 2, 120) ? $POST['teamName'] : $error['teamName'] = 'Hold navn mp kun være bogstaver og tal. Min. længde 2 og maks. 12 tegn.';
            $style = (int)$POST['style'] !== 0 ? $POST['style'] : $error['style'] = 'Der skal vælges en stilart';
            $ageGroup = (int)$POST['ageGroup'] !== 0 ? $POST['ageGroup'] : $error['ageGroup'] = 'Der skal vælges en aldersgruppe';
            $level = (int)$POST['level'] !== 0 ? $POST['level'] : $error['level'] = 'Der skal vælges et niveau';
            $instructor = (int)$POST['instructor'] !== 0 ? $POST['instructor'] : $error['instructor'] = 'Der skal vælges en instruktør';
            $price = $validator->currency($POST['teamPrice']) ? $POST['teamPrice'] : $error['teamPrice'] = 'Prisen er ikke i korrekt format';
            if(sizeof($error) === 0){
                if($teams->doExists($teamName)){
                    $error['teamName'] = 'Det pågældende hold "' . $teamName . '" eksistere allerede';
                }else{
                    $teamData = array(
                        ':NAME' => $teamName,
                        ':STYLE' => $style,
                        ':AGE' => $ageGroup,
                        ':LEVEL' => $level,
                        ':INSTRUCTOR' => $instructor,
                        ':PRICE' => $price
                    );
                    if($teams->createTeam($teamData)){
                        $success = 'Holdet er nu oprettet!';
                    }
                }
                
            }
        }
    }

    $styles = $content->getStyles();
    $ageGroups = $content->getAgeGroups();
    $levels = $content->getLevels();
    $instructors = $user->getInstructors();

?>
<div class="row ">
    <div class="col s6">
        <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
        <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
            <h3>Fejl</h3>
            <?=@$error['session']?>
        </div>
        <form action="" method="post">
            <h3>Opret hold</h3>
            <?=$token->createTokenInput()?><br>
            <div class="input-field col s12">
                <label for="teamName">Hold navn</label>
                <input type="text" name="teamName" id="teamName" value="<?=@$POST['teamName']?>">
                <?= isset($error['teamName']) ? '<p class="red-text text-ligthen-2">' . $error['teamName'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12"> 
                <select id="style" name="style">
                    <option value="0">Vælg stilart</option>
                    <?php
                        foreach($styles as $style){
                        ?>
                            <option value="<?=$style->stylesId?>" <?=@$POST['style'] === $style->stylesId ? 'selected' : ''?>><?=$style->stylesName?></option>
                        <?php
                        }
                    ?>
                </select>
                <label for="style">Stilart</label>
                <?= isset($error['style']) ? '<p class="red-text text-ligthen-2">' . $error['style'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12"> 
                <select id="ageGruop" name="ageGroup">
                    <option value="0">Vælg aldersgruppe</option>
                    <?php
                        foreach($ageGroups as $ageGroup){
                        ?>
                            <option value="<?=$ageGroup->ageGrpId?>" <?=@$POST['ageGroup'] === $ageGroup->ageGrpId ? 'selected' : ''?>><?=$ageGroup->ageGrpName?></option>
                        <?php
                        }
                    ?>
                </select>
                <label for="ageGroup">Aldersgruppe</label>
                <?= isset($error['ageGroup']) ? '<p class="red-text text-ligthen-2">' . $error['ageGroup'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12"> 
                <select id="level" name="level">
                    <option value="0">Vælg Niveau</option>
                    <?php
                        foreach($levels as $level){
                        ?>
                            <option value="<?=$level->levelId?>" <?=@$POST['level'] === $level->levelId ? 'selected' : ''?>><?=$level->levelName?></option>
                        <?php
                        }
                    ?>
                </select>
                <label for="level">Niveau</label>
                <?= isset($error['level']) ? '<p class="red-text text-ligthen-2">' . $error['level'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12"> 
                <select id="instructor" name="instructor">
                    <option value="0">Vælg instructør</option>
                    <?php
                        foreach($instructors as $instructor){
                        ?>
                            <option value="<?=$instructor->insId?>" <?=@$POST['instructor'] === $instructor->insId ? 'selected' : ''?>><?=$instructor->firstname . ' ' . $instructor->lastname?></option>
                        <?php
                        }
                    ?>
                </select>
                <label for="instructor">Instruktør</label>
                <?= isset($error['instructor']) ? '<p class="red-text text-ligthen-2">' . $error['instructor'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <label for="teamPrice">Pris</label>
                <span class="prefix">Kr.</span>
                <input type="number" min="1" step="any" name="teamPrice" id="teamPrice" value="<?=@$POST['teamPrice']?>">
                <?= isset($error['teamPrice']) ? '<p class="red-text text-ligthen-2">' . $error['teamPrice'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn" name="createTeam">Opret<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>