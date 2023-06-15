<?php  
// CLASS USER
class pinClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "pin_user";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_referral VARCHAR(7) NOT NULL,
                pin VARCHAR(10) NOT NULL,
                category ENUM('PIN FREE', 'PIN BERBAYAR', 'PIN PELUNASAN') NOT NULL,
                status ENUM('BELUM DIGUNAKAN', 'SUDAH DIGUNAKAN') NOT NULL DEFAULT 'BELUM DIGUNAKAN',
                date_create DATE NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertPin(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_referral,
            pin,
            category,
            date_create
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "',
            '" . $value4 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectPin(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null){
        // SET QUERY
        if($param == "checkPIN"){
            $sql = "SELECT pin FROM " . $this->table_name . " WHERE code_referral = '" . $key1 . "' AND pin = '" . $key2 . "' AND category = '" . $key3 . "' AND status = 'BELUM DIGUNAKAN'";
        }elseif($param == "checkAndCreate"){
            $sql = "SELECT pin FROM " . $this->table_name . " WHERE code_referral = '" . $key1 . "' AND pin = '" . $key2 . "' AND status = 'BELUM DIGUNAKAN'";
        }elseif($param == "UserPin"){
            $sql = "SELECT code_referral, pin, category, status, date_create FROM " . $this->table_name . " WHERE code_referral = '" . $key1 . "' ORDER BY id DESC";
        }else{
            $sql = "SELECT code_referral, pin, category, status, date_create FROM " . $this->table_name . " ORDER BY id DESC";
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
    public function UpdatePin(?string $key1 = null, ?string $key2 = null, ?string $key3 = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET status  = 'SUDAH DIGUNAKAN' WHERE code_referral = '" . $key1 . "' AND pin = '" . $key2 . "' AND category = '" . $key3 . "' AND status = 'BELUM DIGUNAKAN'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>