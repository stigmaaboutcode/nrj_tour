<?php
// GET ID FROM URL
$id_prov = $_GET['prov_id'];
// SET CLASS RAJA ONGKIR
include "../modal/rajaOngkir.php";
// GET CLASS RAJA ONGKIR
$rajaOngkir = new rajaOngkir();
// GET DATA KAB / KOTA
$kab_kota = $rajaOngkir->showKabKota($id_prov);


if ($kab_kota == "error") {
    echo "cURL Error #:";
} else {
    echo '<option value="">--PILIH KAB / KOTA--</option>';

    foreach ($kab_kota as $index => $row){
        echo "<option value='" . $row['city_id'] . "." . $row['city_name'] . "' id='" . $row['city_id'] . "'>" . $row['city_name'] . "</option>";
    }
}
