<?php

namespace Controller;
use \Database\DB;
use \PDO;

class Content extends DB{
    /**
     * On class init connect to database
     * 
     */
    public function __construct(){
        parent::__construct(__DB_HOST__, __DB_USERNAME__, __DB_PASSWORD__, __DB_NAME__);
    }

    public function getAgeGroups(){
        $queryAgeGruops = $this->prepQuery("SELECT ageGrpId, ageGrpName FROM agegroups");
        if($queryAgeGruops->execute()){
            return $queryAgeGruops->fetchAll(PDO::FETCH_OBJ);
        }
        return null;
    }

    public function getAgeGroupById($ageId){
        if(isset($ageId) && !empty($ageId)){
            $queryAgeGruop = $this->prepQuery("SELECT ageGrpId, ageGrpName FROM agegroups WHERE ageGrpId = :ID");
            $queryAgeGruop->bindParam(':ID', $ageId, PDO::PARAM_INT);
            if($queryAgeGruop->execute()){
                return $queryAgeGruop->fetch(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function updateAgeGroup($ageData){
        if(isset($ageData) && !empty($ageData)){
            if(gettype($ageData) === 'array'){
                $queryUpdateAge = $this->prepQuery("UPDATE agegroups SET ageGrpName = :NAME WHERE ageGrpId = :ID");
                return $queryUpdateAge->execute($ageData);
            }
        }
        return false;
    }

    public function deleteAgeGroupById($ageId){
        if(isset($ageId) && !empty($ageId)){
            $queryDeleteAge = $this->prepQuery("DELETE FROM agegroups WHERE ageGrpId = :ID");
            $queryDeleteAge->bindParam(':ID', $ageId, PDO::PARAM_INT);
            return $queryDeleteAge->execute();
        }
        return false;
    }

    public function getLevels(){
        $queryLevels = $this->prepQuery("SELECT levelId, levelName FROM levels");
        if($queryLevels->execute()){
            return $queryLevels->fetchAll(PDO::FETCH_OBJ);
        }
        return null;
    }

    public function getLevelById($levelId){
        if(isset($levelId) && !empty($levelId)){
            $queryLevel = $this->prepQuery("SELECT levelId, levelName FROM levels WHERE levelId = :ID");
            $queryLevel->bindParam(':ID', $levelId, PDO::PARAM_INT);
            if($queryLevel->execute()){
                return $queryLevel->fetch(PDO::FETCH_OBJ);
            }
        }
        return false;
    }

    public function updateLevel($levelData){
        if(isset($levelData) && !empty($levelData)){
            if(gettype($levelData) === 'array'){
                $queryUpdateLevel = $this->prepQuery("UPDATE levels SET levelName = :NAME WHERE levelId = :ID");
                return $queryUpdateLevel->execute($levelData);
            }
        }
        return false;
    }

    public function deleteLevelById($levelId){
        if(isset($levelId) && !empty($levelId)){
            $queryDeleteLevel = $this->prepQuery("DELETE FROM levels WHERE levelId = :ID");
            $queryDeleteLevel->bindParam(':ID', $levelId, PDO::PARAM_INT);
            return $queryDeleteLevel->execute();
        }
        return false;
    }

    public function getStyles(){
        $queryStyles = $this->prepQuery("SELECT stylesId, stylesName, stylesDescription, filepath
                                        FROM styles
                                        LEFT JOIN media ON mediaId = stylesPicture");
        if($queryStyles->execute()){
            return $queryStyles->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function getStyleById($styleId){
        if(isset($styleId) && !empty($styleId)){
            $queryStyle = $this->prepQuery("SELECT stylesId, stylesName, stylesDescription, filepath
                                            FROM styles
                                            LEFT JOIN media ON mediaId = stylesPicture
                                            WHERE stylesId = :ID");
            $queryStyle->bindParam(':ID', $styleId, PDO::PARAM_INT);
            if($queryStyle->execute()){
                return $queryStyle->fetch(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function updateStyle($styleData){
        if(isset($styleData) && !empty($styleData)){
            if(gettype($styleData) === 'array'){
                if(array_key_exists(':PICTURE', $styleData)){
                    $queryStyleUpdate = $this->prepQuery("INSERT INTO media (filePath, mediaType)VALUES(:PICTURE, :MTYPE);
                                                         SELECT LAST_INSERT_ID() INTO @lastId;
                                                         UPDATE styles SET stylesName = :TITLE, stylesDescription = :STYLEDesc, stylesPicture = @lastId WHERE stylesId = :ID");
                }else{
                    $queryStyleUpdate = $this->prepQuery("UPDATE styles SET stylesName = :TITLE, stylesDescription = :STYLEDesc WHERE stylesId = :ID");
                }
                if($queryStyleUpdate->execute($styleData)){
                    return true;
                }
            }
        }
        return false;
    }

    public function deleteStyleById($styleId){
        if(isset($styleId) && !empty($styleId)){
            $queryDeleteStyle = $this->prepQuery("SELECT stylesPicture FROM styles WHERE stylesId = :ID INTO @pictureId;
                                                    DELETE FROM styles WHERE stylesId = :ID;
                                                    DELETE FROM media WHERE mediaId = @pictureId;");
            $queryDeleteStyle->bindParam(':ID', $styleId, PDO::PARAM_INT);
            
            return $queryDeleteStyle->execute();
             
        }
        return false;
    }
}