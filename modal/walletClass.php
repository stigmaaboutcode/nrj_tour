<?php  
// CLASS USER
class walletClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "wallet_user";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_referral VARCHAR(7) NOT NULL UNIQUE,
                bonus_balance DOUBLE NULL DEFAULT '0',
                poin_balance INT(11) NULL DEFAULT '0'
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertWallet(?string $value1 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_referral
        ) VALUES(
            '" . $value1 . "''
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectWallet(?string $key = null){
        // SET QUERY
        $sql = "SELECT bonus_balance, poin_balance FROM " . $this->table_name . " WHERE code_referral = '" . $key . "'";
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
    public function UpdateWallet(?string $field = null, ?string $value = null,?string $key = null){
        // SET QUERY
        $sql = "UPDATE " . $this->table_name . " SET " . $field . "  = '" . $value . "' WHERE code_referral = '" . $key . "'";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>