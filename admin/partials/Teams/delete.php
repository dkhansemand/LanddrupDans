<?php

    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $teamId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=Teams/List');
        exit;
    }

    if($teams->deleteTeam($teamId)){
        header('Location: ./index.php?p=home&view=Teams/List');
    }else{
        echo 'Der skete en fejl ved sletning af hold. Prøv igen';
        header('Refresh: 5;url=./index.php?p=home&view=Teams/List');
    }
   