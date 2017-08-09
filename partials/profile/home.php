<?php
    $user->checkSession() ? null : header('Location: ./index.php?p=home');

    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{
            if(isset($POST['updateUser'])){
                $email     = $validator->email($POST['email']) ? $POST['email']                               : $error['email']          = 'E-mail skal udfyldes, og være i korrekt format.';
                $firstname = $validator->characters($POST['firstname']) ? $POST['firstname']                  : $error['firstname']      = 'Fornavn skal udfyldes, og må ikke indholde tal.';
                $lastname  = $validator->characters($POST['lastname']) ? $POST['lastname']                    : $error['lastname']       = 'Efternavn skal udfyldes, og må ikke indholde tal.';
                $birthdate = $validator->birthdate($POST['birthdate_submit']) ? $POST['birthdate_submit']     : $error['birthdate']      = 'Fødselsdato skal udfyldes, og være i format dd-mm-yyyy eller dd/mm/yyyy.';
                $street    = $validator->stringBetween($POST['street']) ? $POST['street']                     : $error['street']         = 'Adresse skal udfyldes, og må ikke indholde specialtegn.';
                $zipcode   = $validator->intBetween($POST['zipcode']) ? $POST['zipcode']                      : $error['zipcode']        = 'Postnr skal udfyldes, og må kun indholde tal.';
                $city      = $validator->characters($POST['city'], 2, 25) ? $POST['city']                     : $error['city']           = 'By skal udfyldes, og må ikke indholde tal.';
                $phone     = $validator->phone($POST['phone']) ? $validator->phoneFormatted                   : $error['phone']          = 'Tlf. skal udfyldes, og må kun indholde tal og landekode.';

                if($_SESSION['userEmail'] !== $email){
                    if($user->userExists($email)){
                        $error['email'] = 'Brugeren eksistere allerede';
                    }
                }
                if(sizeof($error) === 0){
                    $userData = array(
                                        ':email' => $email,
                                        ':firstname' => $firstname,
                                        ':lastname' => $lastname,
                                        ':birthdate' => $birthdate,
                                        ':street' => $street,
                                        ':zipcode' => $zipcode,
                                        ':city' => $city,
                                        ':phone' => $phone,
                                        ':ID' => $_SESSION['userId']
                                    );
                    if($user->updateUserProfile($userData)){
                        $success = 'Dine profil oplysninger er nu blevet opdateret';
                    }else{
                        $error['session'] = 'Der skete en fejl. Oplysninger kunne ikke opdateres.';
                    }
    
                }
            }elseif(isset($POST['updateUserLogin'])){
                $passwordOld = $validator->mixedBetween($POST['passwordOld'], 4) ? $POST['passwordOld']         : $error['passwordOld']    = 'Password skal min være på 4 tegn.';
                
                $password    = $validator->match($POST['password'], $POST['passwordRepeat']) ? $POST['password']: $error['password']       = 'Begge passwords skal udfyldes og være ens.'; 
                $password    = $validator->mixedBetween($POST['password'], 4) ? $POST['password']               : $error['passwordLength'] = 'Password skal min være på 4 tegn.';
                $password    = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                if(sizeof($error) === 0){
                    $passwordData = array(
                                    ':password' => $password,
                                    ':ID' => $_SESSION['userId']
                                    );
                    if($user->updateUserPassword($passwordOld, $passwordData)){
                        $success = 'Login oplysninger er nu blevet opdateret. Du vil nu blive logget ud.';
                        header('Refresh: 5;url=./index.php?p=logout');
                    }else{
                        $error['session'] = 'Der skete en fejl. Password kunne ikke opdateres.';
                    }
                }
            }
        }
    }
    
    if($user->getProfileById($_SESSION['userId']) === null){
        header('Location: ./index.php?p=home');
    }
    $userProfile = $user->getProfileById($_SESSION['userId']);
    $teamSubscribtions = $teams->getUserSubscribtions($_SESSION['userId']);
?>
<div class="container">
    <h2>Min konto <span class="grey-text text-ligthen-3 sub-heading"> <br>- <?=$_SESSION['userFullname']?> (<?=$_SESSION['userEmail']?>)</span></h2>
    <div class="row z-depth-1">
    <div class="col s12 no-padding">
      <ul class="tabs tabs-fixed-width white z-depth-1">
        <li class="tab col s6 z-depth-1"><a href="#myInfo" class="black-text">Oplysninger</a></li>
        <li class="tab col s6 z-depth-1"><a href="#myTeams" class="black-text">Tilmeldte hold</a></li>
        <li class="tab col s6 z-depth-1"><a href="#mySettings" class="black-text">Indstillinger</a></li>
      </ul>
    </div>
    <div id="myInfo" class="col s12">
        <h4>Oplysninger</h4>
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
                    <div class="col s12 m6">
                    <div class="input-field col s12">  
                        <label for="email" data-error="wrong" data-success="right">E-mail</label>
                        <input type="email" name="email" id="email" class="validate" value="<?=$userProfile->userEmail?>">
                        <?= isset($error['email']) ? '<p class="red-text text-ligthen-2">' . $error['email'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="firstname" data-error="wrong" data-success="right">Fornavn</label>
                        <input type="text" name="firstname" id="firstname" min="2" max="25" class="validate" value="<?=$userProfile->firstname?>" >
                        <?= isset($error['firstname']) ? '<p class="red-text text-ligthen-2">' . $error['firstname'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="">Efternavn</label>
                        <input type="text" name="lastname" id="lastname" min="2" max="25" class="validate" value="<?=$userProfile->lastname?>">
                        <?= isset($error['lastname']) ? '<p class="red-text text-ligthen-2">' . $error['lastname'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="birthdate">Fødselsdato</label>
                        <input type="date" name="birthdate" id="birthdate" class="validate datepicker" value="<?=$userProfile->birthdate?>">
                        <?= isset($error['birthdate']) ? '<p class="red-text text-ligthen-2">' . $error['birthdate'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="phone">Tlf nr.</label>
                        <input type="tel" name="phone" id="phone" min="8" class="validate" value="<?=$userProfile->phone?>">
                        <?= isset($error['phone']) ? '<p class="red-text text-ligthen-2">' . $error['phone'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="street">Adresse</label>
                        <input type="text" name="street" id="street" class="validate" value="<?=$userProfile->street?>">
                        <?= isset($error['street']) ? '<p class="red-text text-ligthen-2">' . $error['street'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12 m6">  
                        <label for="zipcode">Postnr.</label>
                        <input type="number" name="zipcode" id="zipcode" class="validate" min="0" max="99999" value="<?=$userProfile->zipcode?>">
                        <?= isset($error['zipcode']) ? '<p class="red-text text-ligthen-2">' . $error['zipcode'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12 m6">  
                        <label for="city">By</label>
                        <input type="text" name="city" id="city" class="validate" placeholder="By" value="<?=$userProfile->city?>">
                        <?= isset($error['city']) ? '<p class="red-text text-ligthen-2">' . $error['city'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <button type="submit" name="updateUser" class="btn btn-md right">Opdatér<i class="material-icons right">send</i></button>
                    </div>
                    </div>
                    <div class="col s12 m6">
                    <h5>Skift password</h5>
                        <div class="input-field col s12">  
                            <label for="passwordOld">Gamle password</label>
                            <input type="password" id="passwordOld" name="passwordOld" class="validate" >
                            <?= isset($error['passwordOld']) ? '<p class="red-text text-ligthen-2">' . $error['passwordOld'] . '</p>' : ''?>
                        </div>
                        <div class="input-field col s12">  
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="validate" >
                            <?= isset($error['password']) ? '<p class="red-text text-ligthen-2">' . $error['password'] . '</p>' : ''?>
                        </div>
                        <div class="input-field col s12">  
                            <label for="passwordRepeat">Gentag password</label>
                            <input type="password" name="passwordRepeat" id="passwordRepeat" class="validate" >
                            <?= isset($error['passwordLength']) ? '<p class="red-text text-ligthen-2">' . $error['passwordLength'] . '</p>' : ''?>
                        </div>
                        <div class="input-field col s12">  
                            <button type="submit" name="updateUserLogin" class="btn btn-md right">Gem<i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
    <div id="myTeams" class="col s12">
        <h4>Tilmeldte hold</h4>
        <table class="bordered highlight striped responsive-table">
            <thead>
            <tr>
                <th>Hold navn</th>
                <th>Stilart</th>
                <th>Aldersgruppe</th>
                <th>Niveau</th>
                <th>Instruktør</th>
                <th>Pris</th>
                <th>&nbsp;</th> 
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($teamSubscribtions as $sub){
                $team = $teams->getTeamById($sub->fkTeam)
                ?>
                <tr>
                    <td><?=$team->teamName?></td>
                    <td><?=$team->stylesName?></td>
                    <td><?=$team->ageGrpName?></td>
                    <td><?=$team->levelName?></td>
                    <td><?=$team->firstname . ' ' . $team->lastname?></td>
                    <td><?=$team->teamPrice?> kr.</td>
                    <td><a class="btn btn-md" href="./index.php?p=Teams/Cancel&id=<?=$team->teamId?>">Afmeld</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="mySettings" class="col s12">
        <h4>Indstillinger</h4>
    </div>
  </div>
</div>