<?php

namespace Controller;
use Database\DB;

class User extends DB{

    /**
     * On class init connect to database
     * 
     */
    public function __construct(){
        parent::__construct(__DB_HOST__, __DB_USERNAME__, __DB_PASSWORD__, __DB_NAME__);
    }

    /**
     * Simple function to check if user session is started
     *
     * @return bool
     */
    public function checkSession(){
       if(isset($_SESSION['userId']) && isset($_SESSION['userEmail']) &&
            !empty($_SESSION['userId']) && !empty($_SESSION['userEmail'])){
                $queryUser = $this->prepQuery("SELECT userId FROM users WHERE userId = :ID AND userEmail = :EMAIL");
                $queryUser->bindParam(':ID', $_SESSION['userId'], \PDO::PARAM_INT);
                $queryUser->bindParam(':EMAIL', $_SESSION['userEmail'], \PDO::PARAM_STR);
                return $queryUser->execute() && ($queryUser->rowCount() === 1) ? true : false;
       }
       return false;
    }

    /**
     * verifies user information to authorize access
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function verifyLogin($username, $password){
        /*$options  = array('cost' => 12);
        $hash     = password_hash('1234', PASSWORD_BCRYPT, $options);*/
    
        $queryUser = $this->prepQuery("SELECT userId, userEmail, userPassword,
                                        roleName, roleLevel,
                                        firstname, lastname
                                        FROM users 
                                        INNER JOIN userRoles ON fkRole = roleId 
                                        INNER JOIN userprofile on fkProfile = profileId
                                        WHERE userEmail = :EMAIL");
        $queryUser->bindParam(':EMAIL', $username, \PDO::PARAM_STR);
        if($queryUser->execute() & ($queryUser->rowCount() === 1)){
            $user = $queryUser->fetch(\PDO::FETCH_OBJ);
            if($user->userEmail === $username && password_verify($password, $user->userPassword)){
                $_SESSION['roleLevel']    = $user->roleLevel;
                $_SESSION['roleName']     = $user->roleName;
                $_SESSION['userId']       = $user->userId;
                $_SESSION['userEmail']    = $user->userEmail;
                $_SESSION['userFullname'] = $user->firstname . ' ' . $user->lastname;
                $this->close();
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * Checks if the user is authorized based on userrole
     *
     * @param int $requiredLevel
     * @param string $user
     * @return bool
     */
    public function checkAuth($requiredLevel, $user){
        $queryUserRole = $this->prepQuery("SELECT roleLevel FROM users 
                                        INNER JOIN userRoles ON roleId = fkRole
                                        WHERE userId = :ID");
        $queryUserRole->bindParam(':ID', $user, \PDO::PARAM_INT);
        if($queryUserRole->execute() && $queryUserRole->rowCount() === 1){
            $data = $queryUserRole->fetch(\PDO::FETCH_OBJ);
            $role = (int)$data->roleLevel;
            if((int)$role >= (int)$requiredLevel){
                return true;
            }
        }
        return false;
    }

    /**
     * Check if givene user exists in database
     *
     * @param string $user
     * @return bool
     */
    public function userExists($user){
        $queryCheckUser = $this->prepQuery("SELECT userId FROM users WHERE userEmail = :EMAIL");
        $queryCheckUser->bindParam(':EMAIL', $user, \PDO::PARAM_STR);
        if($queryCheckUser->execute()){
            return $queryCheckUser->rowCount() > 0 ? true : false;
        }
    }
    
    /**
     * Creates user, executes $sql with $userData as the "data-stream"
     *
     * @param string $sql
     * @param array $userData
     * @return bool
     */
    public function userCreate($sql, $userData){
        if(!empty($sql) && gettype($userData) === 'array'){
            $queryCreateUser = $this->prepQuery($sql);
            return $queryCreateUser->execute($userData) ? true : false;
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param int $userId
     * @return object
     */
    public function getProfileById($userId){
        $queryUserProfile = $this->prepQuery("SELECT userId, userEmail, fkRole,
                                                firstname, lastname, birthdate, street, zipcode, city, phone
                                                FROM users 
                                                INNER JOIN userProfile on fkProfile = profileId
                                                WHERE userId = :ID");
        $queryUserProfile->bindParam(':ID', $userId, \PDO::PARAM_INT);
        return ($queryUserProfile->execute() && $queryUserProfile->rowCount() === 1) ? $queryUserProfile->fetch(\PDO::FETCH_OBJ) : null;
    }

    /**
     * Update users profile
     *
     * @param array $userData
     * @return bool
     */
    public function updateUserProfile($userData, $adminEdit = false){
        if(!empty($userData) && gettype($userData) === 'array'){
            if($adminEdit){
                $queryUpdateProfile = $this->prepQuery("SELECT fkProfile FROM users WHERE userId = :ID INTO @profileId;
                                                            UPDATE users SET userEmail = :email, fkRole = :role WHERE userId = :ID;
                                                            UPDATE userprofile SET firstname = :firstname,
                                                                                    lastname = :lastname,
                                                                                    birthdate = :birthdate, 
                                                                                    street = :street, 
                                                                                    zipcode = :zipcode, 
                                                                                    city = :city, 
                                                                                    phone = :phone
                                                            WHERE profileId = @profileId;");
            }else{
                $queryUpdateProfile = $this->prepQuery("SELECT fkProfile FROM users WHERE userId = :ID INTO @profileId;
                                                            UPDATE users SET userEmail = :email WHERE userId = :ID;
                                                            UPDATE userprofile SET firstname = :firstname,
                                                                                    lastname = :lastname,
                                                                                    birthdate = :birthdate, 
                                                                                    street = :street, 
                                                                                    zipcode = :zipcode, 
                                                                                    city = :city, 
                                                                                    phone = :phone
                                                            WHERE profileId = @profileId;");
            }
            return $queryUpdateProfile->execute($userData) ? true : false;
        }
        return false;
    }

    /**
     * Update password, verifies if the old password i correct before changing
     *
     * @param string $oldPassword
     * @param array $passwordData
     * @return bool
     */
    public function updateUserPassword($oldPassword, $passwordData){
        if(!empty($passwordData) && !empty($oldPassword) && gettype($passwordData) === 'array'){
            $queryGetPassword = $this->prepQuery("SELECT userPassword FROM users WHERE userId = :ID");
            $queryGetPassword->bindParam(':ID', $_SESSION['userId'], \PDO::PARAM_INT);
            if($queryGetPassword->execute() && $queryGetPassword->rowCount() === 1){
                $oldPw = $queryGetPassword->fetch(\PDO::FETCH_OBJ);
                if(password_verify($oldPassword, $oldPw->userPassword)){
                    $queryUpdatePassword = $this->prepQuery("UPDATE users SET userPassword = :password WHERE userId = :ID");
                    return $queryUpdatePassword->execute($passwordData) ? true : false;
                }
            }
        }
        return false;
    }

    /**
     * Returns list of instructors from DB
     *
     * @return mixed
     */
    public function getInstructors(){
        $queryInstructors = $this->prepQuery("SELECT insId, userId, firstname, lastname, filePath, mediaType
                                            FROM instructors
                                            INNER JOIN users ON userId = fkUser
                                            INNER JOIN userProfile ON profileId = fkProfile
                                            INNER JOIN media ON mediaId = fkPicture
                                            ");
        if($queryInstructors->execute()){
            return $queryInstructors->fetchAll(\PDO::FETCH_OBJ);
        }
    }

    public function getNonInstructors(){
        $queryInstructors = $this->prepQuery("SELECT userId, firstname, lastname FROM users
                                INNER JOIN userprofile ON profileId = fkProfile
                                INNER JOIN userroles ON roleId = fkRole
                                WHERE roleLevel >= 50 AND userId NOT IN (SELECT fkUser FROM instructors);");
        if($queryInstructors->execute()){
            return $queryInstructors->fetchAll(\PDO::FETCH_OBJ);
        }
        return null;
    }

    /**
     * Returns user roles listed in DB
     *
     * @return mixed
     */
    public function getRoles(){
        $queryRoles = $this->prepQuery("SELECT roleId, roleLevel, roleName FROM userRoles ORDER BY roleName ASC");
        if($queryRoles->execute()){
            return $queryRoles->fetchAll(\PDO::FETCH_OBJ);
        }
        return null;
    }

    /**
     * Return all users listed in DB
     *
     * @return mixed
     */
    public function getAllUsers(){
        $queryAllUsers = $this->prepQuery("SELECT userId, userEmail,
                                            firstname, lastname, street, zipcode, city, phone,
                                            DATE_FORMAT(createdOn, '%d %M %Y') AS dateCreated, 
                                            roleLevel, roleName 
                                            FROM users
                                            INNER JOIN userprofile ON profileId = fkProfile
                                            INNER JOIN userRoles ON roleId = fkRole
                                            ");
        if($queryAllUsers->execute()){
            return $queryAllUsers->fetchAll(\PDO::FETCH_OBJ);
        }
        return null;
    }

    /**
     * Deletes user
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUserById($userId){
        if(!empty($userId)){
            $queryDeleteUser = $this->prepQuery("SELECT fkProfile FROM users WHERE userId = :ID INTO @profileId;
                                                    DELETE FROM users WHERE userId = :ID;
                                                    DELETE FROM userProfile WHERE profileId = @profileId;");
            $queryDeleteUser->bindParam(':ID', $userId, \PDO::PARAM_INT);
            return $queryDeleteUser->execute();
        }
        return false;
    }

    public function deleteInstructorById($insId){
        if(!empty($insId)){
            $queryDeleteInstructor = $this->prepQuery("SELECT fkPicture FROM instructors WHERE insId = :ID INTO @pictureId;
                                                        DELETE FROM instructors WHERE insId = :ID;
                                                        DELETE FROM media WHERE mediaId = @pictureId");
            $queryDeleteInstructor->bindParam(':ID', $insId, \PDO::PARAM_INT);
            return $queryDeleteInstructor->execute();
        }
        return false;
    }

}