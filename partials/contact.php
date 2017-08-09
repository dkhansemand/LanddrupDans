<?php
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            
            $firstname = $validator->characters($POST['firstname']) ? $POST['firstname']                  : $error['firstname']      = 'Fornavn skal udfyldes, og må ikke indholde tal.';
            $lastname  = $validator->characters($POST['lastname']) ? $POST['lastname']                    : $error['lastname']       = 'Efternavn skal udfyldes, og må ikke indholde tal.';
            $email     = $validator->email($POST['email']) ? $POST['email']                               : $error['email']          = 'E-mail skal udfyldes, og være i korrekt format.';
            $message   = $validator->mixedBetween($POST['message'], 10) ? $POST['message']                : $error['message']        = 'Beskeden skal min. være på 10 tegn og max 255';

            if(sizeof($error) === 0){
                $msgData = [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'message' => $message
                ];

                if($message_->send($msgData)){
                    $success = 'Beskeden er nu blevet sendt. Vores svartider er 1-5 arbejdsdage.';
                    unset($firstname, $lastname, $email, $message);
                }else{
                    $error['msg'] = 'Det var ikke muligt at sende en besked fra systemet. Prøv igen senere.';
                }
            }
        }
    }

?>
<div class="row container">
    <div class="col s12">
        <h2>Kontakt os</h2>
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
          <input id="first_name" name="firstname" type="text" class="validate" value="<?=@$POST['firstname']?>">
          <label for="first_name">Fornavn</label>
          <?= isset($error['firstname']) ? '<p class="red-text text-ligthen-2">' . $error['firstname'] . '</p>' : ''?>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="last_name" name="lastname" type="text" class="validate" value="<?=@$POST['lastname']?>">
          <label for="last_name">Efternavn</label>
          <?= isset($error['lastname']) ? '<p class="red-text text-ligthen-2">' . $error['lastname'] . '</p>' : ''?>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="email" name="email" type="email" class="validate" value="<?=@$POST['email']?>">
          <label for="email">Email</label>
          <?= isset($error['email']) ? '<p class="red-text text-ligthen-2">' . $error['email'] . '</p>' : ''?>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <textarea id="textarea1" name="message" class="materialize-textarea"><?=@$POST['message']?></textarea>
          <label for="textarea1">Besked</label>
          <?= isset($error['message']) ? '<p class="red-text text-ligthen-2">' . $error['message'] . '</p>' : ''?>
        </div>
      </div>
      <div class="row">
        <div class="col s6 pull-right">
            <button type="submit" class="btn btn-md right">Send<i class="material-icons right">send</i></button>
        </div>
      </div>
    </form>
  </div>