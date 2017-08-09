<?php


    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $styleId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=Styles/List');
        exit;
    }

    if($content->deleteStyleById($styleId)){
        header('Location: ./index.php?p=home&view=Styles/List');
    }else{
        echo 'Der skete en fejl ved sletning af stilart. Prøv igen';
        header('Refresh: 5;url=./index.php?p=home&view=Styles/List');
    }
   