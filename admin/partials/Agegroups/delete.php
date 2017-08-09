<?php

    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $ageId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=AgeGroups/List');
        exit;
    }

    if($content->deleteAgeGroupById($ageId)){
        header('Location: ./index.php?p=home&view=Agegroups/List');
    }else{
        echo 'Der skete en fejl ved sletning af aldersgruppe. Prøv igen';
        header('Refresh: 5;url=./index.php?p=home&view=AgeGroups/List');
    }
   