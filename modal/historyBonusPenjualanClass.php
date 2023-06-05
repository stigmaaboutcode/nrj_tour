<?php  
// CLASS USER
class historyBonusPenjualanClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "history_bonus_penjualan";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_order VARCHAR(20) NOT NULL UNIQUE,
                code_referral VARCHAR(7) NOT NULL,
                category ENUM('UMROH','HAJI') NOT NULL,
                nominal DOUBLE NOT NULL,
                date DATETIME NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertHistoryBonusPenjualan(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null, ?string $value5 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_order,
            code_referral,
            category,
            nominal,
            date
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "',
            '" . $value4 . "',
            '" . $value5 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectHistoryBonusPenjualan(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
        // SET QUERY
        if($param == "allData"){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE date >= '" . $key1 . " 00:00:00' AND date <= '" . $key2 . " 23:59:59' ORDER BY date DESC";
        }elseif($param == "byUser"){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE date >= '" . $key1 . " 00:00:00' AND date <= '" . $key2 . " 23:59:59' AND code_referral = '" . $key3 . "' ORDER BY date DESC";
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