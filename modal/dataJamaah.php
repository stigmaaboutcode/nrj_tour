<?php  
// CLASS USER
class dataJamaahClass extends ConnectionsClass{

    // SET ATTRIBUTE TABLE NAME
    private $table_name = "data_jamaah";
    
    // CREATE DEFAULT TABLE
    public function __construct(){
        // IF TABLE DOESN'T EXISTS, CREATE TABLE!`
        if($this->dbCheck($this->table_name) == 0){
            // SET QUERY
            $sql = "CREATE TABLE " . $this->table_name . " (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code_order VARCHAR(20) NOT NULL UNIQUE,
                foto_ktp TEXT NOT NULL,
                nik TEXT NOT NULL,
                nama VARCHAR(150) NOT NULL,
                tempat_lahir VARCHAR(150) NOT NULL,
                tgl_lahir DATE NOT NULL,
                detail_alamat TEXT NOT NULL,
                prov TEXT NOT NULL,
                id_prov INT(11) NOT NULL,
                kab_kota TEXT NOT NULL,
                id_kab_kota INT(11) NOT NULL,
                kec TEXT NOT NULL,
                id_kec INT(11) NOT NULL,
                jk ENUM('Laki-laki','Perempuan') NOT NULL,
                status_perkawinan ENUM('Belum Kawin','Sudah Kawin','Cerai Hidup','Cerai Mati') NOT NULL,
                tgl_berangkat DATE NULL
            )";
            // EXECUTE THE QUERY TO CREATE TABLE
            $this->dbConn()->query($sql);
            // CLOSE THE CONNECTION
            $this->dbConn()->close();
        }
    }

    // INSERT TABLE
    public function insertDataJamaah(?string $value1 = null, ?string $value2 = null, ?string $value3 = null, ?string $value4 = null, ?string $value5 = null, ?string $value6 = null, ?string $value7 = null, ?string $value8 = null, ?string $value9 = null, ?string $value10 = null, ?string $value11 = null, ?string $value12 = null, ?string $value13 = null, ?string $value14 = null, ?string $value15 = null){
        // SET QUERY
        $sql = "INSERT INTO " . $this->table_name . " (
            code_order,
            foto_ktp,
            nik,
            nama,
            tempat_lahir,
            tgl_lahir,
            detail_alamat,
            prov,
            id_prov,
            kab_kota,
            id_kab_kota,
            kec,
            id_kec,
            jk,
            status_perkawinan
        ) VALUES(
            '" . $value1 . "',
            '" . $value2 . "',
            '" . $value3 . "',
            '" . $value4 . "',
            '" . $value5 . "',
            '" . $value6 . "',
            '" . $value7 . "',
            '" . $value8 . "',
            '" . $value9 . "',
            '" . $value10 . "',
            '" . $value11 . "',
            '" . $value12 . "',
            '" . $value13 . "',
            '" . $value14 . "',
            '" . $value15 . "'
        )";
        // EXECUTE THE QUERY TO CREATE TABLE
        $exe = $this->dbConn()->query($sql);
        // CLOSE THE CONNECTION
        $this->dbConn()->close();
        return $exe;
    }

    // SELECT TABLE
    public function selectDataJamaah(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $key3 = null, ?string $key4 = null){
        // SET QUERY
        if($param == "oneCondition"){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE " . $key1 . " = '" . $key2 . "'";
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
    // public function UpdateDataJamaah(?string $param = null, ?string $key1 = null, ?string $key2 = null, ?string $value1 = null, ?string $value2 = null){
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