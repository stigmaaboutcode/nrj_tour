<?php  
// CLASS USER
class dataBankUserClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "data_bank_user";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_referral VARCHAR(7) NOT NULL UNIQUE,
                nama_bank VARCHAR(150) NOT NULL,
                atas_nama VARCHAR(250) NOT NULL,
                no_rek TEXT NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertDataBankUser(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_referral,
            nama_bank,
            atas_nama,
            no_rek
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
    public function selectDataBankUser(?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
        // SET QUERY
        $sql = "SELECT * FROM " . $this->table_name . " WHERE code_referral = '" . $key1 . "'";
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
    public function UpdateDataBankUser(?string $key = null, ?string $value1 = null, ?string $value2 = null, ?string $value3 = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET nama_bank = '" . $value1 . "', atas_nama = '" . $value2 . "', no_rek = '" . $value3 . "' WHERE code_referral = '" . $key . "'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>