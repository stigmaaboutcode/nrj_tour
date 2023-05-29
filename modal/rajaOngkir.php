<?php  

class rajaOngkir{
    // METHOD SHOW PROVINSI
    public function showProv(){
        // create curl resource
        $curl = curl_init();

        // inisiasi curl get http raja ongkir
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 3edd124529d0527e0cff142cd3ec17a6"
            ),
        ));

        // set execute curl
        $response = curl_exec($curl);
        // set error curl
        $err = curl_error($curl);
        // close curl
        curl_close($curl);

        // check error or not
        if ($err) {
            return "error";
        } else {
            $array = json_decode($response,TRUE);
            return $array["rajaongkir"]["results"];
            
        }
    }

    // METHOD SHOW KAB / KOTA
    public function showKabKota(?string $id = null){
        // create curl resource
        $curl = curl_init();

        // inisiasi curl get http raja ongkir
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=".$id,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 3edd124529d0527e0cff142cd3ec17a6"
            ),
        ));

        // set execute curl
        $response = curl_exec($curl);
        // set error curl
        $err = curl_error($curl);
        // close curl
        curl_close($curl);

        // check error or not
        if ($err) {
            return "error";
        } else {
            $array = json_decode($response,TRUE);
            return $array["rajaongkir"]["results"];
            
        }
    }
    // METHOD SHOW KAB / KOTA
    public function showKec(?string $id = null){
        // create curl resource
        $curl = curl_init();

        // inisiasi curl get http raja ongkir
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$id,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 3edd124529d0527e0cff142cd3ec17a6"
            ),
        ));

        // set execute curl
        $response = curl_exec($curl);
        // set error curl
        $err = curl_error($curl);
        // close curl
        curl_close($curl);

        // check error or not
        if ($err) {
            return "error";
        } else {
            $array = json_decode($response,TRUE);
            return $array["rajaongkir"]["results"];
            
        }
    }

}

?>