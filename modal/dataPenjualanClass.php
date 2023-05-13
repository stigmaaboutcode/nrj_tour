<?php  
// CLASS USER
class dataPenjualanClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "data_penjualan";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_order VARCHAR(20) NOT NULL UNIQUE,
                perekrut VARCHAR(7) NOT NULL,
                direkrut VARCHAR(7) NOT NULL,
                category ENUM('UMROH','HAJI') NOT NULL,
                is_diskon ENUM('YA','TIDAK') NOT NULL,
                uang_muka DOUBLE NOT NULL,
                bukti_tf_uang_muka TEXT NOT NULL,
                uang_pelunasan DOUBLE NULL DEFAULT '0',
                bukti_tf_pelunasan TEXT NULL,
                status ENUM('PENDING','DITOLAK','MENUNGGU PELUNASAN','MENUNGGU KONFIRMASI PELUNASAN','PELUNASAN DITOLAK','LUNAS') NOT NULL DEFAULT 'PENDING',
                date DATETIME NOT NULL 
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertDataPenjualan(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null, ?string $value5 = null, ?string $value6 = null, ?string $value7 = null, ?string $value8 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_order,
            perekrut,
            direkrut,
            category,
            is_diskon,
            uang_muka,
            bukti_tf_uang_muka,
            date 
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "',
            '" . $value4 . "',
            '" . $value5 . "',
            '" . $value6 . "',
            '" . $value7 . "',
            '" . $value8 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectDataPenjualan(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
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
    public function UpdateDataPenjualan(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $value1 = null, ?string $value2 = null){
        // SET QUERY
        if($param == "changeStatus"){
            $sql = "UPDATE " . $this->table_name . " SET status  = '" . $value1 . "' WHERE " . $key1 . " = '" . $key2 . "'";
        }elseif($param == "confirmDp"){
            $sql = "UPDATE " . $this->table_name . " SET uang_pelunasan = '" . $value1 . "', status = 'MENUNGGU PELUNASAN' WHERE " . $key1 . " = '" . $key2 . "'";
        }elseif($param == "pelunasan"){
            $sql = "UPDATE " . $this->table_name . " SET bukti_tf_pelunasan = '" . $value1 . "', status = 'MENUNGGU KONFIRMASI PELUNASAN' WHERE " . $key1 . " = '" . $key2 . "'";
        }elseif($param == "batalpelunasan"){
            $sql = "UPDATE " . $this->table_name . " SET bukti_tf_pelunasan = '', status = '" . $value1 . "' WHERE " . $key1 . " = '" . $key2 . "'";
        }
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

}

?>