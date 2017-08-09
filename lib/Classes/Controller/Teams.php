<?php

namespace Controller;
use \Database\DB;
use \PDO;

class Teams extends DB{
    /**
     * On class init connect to database
     * 
     */
    public function __construct(){
        parent::__construct(__DB_HOST__, __DB_USERNAME__, __DB_PASSWORD__, __DB_NAME__);
    }

    public function doExists($teamName){
        if(isset($teamName) && !empty($teamName)){
            $queryTeamName = $this->prepQuery("SELECT teamId FROM teams WHERE teamName = :NAME");
            $queryTeamName->bindParam(':NAME', $teamName, PDO::PARAM_STR);
            return $queryTeamName->execute() && ($queryTeamName->rowCount() === 0) ? false : true;
        }
        return false;
    }

    public function createTeam($teamData){
         if(isset($teamData) && !empty($teamData)){
            if(gettype($teamData) === 'array'){
                $queryCreateTeam = $this->prepQuery("INSERT INTO teams (teamName, fkStyle, fkAgeGrp, fkLevel, fkInstructor, teamPrice)VALUES(:NAME, :STYLE, :AGE, :LEVEL, :INSTRUCTOR, :PRICE)");
                return $queryCreateTeam->execute($teamData);
            }
         }
         return null;
    }

    public function getAllTeams(){
        $queryGetTeams = $this->prepQuery("SELECT teamId, teamName, teamPrice, stylesName, ageGrpName, levelName, firstname, lastname
                                            FROM teams
                                            INNER JOIN styles ON fkStyle = stylesId
                                            INNER JOIN agegroups ON fkAgeGrp = ageGrpId
                                            INNER JOIN levels ON fkLevel = levelId
                                            INNER JOIN instructors ON fkInstructor = insId
                                            INNER JOIN users ON fkUser = userId
                                            INNER JOIN userprofile ON fkProfile = profileId");
        if($queryGetTeams->execute()){
            return $queryGetTeams->fetchAll(PDO::FETCH_OBJ);
        }
        return null;
    }

    public function getTeamById($teamId){
        if(isset($teamId) && !empty($teamId)){
            $queryGetTeam = $this->prepQuery("SELECT teamId, teamName, teamPrice, fkStyle, fkAgeGrp, fkLevel, fkInstructor,
                                            stylesName, ageGrpName, levelName, firstname, lastname
                                            FROM teams
                                            INNER JOIN styles ON fkStyle = stylesId
                                            INNER JOIN agegroups ON fkAgeGrp = ageGrpId
                                            INNER JOIN levels ON fkLevel = levelId
                                            INNER JOIN instructors ON fkInstructor = insId
                                            INNER JOIN users ON fkUser = userId
                                            INNER JOIN userprofile ON fkProfile = profileId
                                            WHERE teamId = :ID");
            $queryGetTeam->bindParam(':ID', $teamId, PDO::PARAM_INT);
            if($queryGetTeam->execute()){
                return $queryGetTeam->fetch(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function getTeamByStyleId($styleId){
         if(isset($styleId) && !empty($styleId)){
             $queryTeamByStyle = $this->prepQuery("SELECT teamId, teamName, teamPrice, stylesName, ageGrpName, levelName, firstname, lastname
                                            FROM teams
                                            INNER JOIN styles ON fkStyle = stylesId
                                            INNER JOIN agegroups ON fkAgeGrp = ageGrpId
                                            INNER JOIN levels ON fkLevel = levelId
                                            INNER JOIN instructors ON fkInstructor = insId
                                            INNER JOIN users ON fkUser = userId
                                            INNER JOIN userprofile ON fkProfile = profileId
                                            WHERE fkStyle = :ID");
            $queryTeamByStyle->bindParam(':ID', $styleId, PDO::PARAM_INT);
            if($queryTeamByStyle->execute()){
                return $queryTeamByStyle->fetchAll(PDO::FETCH_OBJ);
            }
         }
         return null;
    }

    public function updateTeam($teamData){
        if(isset($teamData) && !empty($teamData)){
            if(gettype($teamData) === 'array'){
                $queryUpdateTeam = $this->prepQuery("UPDATE teams SET teamNAme = :NAME,
                                                                      fkStyle = :STYLE, 
                                                                      fkAgeGrp = :AGE, 
                                                                      fkLevel = :LEVEL, 
                                                                      fkInstructor = :INSTRUCTOR, 
                                                                      teamPrice = :PRICE 
                                                    WHERE teamId = :ID");
                return $queryUpdateTeam->execute($teamData);
            }
        }
        return false;
    }

    public function deleteTeam($teamId){
        if(isset($teamId) && !empty($teamId)){
            $queryDeleteTeam = $this->prepQuery("DELETE FROM teams WHERE teamId = :ID");
            $queryDeleteTeam->bindParam(':ID', $teamId, PDO::PARAM_INT);
            return $queryDeleteTeam->execute();
        }
        return false;
    }

    public function isUserOnTeam($userId, $teamId){
        if(isset($userId) && isset($teamId)
             && !empty($userId) && !empty($teamId)){
            $queryParticipants = $this->prepQuery("SELECT pId FROM participants WHERE fkUser = :USERID AND fkTeam = :TEAMID");
            $queryParticipants->bindParam(':USERID', $userId, PDO::PARAM_INT);
            $queryParticipants->bindParam(':TEAMID', $teamId, PDO::PARAM_INT);
            if($queryParticipants->execute() && $queryParticipants->rowCount() > 0){
                return true;
            }
            return false;
        }else{
            return false;
        }
    }

    public function registerUserOnTeam($userId, $teamId){
        if(isset($userId) && isset($teamId)
             && !empty($userId) && !empty($teamId)){
            $queryAddToTeam = $this->prepQuery("INSERT INTO participants (fkTeam, fkUser)VALUES(:TEAMID, :USERID)");
            $queryAddToTeam->bindParam(':TEAMID', $teamId, PDO::PARAM_INT);
            $queryAddToTeam->bindParam(':USERID', $userId, PDO::PARAM_INT);
            return $queryAddToTeam->execute() ? true : false;
        }
        return false;
    }

    public function unregisterUser($userId, $teamId){
        if(isset($userId) && isset($teamId)
             && !empty($userId) && !empty($teamId)){
            $queryUnregister = $this->prepQuery("DELETE FROM participants WHERE fkUser = :USERID AND fkTeam = :TEAMID");
            $queryUnregister->bindParam(':USERID', $userId, PDO::PARAM_INT);
            $queryUnregister->bindParam(':TEAMID', $teamId, PDO::PARAM_INT);
            if($queryUnregister->execute()){
                return true;
            }
        }
        return false;
    }

    public function getUserSubscribtions($userId){
        if(isset($userId) && !empty($userId)){
            $querySubscribtions = $this->prepQuery("SELECT pId, fkTeam FROM participants WHERE fkUser = :USERID");
            $querySubscribtions->bindParam(':USERID', $userId, PDO::PARAM_INT);
            if($querySubscribtions->execute()){
                return $querySubscribtions->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function getTeamSubscribtions($teamId){
        if(!empty($teamId)){
            $querySubscribtions = $this->prepQuery("SELECT pId FROM participants WHERE fkTeam = :TEAMID");
            $querySubscribtions->bindParam(':TEAMID', $teamId, PDO::PARAM_INT);
            if($querySubscribtions->execute()){
                return $querySubscribtions->rowCount();
            }
        }   
        return '0';
    }

    public function getSubscribers($teamId){
        if(!empty($teamId)){
            $querySubscribers = $this->prepQuery("SELECT userId, userEmail, firstname, lastname, phone
                                                    FROM participants
                                                    INNER JOIN users ON fkUser = userId
                                                    INNER JOIN userprofile ON fkProfile = profileId
                                                    WHERE fkTeam = :TEAMID");
            $querySubscribers->bindParam(':TEAMID', $teamId, PDO::PARAM_INT);
            if($querySubscribers->execute()){
                return $querySubscribers->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return null;
    }

    public function getNonSubscribers($teamId){
        if(!empty($teamId)){
            $queryNonSub = $this->prepQuery("SELECT userId, firstname, lastname FROM users
                                                INNER JOIN userprofile ON profileId = fkProfile
                                                WHERE  userId NOT IN (SELECT fkUser FROM participants WHERE fkTeam = :TEAMID)");
            $queryNonSub->bindParam(':TEAMID', $teamId, PDO::PARAM_INT);
            if($queryNonSub->execute()){
                return $queryNonSub->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return null;
    }
}