<?php
    if($filter->checkMethod('POST')){
        $POST = $filter->sanitizeArray(INPUT_POST);

        $error = [];
        if(!$token->validateToken($POST['_once'], 300)){
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }else{

            if(isset($POST['createUser'])){
                $firstname = $validator->characters($POST['firstname']) ? $POST['firstname']                  : $error['firstname']      = 'Fornavn skal udfyldes, og må ikke indholde tal.';
                $lastname  = $validator->characters($POST['lastname']) ? $POST['lastname']                    : $error['lastname']       = 'Efternavn skal udfyldes, og må ikke indholde tal.';
                $birthdate = $validator->birthdate($POST['birthdate_submit']) ? $POST['birthdate_submit']     : $error['birthdate']      = 'Fødselsdato skal udfyldes, og være i format dd-mm-yyyy eller dd/mm/yyyy.';
                $street    = $validator->stringBetween($POST['street']) ? $POST['street']                     : $error['street']         = 'Adresse skal udfyldes, og må ikke indholde specialtegn.';
                $zipcode   = $validator->intBetween($POST['zipcode']) ? $POST['zipcode']                      : $error['zipcode']        = 'Postnr skal udfyldes, og må kun indholde tal.';
                $city      = $validator->characters($POST['city'], 2, 25) ? $POST['city']                     : $error['city']           = 'By skal udfyldes, og må ikke indholde tal.';
                $phone     = $validator->phone($POST['phone']) ? $validator->phoneFormatted                   : $error['phone']          = 'Tlf. skal udfyldes, og må kun indholde tal og landekode.';
                $email     = $validator->email($POST['email']) ? $POST['email']                               : $error['email']          = 'E-mail skal udfyldes, og være i korrekt format.';
                $password  = $validator->match($POST['password'], $POST['passwordRepeat']) ? $POST['password']: $error['password']       = 'Begge passwords skal udfyldes og være ens.'; 
                $password  = $validator->mixedBetween($POST['password'], 4) ? $POST['password']               : $error['passwordLength'] = 'Password skal min være på 4 tegn.';
                
                if(sizeof($error) === 0){
                    if($user->userExists($email)){
                        $error['userExists'] = 'Bruger er allerede oprettet';
                        
                    }else{
                        //print_r($POST);

                        $options  = array('cost' => 12);
                        $password = password_hash($password, PASSWORD_BCRYPT, $options);

                        if(!$user->userCreate('INSERT INTO userProfile (firstname, lastname, birthdate, street, zipcode, city, phone)
                                            VALUES(:firstname, :lastname, :birthdate, :street, :zipcode, :city, :phone);
                                            SELECT LAST_INSERT_ID() INTO @lastId;
                                            INSERT INTO users (userEmail, userPassword, fkProfile, fkRole)VALUES(:email, :password, @lastId, :role);', 
                                            array(
                                                ':firstname' => $firstname,
                                                ':lastname' => $lastname,
                                                ':birthdate' => $birthdate,
                                                ':street' => $street,
                                                ':zipcode' => $zipcode,
                                                ':city' => $city,
                                                ':phone' => $phone,
                                                ':email' => $email,
                                                ':password' => $password,
                                                ':role' => 4
                                            ))
                                            ){
                                                $error['userCreate'] = 'Fejl ved oprettelse af bruger. Prøv igen';
                                            }else{
                                                $success = 'Dun bruger er nu oprettet!';
                                                header('Refresh:5;url=./index.php?p=login');
                                            }
                    }
                }
            }
        }
    }

?>
<div class="row container">
    <div class="col s12 m10">
     <div class="card-panel green lighten-2 <?=empty(@$success) ? 'hide' : ''?>">
            <?=@$success?>
        </div>
            <div class="card-panel yellow lighten-2 <?=empty($error) ? 'hide' : ''?>">
                <h4>Fejl</h4>
            <?=@$error['session']?>
            <?=@$error['userExists']?>
            </div>
            <form action="" method="post" class="col s12 m12">
                <h3>Tilmedling</h3>
                <div class="row">
                    <div class="col s12">
                        <?=$token->createTokenInput()?>
                    </div>
                    <div class="col s12 m6">
                    <h5>Dine oplysninger</h5>
                    <div class="input-field col s12">  
                        <label for="firstname" data-error="wrong" data-success="right">Fornavn</label>
                        <input type="text" name="firstname" id="firstname" min="2" max="25" class="validate" value="<?=@$POST['firstname']?>" >
                        <?= isset($error['firstname']) ? '<p class="red-text text-ligthen-2">' . $error['firstname'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="">Efternavn</label>
                        <input type="text" name="lastname" id="lastname" min="2" max="25" class="validate" value="<?=@$POST['lastname']?>">
                        <?= isset($error['lastname']) ? '<p class="red-text text-ligthen-2">' . $error['lastname'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="birthdate">Fødselsdato</label>
                        <input type="date" name="birthdate" id="birthdate" class="validate datepicker" value="<?=@$POST['birthdate_submit']?>">
                        <?= isset($error['birthdate']) ? '<p class="red-text text-ligthen-2">' . $error['birthdate'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="phone">Tlf nr.</label>
                        <input type="tel" name="phone" id="phone" min="8" class="validate" value="<?=@$POST['phone']?>">
                        <?= isset($error['phone']) ? '<p class="red-text text-ligthen-2">' . $error['phone'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12">  
                        <label for="street">Adresse</label>
                        <input type="text" name="street" id="street" class="validate" value="<?=@$POST['street']?>">
                        <?= isset($error['street']) ? '<p class="red-text text-ligthen-2">' . $error['street'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12 m6">  
                        <label for="zipcode">Postnr.</label>
                        <input type="number" name="zipcode" id="zipcode" class="validate" min="0" max="99999" value="<?=@$POST['zipcode']?>">
                        <?= isset($error['zipcode']) ? '<p class="red-text text-ligthen-2">' . $error['zipcode'] . '</p>' : ''?>
                    </div>
                    <div class="input-field col s12 m6">  
                        <label for="city">By</label>
                        <input type="text" name="city" id="city" class="validate" placeholder="By" value="<?=@$POST['city']?>">
                        <?= isset($error['city']) ? '<p class="red-text text-ligthen-2">' . $error['city'] . '</p>' : ''?>
                    </div>
                   
                    </div>
                    <div class="col s12 m6">
                        <h5>Login oplysninger</h5>
                        <div class="input-field col s12">  
                            <label for="email" data-error="wrong" data-success="right">E-mail</label>
                            <input type="email" name="email" id="email" class="validate" value="<?=@$POST['email']?>">
                            <?= isset($error['email']) ? '<p class="red-text text-ligthen-2">' . $error['email'] . '</p>' : ''?>
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
                        <button type="submit" name="createUser" class="btn btn-md right">Opret<i class="material-icons right">send</i></button>
                    </div>
                    </div>
                </div>
            </form>
    </div>
</div>