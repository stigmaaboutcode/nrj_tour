<?php  
// CLASS USER
class withdrawClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "withdraw";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_referral VARCHAR(7) NOT NULL,
                nominal DOUBLE NOT NULL,
                status ENUM('PENDING','DITOLAK','SUCCESS') NOT NULL DEFAULT 'PENDING',
                date DATETIME NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertWithdraw(?string $value1 = null, ?string $value2 = null, ?string $value3 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_referral,
            nominal,
            date
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
    public function selectWithdraw(?string $param = null, ?string $key1 = null, ?string $key2 = null){
        // SET QUERY
        if($param == "oneCondition"){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE " . $key1 . " = '" . $key2 . "' ORDER BY date DESC";
        }else{
            $sql = "SELECT * FROM " . $this->table_name . " ORDER BY date DESC";
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
    public function UpdateWithdraw(?string $key = null, ?string $value = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET status  = '" . $value . "' WHERE id = '" . $key . "'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>