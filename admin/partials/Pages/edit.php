<?php
   
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['url']) && !empty($GET['url'])){
        $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');
        $pageContent = $page->getPageContent($GET['url']);
    }else{
        header('Location: ./index.php?p=home&view=Dashboard');
        exit;
    }

    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $pageTitle = $validator->mixedBetween($POST['pageTitle'], 2, 30) ? $POST['pageTitle'] : $error['pageTitle'] = 'sidetitel skal min. være på 2 tegn og max 20 tegn';
            $pageText = $validator->mixedBetween($POST['pageText'], 20, 1000) ? $POST['pageText'] : $error['pageText'] = 'Sidetekst skal min. være på 20 tegn';
           
            if(sizeof($error) === 0){
                $pageData = array(
                    ':ID' => (int)$pageContent->pageId,
                    ':TITLE' => filter_var($pageTitle, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH),
                    ':PTEXT' => filter_var($pageText, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)
                );
                if(!empty($_FILES['fileupload']['name'])){
                    $picture = $upload->uploadImage('fileupload');
                    if(!$picture['error']){
                        $pageData[':PICTURE'] = $picture['name'];
                        $pageData[':MTYPE'] = $picture['type'];
                    }else{
                        $error['fileupload'] = $picture['msg'];
                    }
                }
                if((sizeof($error) === 0) && $page->updatePageContent($pageData)){
                    $success = 'Forside indholdet er nu blevet opdateret!';
                }
            }

        }
    }
?>
<div class="row">
    <div class="col s12 m10">
       <h3>Forside indhold</h3>    
        <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
        <div class="card-panel yellow lighten-2 <?=empty($error['session']) ? 'hide' : ''?>">
            <h4>Fejl</h4>
            <?=@$error['session']?>
        </div>
        <form action="" method="post" class="col s12 m12" enctype="multipart/form-data">
            <div class="row">
                <div class="col s12">
                    <?=$token->createTokenInput()?>
                </div>
                
                <div class="col s12">  
                    <label for="pageTItle">Side titel</label>
                    <input type="text" name="pageTitle" id="pageTItle" min="2" max="30" class="validate" value="<?=$pageContent->pageTitle?>" >
                     <?= isset($error['pageTitle']) ? '<p class="red-text text-ligthen-2">' . $error['pageTitle'] . '</p>' : ''?>
                </div>
                <div class="input-field col s12">  
                    <label for="pageText">Side teskst</label>
                    <textarea id="pageText" name="pageText" class="materialize-textarea"><?=$pageContent->pageText?></textarea>
                     <?= isset($error['pageText']) ? '<p class="red-text text-ligthen-2">' . $error['pageText'] . '</p>' : ''?>
                </div>
                <div class="input-field col s12"> 
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Billede</span>
                        <input type="file" name="fileupload">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" value="Skift forside billedet her">
                    </div>
                </div>
                <?= isset($error['fileupload']) ? '<p class="red-text text-ligthen-2">' . $error['fileupload'] . '</p>' : ''?>
            </div>
                <div class="input-field col s12">  
                    <button type="submit" name="updatePage" class="btn btn-md right">Opdatér<i class="material-icons right">send</i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>

