<?php
// GET ID FROM URL
$id_kab = $_GET['kabkota_id'];
// SET CLASS RAJA ONGKIR
include "../modal/rajaOngkir.php";
// GET CLASS RAJA ONGKIR
$rajaOngkir = new rajaOngkir();
// GET DATA KAB / KOTA
$kec = $rajaOngkir->showKec($id_kab);


if ($kec == "error") {
    echo "cURL Error #:";
} else {
    echo '<option value="">--PILIH KECAMATAN--</option>';

    foreach ($kec as $index => $row){
        echo "<option value='" . $row['subdistrict_id'] . "." . $row['subdistrict_name'] . "' id='" . $row['subdistrict_id'] . "'>" . $row['subdistrict_name'] . "</option>";
    }
}
