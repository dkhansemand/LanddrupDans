<?php

    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $levelId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=Levels/List');
        exit;
    }

    if($content->deleteLevelById($levelId)){
        header('Location: ./index.php?p=home&view=Levels/List');
    }else{
        echo 'Der skete en fejl ved sletning af niveau. Prøv igen';
        header('Refresh: 5;url=./index.php?p=home&view=Levels/List');
    }
   