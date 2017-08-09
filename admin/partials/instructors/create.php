<?php
    $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home');
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $error = [];

            $userId = $POST['instructor'] !== 0 ? $POST['instructor'] : $error['instructor'] = 'Instuktør skal vælges';
            $description = $validator->mixedBetween($POST['description'], 2) ? $POST['description'] : $error['description'] = 'Beskrivelse skal min. være på 2 tegn og max 255';

            if(sizeof($error) === 0){
                $picture = $upload->uploadImage('fileupload');
                if(!$picture['error']){
                    $queryInsertInstructor = $db->prepQuery("INSERT INTO media (filePath, mediaType)VALUES(:file, :mediaType);
                                    SELECT LAST_INSERT_ID() INTO @lastId;
                                    INSERT INTO instructors (insDescription, fkUser, fkPicture)VALUES(:insDescription, :fkUser, @lastId);
                                    ");
                    $data = array(
                        ':file' => $picture['name'],
                        ':mediaType' => $picture['type'],
                        ':insDescription' => $POST['description'],
                        ':fkUser' => $userId
                    );
                    if($queryInsertInstructor->execute($data)){
                        $success = 'Instruktøreren er blevet oprettet.';
                    }
                }else{
                    $error['fileupload'] = $picture['msg'];
                }
            }
        }

    }
        $instructors = $user->getNonInstructors();
        

    
?>

<div class="row ">
    <div class="col s6">
        <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
        <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>"><?=@$error['session']?></div>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Opret instruktør</h3>
            <?=$token->createTokenInput()?><br>
            <div class="input-field col s12"> 
                <select id="instructor" name="instructor">
                    <option value="0">Vælg bruger</option>
                    <?php
                        foreach($instructors as $instructor){
                        ?>
                            <option value="<?=$instructor->userId?>"><?=$instructor->firstname . ' ' . $instructor->lastname?></option>
                        <?php
                        }
                    ?>
                </select>
                <label for="instructor">Instruktør</label>
            </div>
            
            <div class="input-field col s12"> 
                <label for="description">Beskrivelse</label>
                <textarea id="description" class="materialize-textarea" name="description"></textarea>
                <?= isset($error['description']) ? '<p class="red-text text-ligthen-2">' . $error['description'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12"> 
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name="fileupload">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <?= isset($error['fileupload']) ? '<p class="red-text text-ligthen-2">' . $error['fileupload'] . '</p>' : ''?>
            </div>
            <div class="input-field col s12"> 
                <button type="submit" class="btn" name="createInstructor">Opret<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>