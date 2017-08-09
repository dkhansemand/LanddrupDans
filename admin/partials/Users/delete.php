<?php


    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $profileId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=Users/List');
        exit;
    }

    if($_SESSION['userId'] !== $profileId){
        if($user->deleteUserById($profileId)){
            header('Location: ./index.php?p=home&view=Users/List');
        }else{
            echo 'Der skete en fejl ved sletning af bruger. Prøv igen';
            header('Refresh: 5;url=./index.php?p=home&view=Users/List');
        }
    }else{
        echo 'Du kan ikke slette din egen bruger her fra. Gå ind på din profil side for at gøre dette.';
        header('Refresh: 6;url=./index.php?p=home&view=Users/List');
    }