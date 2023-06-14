<?php  

// CLASS CONNECT DB
class ConnectionsClass{

    // SET ATTRIBUTE CONFIG DB
    private $servername = "localhost"; // SERVER NAME
    // private $username = "root"; // USERNAME
    // private $password = ""; // PASSWORD
    // private $dbname = "nrj_tour"; // DATABASE NAME
    
    private $username = "n1577719_nrjtours"; // USERNAME
    private $password = "Ideta2023"; // PASSWORD
    private $dbname = "n1577719_nrjtours"; // DATABASE NAME

    // METHOD CONNECT TO DB
    protected function dbConn(){
        // SET CONNECTION
        $connect = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // IF VALUE IS TRUE
        if($connect){
            // RETURN THE VALUE CONNECTION
            return $connect; 
        }
    }
    
    // METHOD CHECK TABLE
    protected function dbCheck(?string $tableName = null){
        // QUERY TO CHECK TABLE
        $sql = "SHOW TABLES LIKE '" . $tableName . "'";
        // EXECUTE THE QUERY
        $exe = $this->dbConn()->query($sql);
        // GET NUMS ROW TABLE
        $result = $exe->num_rows;
        $this->dbConn()->close(); // CLOSE THE CONNECTION
        return $result;
    }
    
}


?>