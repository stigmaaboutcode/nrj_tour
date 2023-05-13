<?php  
// CLASS USER
class dataKelengkapanJamaahClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "data_kelengkapan_jamaah";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_order VARCHAR(20) NOT NULL UNIQUE,
                no_passport INT(59) NOT NULL,
                tgl_terbit DATE NOT NULL,
                tgl_berlaku DATE NOT NULL,
                alamat_terbit TEXT NOT NULL,
                is_vaksi ENUM('YA','TIDAK') NOT NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertDataKelengkapanJamaah(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null, ?string $value5 = null, ?string $value6 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_order,
            no_passport,
            tgl_terbit,
            tgl_berlaku,
            alamat_terbit,
            is_vaksi
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "',
            '" . $value4 . "',
            '" . $value5 . "',
            '" . $value6 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectDataKelengkapanJamaah(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
        // SET QUERY
        if($param == "oneCondition"){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE " . $key1 . " = '" . $key2 . "' ORDER BY date DESC";
        }
        // EXECUTE QUERY
        $exe = $this->dbConn()->query($sql);
        // SET DATA FROM  TABLE
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
    // public function UpdateDataKelengkapanJamaah(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $value1 = null, ?string $value2 = null){
    //     // SET QUERY
    //     if($param == "changeStatus"){
    //         $sql = "UPDATE " . $this->table_name . " SET status  = '" . $value1 . "' WHERE " . $key1 . " = '" . $key2 . "'";
    //     }elseif($param == "confirmDp"){
    //         $sql = "UPDATE " . $this->table_name . " SET uang_pelunasan = '" . $value1 . "', status = 'MENUNGGU PELUNASAN' WHERE " . $key1 . " = '" . $key2 . "'";
    //     }elseif($param == "pelunasan"){
    //         $sql = "UPDATE " . $this->table_name . " SET bukti_tf_pelunasan = '" . $value1 . "', status = 'MENUNGGU KONFIRMASI PELUNASAN' WHERE " . $key1 . " = '" . $key2 . "'";
    //     }elseif($param == "batalpelunasan"){
    //         $sql = "UPDATE " . $this->table_name . " SET bukti_tf_pelunasan = '', status = '" . $value1 . "' WHERE " . $key1 . " = '" . $key2 . "'";
    //     }
    //     // EXECUTE THE QUERY TO CREATE TABLE
    //     $exe = $this->dbConn()->query($sql);
    //     // CLOSE THE CONNECTION
    //     $this->dbConn()->close();
    //     return $exe;
    // }

}

?>