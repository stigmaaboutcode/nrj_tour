<?php  
// CLASS USER
class hargaPelunasanClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "harga_pelunasan";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                reguler DOUBLE NOT NULL DEFAULT '0',
                eksekutif DOUBLE NOT NULL DEFAULT '0',
                ramadhan DOUBLE NOT NULL DEFAULT '0',
                syawal DOUBLE NOT NULL DEFAULT '0'
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            if($this->dbConn()->query($sql)){
                $this->insertHargaPelunasan("0","0","0","0");
            };
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertHargaPelunasan(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            reguler,
            eksekutif,
            ramadhan,
            syawal
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
    public function selectHargaPelunasan(){
        // SET QUERY
        $sql = "SELECT reguler, eksekutif, ramadhan, syawal FROM " . $this->table_name . " WHERE id = '1'";
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
    public function UpdateHargaPelunasan(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET reguler = '" . $value1 . "', eksekutif = '" . $value2 . "', ramadhan = '" . $value3 . "', syawal = '" . $value4 . "' WHERE id = '1'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>