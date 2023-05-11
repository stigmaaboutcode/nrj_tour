<?php  
// CLASS USER
class userClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "user";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_referral VARCHAR(7) NOT NULL UNIQUE,
                email VARCHAR(250) NOT NULL UNIQUE,
                name VARCHAR(25) NOT NULL,
                no_telpn VARCHAR(25) NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role_user ENUM('ADMIN','OWNER','KONSULTAN') NOT NULL DEFAULT 'KONSULTAN',
                upline VARCHAR(7) NOT NULL DEFAULT 'ADMIN',
                status ENUM('AKTIF','TIDAK AKTIF') NOT NULL DEFAULT 'TIDAK AKTIF',
                join_date DATETIME NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertUser(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null, ?string $value5 = null, ?string $value6 = null, ?string $value7 = null, ?string $value8 = null, ?string $value9 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_referral,
            email,
            name,
            no_telpn,
            password,
            role_user,
            upline,
            status,
            join_date
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "',
            '" . $value4 . "',
            '" . $value5 . "',
            '" . $value6 . "',
            '" . $value7 . "',
            '" . $value8 . "',
            '" . $value9 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectUser(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
        // SET QUERY
        if($param == "oneCondition"){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE " . $key1 . " = '" . $key2 . "'";
        }
        // EXECUTE QUERY
        $exe = $this->dbConn()->query($sql);
        // SET DATA FROM TABLE
        while($rows = $exe->fetch_assoc()){
            $data[] = $rows;
        }
        // GET DATA TABLE
        $result["data"] = $data;
        // GET NUMS ROW TABLE
        $result["nums"] = $exe->num_rows;
         // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $result;
    }

    // UPDATE TABLE
    public function UpdateUser(?string $param = null, ?string $key = null, ?string $value1 = null, ?string $value2 = null){
        // SET QUERY
        if($param == "editPass"){
            $sql = "UPDATE " . $this->table_name . " SET password  = '" . $value1 . "' WHERE code_referral = '" . $key . "'";
        }elseif($param == "editData"){
            $sql = "UPDATE " . $this->table_name . " SET name  = '" . $value1 . "', no_telpn = '" . $value2 . "' WHERE code_referral = '" . $key . "'";
        }
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>