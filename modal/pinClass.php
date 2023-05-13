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
                code_referral VARCHAR(12) NOT NULL,
                pin_uang_muka VARCHAR(12) NOT NULL,
                pin_pelunasan VARCHAR(12) NOT NULL,
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
            pin_uang_muka,
            pin_pelunasan,
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
        if($param == "pinUangMuka"){
            $sql = "SELECT code_referral FROM " . $this->table_name . " WHERE pin_uang_muka = '" . $key1 . "' AND date_create = '" . $key2 . "' AND code_referral = '" . $key3 . "'";
        }elseif($param == "pinPelunasan"){
            $sql = "SELECT code_referral FROM " . $this->table_name . " WHERE pin_pelunasan = '" . $key1 . "' AND date_create = '" . $key2 . "' AND code_referral = '" . $key3 . "'";
        }elseif($param == "pinUangMukaCheck"){
            $sql = "SELECT code_referral FROM " . $this->table_name . " WHERE pin_uang_muka = '" . $key1 . "' AND date_create = '" . $key2 . "'";
        }elseif($param == "pinPelunasanCheck"){
            $sql = "SELECT code_referral FROM " . $this->table_name . " WHERE pin_pelunasan = '" . $key1 . "' AND date_create = '" . $key2 . "'";
        }elseif($param == "dataPinUser"){
            $sql = "SELECT pin_uang_muka, pin_pelunasan FROM " . $this->table_name . " WHERE code_referral = '" . $key1 . "' AND date_create = '" . $key2 . "'";
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

}

?>