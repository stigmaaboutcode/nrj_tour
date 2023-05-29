<?php
// SET CLASS RAJA ONGKIR
include "../modal/rajaOngkir.php";
// GET CLASS RAJA ONGKIR
$rajaOngkir = new rajaOngkir();
// GET DATA KAB / KOTA
$prov = $rajaOngkir->showProv();


if ($prov == "error") {
    echo "cURL Error #:";
} else {
    echo '<option value="">--PILIH PROVINSI--</option>';

    foreach($prov as $index => $row){
        echo "<option value='" . $row['province_id'] . "." . $row['province'] . "' id='" . $row['province_id'] . "' >" . $row['province'] . "</option>";
    }
}
