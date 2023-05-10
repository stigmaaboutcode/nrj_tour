<?php 

class formatInputClass{
    // no telpn
    function Notelpn($no){
        $phoneNumber = preg_replace('/[^0-9]/','', $no);
        if(substr($phoneNumber, 0, 2) == "62"){
            $phoneNumber = substr_replace($phoneNumber, "", 0, 2);
        }elseif(substr($phoneNumber, 0, 1) == "0"){
            $phoneNumber = substr_replace($phoneNumber, "", 0, 1);
        }
        return $phoneNumber;
    }

    // FUNCTION DATE
    function date(){
        $timezone = new DateTimeZone('Asia/Makassar');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        // AKHIR BULAN
        $endDay = cal_days_in_month(CAL_GREGORIAN, $date->format("m"), $date->format("Y"));

        $result['dateTimeNow'] = $date->format('Y-m-d H:i:s');
        $result['dateNow'] = $date->format('Y-m-d');
        $result['timeNow'] = $date->format('H:i:s');
        $result['startMonth'] = $date->format('Y-m-01');
        $result['endMonth'] = $date->format('Y-m') . "-" . $endDay;

        return $result;
    }
}

?>