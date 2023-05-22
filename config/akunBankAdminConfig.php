<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

$dataBankClass = new dataBankClass();

// EDIT / DELETE
if(isset($_GET['id']) && isset($_GET['param'])){
    $idBank = $_GET['id'];
    $param = $_GET['param'];
    $dataBank = $dataBankClass->selectDataBank("idData",$idBank);
    
    if($dataBank['nums'] == 0){
        header('Location: akun-bank-admin');
        exit();
    }else{
        if($param == "edit"){
            foreach($dataBank['data'] as $row){
                $bankName = $row['nama_bank'];
                $accountName = $row['atas_nama'];
                $accountNumber = $row['no_rek'];
            }
        }elseif($param == "delete"){
            $deleteBank = $dataBankClass->deleteDataBank($idBank);
            if($deleteBank){
                $_SESSION['alertSuccess'] = "Data terhapus.";
                header('Location: akun-bank-admin');
                exit();
            }
        }else{
            header('Location: akun-bank-admin');
            exit();
        }
    }
}

// SIMPAN
if(isset($_POST['submit'])){
    $bankName = strtoupper(trim($_POST['bankName']));
    $accountName = ucwords(trim($_POST['accountName']));
    $accountNumber = preg_replace('/[^0-9]/','', trim($_POST['accountNumber']));

    // REQUIRED
    if($bankName == "" || $accountName == "" || $accountNumber == ""){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        if(isset($_GET['id']) && isset($_GET['param'])){
            // GET DATA FOR CHECK
            $checkBank = $dataBankClass->selectDataBank("checkUpdate",$bankName,$accountName,$accountNumber,$_GET['id']);
            if($checkBank['nums'] > 0){
                $_SESSION['alertError'] = "Data bank sudah ada.";
            }else{
                $updateBank = $dataBankClass->UpdateDataBank($_GET['id'],$bankName,$accountName,$accountNumber);
                if($updateBank){
                    $_SESSION['alertSuccess'] = "Data tersimpan.";
                    header('Location: akun-bank-admin');
                    exit();
                }
            }
        }else{
            // GET DATA FOR CHECK
            $checkBank = $dataBankClass->selectDataBank("checkInsert",$bankName,$accountName,$accountNumber);
            if($checkBank['nums'] > 0){
                $_SESSION['alertError'] = "Data bank sudah ada.";
            }else{
                $insertBank = $dataBankClass->insertDataBank($bankName,$accountName,$accountNumber);
                if($insertBank){
                    $_SESSION['alertSuccess'] = "Data tersimpan.";
                    header('Location: akun-bank-admin');
                    exit();
                }
            }
        }
    }
}

// DATA TABLE
function dataTable(){
    global $dataBankClass;
    $num = 1;
    $dataTable = $dataBankClass->selectDataBank("allData");
    foreach($dataTable['data'] as $row){
        echo '<tr>
                <th scope="row">' . $num++ . '</th>
                <td>' . $row['nama_bank'] . '</td>
                <td>' . $row['atas_nama'] . '</td>
                <td>' . $row['no_rek'] . '</td>
                <td>
                    <a href="akun-bank-admin?id=' . $row['id'] . '&param=edit" class="btn btn-outline-warning btn-sm">Edit</a>
                    <a href="akun-bank-admin?id=' . $row['id'] . '&param=delete" class="btn btn-outline-danger btn-sm">Delete</a>
                </td>
            </tr>';
    }
}
?>