<?php

namespace Controller;
use Database\DB;
use \PDO;

class Pages extends DB{
    /**
     * On class init connect to database
     * 
     */
    public function __construct(){
        parent::__construct(__DB_HOST__, __DB_USERNAME__, __DB_PASSWORD__, __DB_NAME__);
    }

    /**
     * Returns page content based on page URL (?p=) 
     *
     * @param string $pageUrl
     * @return mixed
     */
    public function getPageContent($pageUrl){
        if(isset($pageUrl) && !empty($pageUrl)){
            $queryPageContent = $this->prepQuery("SELECT pageId, pageText, pageTitle, mediaId, filePath
                                                    FROM pages
                                                    LEFT JOIN media ON pagePicture = mediaId
                                                    WHERE pageUrl = :URL");
            $queryPageContent->bindParam(":URL", $pageUrl, PDO::PARAM_STR);
            if($queryPageContent->execute()){
                return $queryPageContent->fetch(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function updatePageContent($pageData){
        if(isset($pageData) && !empty($pageData)){
            if(gettype($pageData) === 'array'){
                if(array_key_exists(':PICTURE', $pageData)){
                    $queryPageUpdate = $this->prepQuery("INSERT INTO media (filePath, mediaType)VALUES(:PICTURE, :MTYPE);
                                                         SELECT LAST_INSERT_ID() INTO @lastId;
                                                         UPDATE pages SET pageTitle = :TITLE, pageText = :PTEXT, pagePicture = @lastId WHERE pageId = :ID");
                }else{
                    $queryPageUpdate = $this->prepQuery("UPDATE pages SET pageTitle = :TITLE, pageText = :PTEXT WHERE pageId = :ID");
                }
                if($queryPageUpdate->execute($pageData)){
                    return true;
                }
            }
        }
        return false;
    }
}