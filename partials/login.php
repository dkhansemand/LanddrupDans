<?php
    $user->checkSession() ? header('Location: ./index.php?p=home') : null;
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
        if(isset($POST['btnLogin'])){
            $email    = $validator->email($POST['email']) ? $POST['email']                : $error['email']          = 'E-mail skal udfyldes, og være i korrekt format.';
            $password = $validator->mixedBetween($POST['password'], 4) ? $POST['password']: $error['passwordLength'] = 'Password skal udfyldes.';

            if(sizeof($error) > 0){
                $errMsg = '';
                foreach($error as $msg){
                    $errMsg .= '<li>- ' . $msg . '</li>';
                }
            }else{
                if($user->verifyLogin($email, $password)){
                    header('Location: ./index.php?p=home');
                    exit;
                }else{
                    $error = 'Login fejl';
                    $errMsg = 'Brugernavn eller password er forkert';
                }
            }
        }
    }
?>

<div class="row container">
    <h4>Login</h4>
    <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
        <h4>Fejl i login</h4>
            <ul>    
                <?=@$errMsg?>
            </ul>
            
        </div>
    <form action="./index.php?p=login" method="post" class="col s12 m6">
    <?=$token->createTokenInput()?>
    <div class="row">
        <div class="input-field col s10">
        <i class="material-icons prefix">email</i>
        <input type="email" name="email" id="icon_prefixEmail" class="validate" required>
        <label for="icon_prefixEmail">E-mail</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s10">
        <i class="material-icons prefix">vpn_key</i>
        <input type="password" name="password" id="icon_prefixPassword" class="validate" required>
        <label for="icon_prefixPassword">Password</label>
        </div>
    </div>
    <div class="row">
        <div class="col s10">
            <button class="btn waves-effect waves-light right" type="submit" name="btnLogin">Login
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
    </form>
</div>