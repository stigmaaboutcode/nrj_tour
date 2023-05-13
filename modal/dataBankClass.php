<?php  
// CLASS USER
class dataBankClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "user";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_bank VARCHAR(50) NOT NULL,
                atas_nama VARCHAR(250) NOT NULL,
                no_rek INT(19) NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertDataBank(?string $value1 = null, ?string $value2 = null, ?string $value3 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            nama_bank,
            atas_nama,
            no_rek
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
    public function selectDataBank(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
        // SET QUERY
        if($param == "allData"){
            $sql = "SELECT nama_bank, atas_nama, no_rek FROM " . $this->table_name;
        }elseif($param == "idData"){
            $sql = "SELECT nama_bank, atas_nama, no_rek FROM " . $this->table_name . " WHERE id = '" . $key1 . "'";
        }elseif($param == "checkUpdate"){
            $sql = "SELECT id FROM " . $this->table_name . " WHERE nama_bank = '"   . $key1 . "' AND atas_nama = '" . $key2 . "' AND no_rek = '" . $key3 . "' AND id <> '" . $key4 . "'";
        }elseif($param == "checkInsert"){
            $sql = "SELECT id FROM " . $this->table_name . " WHERE nama_bank = '" . $key1 . "' AND atas_nama = '" . $key2 . "' AND no_rek = '" . $key3 . "'";
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
    public function UpdateDataBank(?string $key = null, ?string $value1 = null, ?string $value2 = null, ?string $value3 = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET nama_bank = '" . $value1 . "', atas_nama = '" . $value2 . "', no_rek = '" . $value3 . "' WHERE id = '" . $key . "'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // DELETE TABLE
    public function deleteDataBank(?string $key = null){
        // SET QUERY
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = '" . $key . "'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>