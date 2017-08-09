<?php
    $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home');
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $styleName = $validator->stringBetween($POST['stylesName'], 2, 25) ? $POST['stylesName'] : $error['stylesName'] = 'Stilartens navn skal skrives!';
            $description = $validator->mixedBetween($POST['stylesDescription'], 2) ? $POST['stylesDescription'] : $error['stylesDescription'] = 'Beskrivelse skal min. være på 2 tegn og max 255';
            if(sizeof($error) === 0){
                $picture = $upload->uploadImage('stylesPicture');
                if(!$picture['error']){
                    $queryInsertStyles = $db->prepQuery("INSERT INTO media (filePath, mediaType)VALUES(:fileName, :mediaType);
                                        SELECT LAST_INSERT_ID() INTO @lastId;
                                        INSERT INTO styles (stylesName, stylesDescription, stylesPicture) VALUES (:styleName, :descrip, @lastId);");
                    $data = array(
                        ':styleName' => $styleName,
                        ':descrip' => $description,
                        ':fileName' => $picture['name'],
                        ':mediaType' => $picture['type']
                        );
                    if($queryInsertStyles->execute($data)){
                        $success = 'Stilarten er blevet oprettet.';
                    }
                }else{
                    $error['stylesPicture'] = $picture['msg'];
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
        <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>"><?=@$error?></div>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Opret Stilart</h3>
            <?=$token->createTokenInput()?><br>
            <div class="input-field col s12">
                <label for="stylesName">Stilartens navn</label>
                <input type="text" name="stylesName">
                <?= isset($error['stylesName']) ? '<p class="red-text text-ligthen-2">' . $error['stylesName'] . '</p>' : ''?>
            </div>

            <div class="input-field col s12">
                <label for="stylesDescription">Beskrivelse</label>
                <textarea id="stylesDescription" class="materialize-textarea" name="stylesDescription"></textarea>
                <?= isset($error['stylesDescription']) ? '<p class="red-text text-ligthen-2">' . $error['stylesDescription'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name="stylesPicture">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <?= isset($error['stylesPicture']) ? '<p class="red-text text-ligthen-2">' . $error['stylesPicture'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn" name="createStyle">Opret<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>