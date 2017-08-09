<?php

$GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $profileId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=Instructors/List');
        exit;
    }

    if($user->deleteInstructorById($profileId)){
        header('Location: ./index.php?p=home&view=Instructors/List');
    }else{
        echo 'Der skete en fejl ved sletning af instruktør. Prøv igen';
        header('Refresh: 5;url=./index.php?p=home&view=Instructors/List');
    }
   