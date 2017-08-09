<?php
    $pageContent = $page->getPageContent('home');

    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            print_r($POST);
            $pageData = array(
                ':pageId' => $pageContent->pageId,
                ':pageText' => $POST['pageText'],
                ':PICTURE' => 'test.jpg'
            );
            //$page->updatePageContent($pageContent->pageId, $pageData);
            var_dump($page->updatePageContent($pageData));
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
        <form action="" method="post" class="col s12 m12">
            <div class="row">
                <div class="col s12">
                    <?=$token->createTokenInput()?>
                </div>
                
                <div class="col s12">  
                    <label for="pageTItle">Side titel</label>
                    <input type="text" name="pageTitle" id="pageTItle" min="2" max="20" class="validate" value="<?=$pageContent->pageTitle?>" >
                </div>
                <div class="input-field col s12">  
                    <label for="pageText">Side teskst</label>
                    <textarea id="pageText" name="pageText" class="materialize-textarea"><?=$pageContent->pageText?></textarea>
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

