<?php  
// CLASS USER
class hargaDpClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "harga_dp";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                umroh DOUBLE NOT NULL DEFAULT '0',
                haji DOUBLE NOT NULL DEFAULT '0'
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            if($this->dbConn()->query($sql)){
                $this->insertHargaDp("3500000","5000000");
            };
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertHargaDp(?string $value1 = null, ?string $value2 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            umroh,
            haji
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectHargaDp(){
        // SET QUERY
        $sql = "SELECT umroh, haji FROM " . $this->table_name . " WHERE id = '1'";
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
    public function UpdateHargaDp(?string $value1 = null, ?string $value2 = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET umroh  = '" . $value1 . "', haji = '" . $value2 . "' WHERE id = '1'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>