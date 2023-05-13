<?php  
// CLASS USER
class hargaBonusClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "harga_bonus";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                category ENUN('PENJUALAN','UPLINE') NOT NULL,
                umroh DOUBLE NOT NULL DEFAULT '0',
                haji DOUBLE NOT NULL DEFAULT '0'
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            if($this->dbConn()->query($sql)){
                $default = [
                    "PENJUALAN" => [2000000,3000000],
                    "UPLINE" => [250000,500000]
                ];
                foreach($default as $field => $values){
                    $this->insertHargaBonus($field,$values[0],$values[1]);
                }
            };
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertHargaBonus(?string $value1 = null, ?string $value2 = null, ?string $value3 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            category,
            umroh,
            haji
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectHargaBonus(?string $key = null){
        // SET QUERY
        $sql = "SELECT umroh, haji FROM " . $this->table_name . " WHERE category = '" . $key . "'";
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
    public function UpdateHargaBonus(?string $key = null, ?string $value1 = null, ?string $value2 = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET umroh  = '" . $value1 . "', haji = '" . $value2 . "' WHERE category = '" . $key . "'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>