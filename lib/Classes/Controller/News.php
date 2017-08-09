<?php

namespace Controller;
use Database\DB;
use \PDO;

class News extends DB{

    public function __construct(){
        parent::__construct(__DB_HOST__, __DB_USERNAME__, __DB_PASSWORD__, __DB_NAME__);
    }

    public function post($newsData){
        if(!empty($newsData) && gettype($newsData) === 'array'){
            $queryNewsPost = $this->prepQuery("INSERT INTO news (newsTitle, newsContent, newsAuthor, newsPublish)VALUES(:TITLE, :CONTENT, :AUTHOR, :PUBLISH)");
            $queryNewsPost->bindParam(':TITLE', $newsData['title'], PDO::PARAM_STR);
            $queryNewsPost->bindParam(':CONTENT', $newsData['content'], PDO::PARAM_STR);
            $queryNewsPost->bindParam(':AUTHOR', $newsData['author'], PDO::PARAM_INT);
            $queryNewsPost->bindParam(':PUBLISH', $newsData['publish'], PDO::PARAM_BOOL);
            
            return $queryNewsPost->execute() ? true : false;
        }
        return false;
    }

    public function getPublished(){
        $queryPublishedNews = $this->prepQuery("SELECT newsId, newsTitle, newsContent, DATE_FORMAT(newsDatePosted, '%d-%m-%Y %H:%i') AS postedDate,
                                                    userId, firstname, lastname FROM news
                                                    INNER JOIN users ON userId = newsAuthor
                                                    INNER JOIN userprofile ON profileId = fkProfile
                                                    WHERE newsPublish = '1'");
        if($queryPublishedNews->execute()){
            return $queryPublishedNews->fetchAll(PDO::FETCH_OBJ);
        }   
        return null;
    }

    public function getAll(){
        $queryAllNews = $this->prepQuery("SELECT newsId, newsTitle, newsContent, DATE_FORMAT(newsDatePosted, '%d-%m-%Y %H:%i') AS postedDate,
                                                    newsPublish, userId, firstname, lastname FROM news
                                                    INNER JOIN users ON userId = newsAuthor
                                                    INNER JOIN userprofile ON profileId = fkProfile
                                                    ORDER BY newsDatePosted ASC");
        if($queryAllNews->execute()){
            return $queryAllNews->fetchAll(PDO::FETCH_OBJ);
        }
        return null;
    }

    public function getById($newsId){
        if(!empty($newsId)){
            $queryPost = $this->prepQuery("SELECT newsId, newsTitle, newsContent, DATE_FORMAT(newsDatePosted, '%d-%m-%Y %H:%i') AS postedDate,
                                                    newsPublish, userId, firstname, lastname FROM news
                                                    INNER JOIN users ON userId = newsAuthor
                                                    INNER JOIN userprofile ON profileId = fkProfile
                                                    WHERE newsId = :ID");
            $queryPost->bindParam(':ID', $newsId, PDO::PARAM_INT);
            if($queryPost->execute()){
                return $queryPost->fetch(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function edit($newsData){
        if(!empty($newsData) && gettype($newsData) === 'array'){
            $queryUpdatePost = $this->prepQuery("UPDATE news SET newsTitle = :TITLE, newsContent = :CONTENT, newsPublish = :PUBLISH WHERE newsId = :ID");
            $queryUpdatePost->bindParam(':TITLE', $newsData['title'], PDO::PARAM_STR);
            $queryUpdatePost->bindParam(':CONTENT', $newsData['content'], PDO::PARAM_STR);
            $queryUpdatePost->bindParam(':PUBLISH', $newsData['publish'], PDO::PARAM_INT);
            $queryUpdatePost->bindParam(':ID', $newsData['id'], PDO::PARAM_INT);
            
            return $queryUpdatePost->execute() ? true : false;
        }   
        return false;
    }

    public function deleteById($newsId){
        if(!empty($newsId)){
            $queryDeletePost = $this->prepQuery("DELETE FROM news WHERE newsId = :ID");
            $queryDeletePost->bindParam(':ID', $newsId, PDO::PARAM_INT);
            return $queryDeletePost->execute() ? true : false;
        }
        return false;
    }
}