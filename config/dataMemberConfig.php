<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$title = "Konsultan";
if($role_user == "KONSULTAN"){
    $title = "Rekrutmen";
}

if(isset($_GET['user']) && isset($_GET['param'])){
    $id = $_GET['user'];
    $param = $_GET['param'];
    $updateUser = false;
    if($param == "suspen"){
        $updateUser = $userClass->UpdateUser("statusUser", $id, "TIDAK AKTIF");
    }else{
        $updateUser = $userClass->UpdateUser("statusUser", $id, "AKTIF");
    }
    if($updateUser){
        $_SESSION['alertSuccess'] = "Data tersimpan.";
        header('Location: data-member');
        exit();
    }
}

// DATA TABLE
function dataTable(){
    global $userClass;
    global $role_user;
    $num = 1;
    if($role_user == "KONSULTAN"){
        $data = $userClass->selectUser("oneCondition", "upline", $_SESSION['id_nrjtour']);
    }else{
        $data = $userClass->selectUser("oneCondition", "role_user", "KONSULTAN");
    }

    foreach($data['data'] as $row){
        if($row['status'] == "AKTIF"){
            $btn = '<a href="data-member?user=' . $row['code_referral'] . '&param=suspen" class="btn btn-sm btn-danger"><i class="mx-auto ri-shut-down-line"></i></a>';
        }else{
            $btn = '<a href="data-member?user=' . $row['code_referral'] . '&param=aktif" class="btn btn-sm btn-success"><i class="mx-auto ri-shut-down-line"></i></a>';
        }
        echo '<tr>
                <th> ' . $num++ . ' </th>
                <td>
                    <strong>' . $row['name'] . ' (' . $row['code_referral'] . ')</strong><br>
                    <i>' . $row['email'] . '</i><br> 
                    <i>+62' . $row['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . $row['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a>
                </td>
                <td>
                    <strong>' . dataUser($row['upline'])['name'] . '</strong><br>
                    <i>' . dataUser($row['upline'])['email'] . '<br>
                    +62' . dataUser($row['upline'])['no_telpn'] . '<i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['upline'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto  ri-whatsapp-line"></i></a>&nbsp;&nbsp;&nbsp;
                </td>
                <td> 25 Paket Umroh </td>
                <td>' . colorStatus($row['status']) . '</td>
                <td>' . $row['join_date'] . '</td>';
        if($role_user != "KONSULTAN"){
            echo'<td>' . $btn . '</td>';
        }
        echo'</tr>';
    }
}

// COLOR STATUS
function colorStatus($txt){
    if($txt == "AKTIF"){
        return '<span class="badge rounded-pill alert-success">' . $txt . '</span>';
    }else{
        return '<span class="badge rounded-pill alert-danger">' . $txt . '</span>';
    }
}

// DATA USER
function dataUser($idUser){
    global $userClass;
    $data = $userClass->selectUser("oneCondition","code_referral",$idUser);
    foreach($data['data'] as $row){
        $result['name'] = $row['name'];
        $result['email'] = $row['email'];
        $result['no_telpn'] = $row['no_telpn'];
        $result['role_user'] = $row['role_user'];
        $result['upline'] = $row['upline'];
    }
    $result['nums'] = $data['nums'];
    return $result;
}
?>