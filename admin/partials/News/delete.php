<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    if(isset($GET['id']) && !empty($GET['id'])){
        $newsId = $GET['id'];
        $user->checkAuth(90, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=DashBoard');
    }else{
        header('Location: ./index.php?p=home&view=News/Posts');
        exit;
    }

    if($news_->deleteById($newsId)){
        header('Location: ./index.php?p=home&view=News/Posts');
    }else{
        echo 'Der skete en fejl ved sletning af nyhed. Prøv igen';
        header('Refresh: 5;url=./index.php?p=home&view=News/Posts');
    }
   