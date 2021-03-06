<?php
    $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home');
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);
        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            $title         = $validator->mixedBetween($POST['title'], 2, 25) ? $POST['title']                 : $error['title']        = 'Overskriften skal min. være på 2 tegn og max 25';
            $postContent   = $validator->mixedBetween($POST['postContent'], 20, 500) ? $POST['postContent']   : $error['postContent']  = 'Indholdet skal min. være på 20 tegn og max 500';
            $publish       = isset($POST['publish']) ? 1 : 0;
            if(sizeof($error) === 0){
                $newsData = [
                    'title' => $title,
                    'content' => $postContent,
                    'author' => $_SESSION['userId'],
                    'publish' => $publish
                ];
                if($news_->post($newsData)){
                    $success = 'Nyheden ar nu tilføjet';
                }else{
                    $error['msg'] = 'Der skete en fejl';
                }
            }
                
        }
    }
?>

<div class="row">
    <div class="col s12">
        <h2>Tilføj nyhed</h2>
        <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
        <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
            <h4>Fejl</h4>
            <?=@$error['session']?>
            <?=@$error['msg']?>
        </div>
    </div>
    <form action="" method="post" class="col s12">
        <div class="col s12">
            <?=$token->createTokenInput()?>
        </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="newsTitle" name="title" type="text" class="validate" value="<?=@$POST['title']?>">
          <label for="newsTitle">Overskrift</label>
          <?= isset($error['title']) ? '<p class="red-text text-ligthen-2">' . $error['title'] . '</p>' : ''?>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s8">
          <textarea id="content" name="postContent" class="materialize-textarea"><?=@$POST['postContent']?></textarea>
          <label for="content">Indhold</label>
          <?= isset($error['postContent']) ? '<p class="red-text text-ligthen-2">' . $error['postContent'] . '</p>' : ''?>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input name="author" id="author" type="text" class="validate" value="<?=$_SESSION['userFullname']?>" disabled>
          <label for="author">Forfatter</label>
        </div>
      </div>
      <div class="row">
        <!-- Switch -->
        <div class="switch">
            <label>
                Kladde
            <input type="checkbox" name="publish" id="checkPublish" value="0" <?=$POST['publish'] == '1' ? 'checked' : ''?> >
            <span class="lever"></span>
                Udgiv
            </label>
        </div>
      </div>
      <div class="row">
        <div class="col s2">
            <button type="submit" class="btn btn-md right">Opret<i class="material-icons right">send</i></button>
        </div>
      </div>
    </form>
  </div>
<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
    document.getElementById('checkPublish').addEventListener('click', function(chk){
        if(document.getElementById('checkPublish').checked){
            document.getElementById('checkPublish').value = '1';
        }else{
            document.getElementById('checkPublish').value = '0';
        }
    });
        tinymce.init({ selector:'textarea' });
    
</script>