<?php  
    $dataPenjualanClass = new dataPenjualanClass();
    $withdrawClass = new withdrawClass();
?>
<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="dasbor" class="waves-effect">
                        <i class="mdi mdi-home-variant-outline"></i>
                        <span>Dasbor</span>
                    </a>
                </li>

                <?php 
                    if($role_user == "ADMIN"){
                        // PRMINTAAN PEMBELIAN
                        $dataNotif = $dataPenjualanClass->selectDataPenjualan("all");
                        $orderNumPendingNotif = 0;
                        $orderNumPendingPelunansanNotif = 0;
                        foreach($dataNotif['data'] as $row){
                            if($row['status'] == "PENDING"){
                                $orderNumPendingNotif += 1;
                            }elseif($row['status'] == "MENUNGGU KONFIRMASI PELUNASAN"){
                                $orderNumPendingPelunansanNotif += 1;
                            }
                        }
                        $dataWd = $withdrawClass->selectWithdraw("oneCondition", "status", "PENDING");
                        $wdnUMPending = $dataWd['nums'];
                ?>
                    <!-- ========== START TAMPILAN ADMIN ========== -->
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-email-alert-outline"></i>
                            <?php if($orderNumPendingNotif + $orderNumPendingPelunansanNotif + $wdnUMPending > 0){ ?>
                                <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumPendingNotif + $orderNumPendingPelunansanNotif + $wdnUMPending ?></span>
                            <?php } ?>
                            <span>Permintaan</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="pending-dp">
                                    <?php if($orderNumPendingNotif > 0){ ?>
                                        <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumPendingNotif ?></span>
                                    <?php } ?>
                                    Pembayaran DP
                                </a>
                            </li>
                            <li>
                                <a href="pending-pelunasan">
                                    <?php if($orderNumPendingPelunansanNotif > 0){ ?>
                                        <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumPendingPelunansanNotif ?></span>
                                    <?php } ?>
                                    Pembayaran Pelunasan
                                </a>
                            </li>
                            <li>
                                <a href="withdraw-pending">
                                    <?php if($wdnUMPending > 0){ ?>
                                        <span class="badge rounded-pill bg-warning text-dark float-end"><?= $wdnUMPending ?></span>
                                    <?php } ?>
                                    Withdraw Komisi
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="pin-transaksi" class="waves-effect">
                            <i class="ri-rotate-lock-line"></i>
                            <span>Pin Transaksi</span>
                        </a>
                    </li>
                    <li class="menu-title">Data & Laporan</li>
                    <li>
                        <a href="data-member" class="waves-effect">
                            <i class="ri-group-line"></i>
                            <span>Konsultan</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ri-shopping-cart-line"></i>
                            <span>Penjualan Paket</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-gift-line"></i>
                            <span>Bonus Penjualan</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="bonus-penjualan">Perekrut</a></li>
                            <li><a href="javascript: void(0);" class="has-arrow">Matching</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="javascript: void(0);">Rekap</a></li>
                                    <li><a href="javascript: void(0);">Detail</a></li>
                                </ul>
                            </li>         
                        </ul>
                    </li>
                    <li>
                        <a href="withdraw" class="waves-effect">
                            <i class="mdi mdi-form-dropdown"></i>
                            <span>Withdraw</span>
                        </a>
                    </li>
                    <li class="menu-title">Data Master</li>
                    <li>
                        <a href="akun-bank-admin" class="waves-effect">
                            <i class="ri-bank-line"></i>
                            <span>Rekening Bank</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-money-dollar-circle-line "></i>
                            <span>Harga & Bonus</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="setting-harga-dp">Harga DP</a></li>
                            <li><a href="setting-harga-pelunasan">Harga Paket Pelunasan</a></li>
                            <li><a href="setting-bonus-penjualan">Bonus Penjualan</a></li>
                            <li><a href="setting-bonus-upline">Bonus Matching</a></li>
                        </ul>
                    </li>
                    <!-- END TAMPILAN ADMIN -->
                <?php 
                    }else{
                        $dataNotif = $dataPenjualanClass->selectDataPenjualan("oneCondition", "perekrut", $_SESSION['id_nrjtour']);
                        $orderNumPendingNotif = 0;
                        $orderNumTolakNotif = 0;
                        $orderNumMenungguPelunansanNotif = 0;
                        $orderNumPendingPelunansanNotif = 0;
                        $orderNumTolakPelunansanNotif = 0;
                        foreach($dataNotif['data'] as $row){
                            if($row['status'] == "PENDING"){
                                $orderNumPendingNotif += 1;
                            }elseif($row['status'] == "DITOLAK"){
                                $orderNumTolakNotif += 1;
                            }elseif($row['status'] == "MENUNGGU PELUNASAN"){
                                $orderNumMenungguPelunansanNotif += 1;
                            }elseif($row['status'] == "MENUNGGU KONFIRMASI PELUNASAN"){
                                $orderNumPendingPelunansanNotif += 1;
                            }elseif($row['status'] == "PELUNASAN DITOLAK"){
                                $orderNumTolakPelunansanNotif += 1;
                            }
                        }
                ?>
                    <!-- ========== START TAMPILAN MEMBER ========== -->
                    <li>
                        <a href="order-paket" class="waves-effect">
                            <i class="ri-add-circle-line"></i>
                            <span>Order Paket</span>
                        </a>
                    </li>
                    <li>
                        <a href="pelunasan-paket" class="waves-effect">
                            <i class="ri-edit-line"></i>
                            <span>Pelunasan Paket</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-repeat-2-line"></i>
                            <?php if($orderNumTolakNotif + $orderNumTolakPelunansanNotif > 0){ ?>
                                <span class="badge rounded-pill bg-danger float-end"><?= $orderNumTolakNotif + $orderNumTolakPelunansanNotif ?></span>
                            <?php } ?>
                            <?php if($orderNumPendingNotif + $orderNumMenungguPelunansanNotif + $orderNumPendingPelunansanNotif > 0){ ?>
                                <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumPendingNotif + $orderNumMenungguPelunansanNotif + $orderNumPendingPelunansanNotif ?></span>
                            <?php } ?>
                            <span>Proses Order</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="pending-dp">
                                    <?php if($orderNumTolakNotif> 0){ ?>
                                        <span class="badge rounded-pill bg-danger float-end"><?= $orderNumTolakNotif?></span>
                                    <?php } ?>
                                    <?php if($orderNumPendingNotif > 0){ ?>
                                        <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumPendingNotif ?></span>
                                    <?php } ?>
                                    Pending DP
                                </a>
                            </li>
                            <li>
                                <a href="menunggu-pelunasan">
                                    <?php if($orderNumMenungguPelunansanNotif > 0){ ?>
                                        <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumMenungguPelunansanNotif ?></span>
                                    <?php } ?>
                                    Menunggu Pelunasan
                                </a>
                            </li>
                            <li>
                                <a href="pending-pelunasan">
                                    <?php if($orderNumTolakPelunansanNotif > 0){ ?>
                                        <span class="badge rounded-pill bg-danger float-end"><?= $orderNumTolakPelunansanNotif ?></span>
                                    <?php } ?>
                                    <?php if($orderNumPendingPelunansanNotif > 0){ ?>
                                        <span class="badge rounded-pill bg-warning text-dark float-end"><?= $orderNumPendingPelunansanNotif ?></span>
                                    <?php } ?>
                                    Pending Pelunasan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="tukar-bonus-dan-poin" class="waves-effect">
                            <i class="ri-arrow-left-right-line"></i>
                            <span>Tukar Bonus & Poin</span>
                        </a>
                    </li>
                    <li class="menu-title">Data & Laporan</li>
                    <li>
                        <a href="data-member" class="waves-effect">
                            <i class="ri-group-line"></i>
                            <span>Rekrutmen</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ri-shopping-cart-line"></i>
                            <span>Penjualan Paket</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-gift-line"></i>
                            <span>My Bonus</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="bonus-penjualan">Penjualan Paket</a></li>
                            <li><a href="javascript: void(0);">Matching</a></li>         
                        </ul>
                    </li>
                    <li>
                        <a href="withdraw" class="waves-effect">
                            <i class="mdi mdi-form-dropdown"></i>
                            <span>Withdraw</span>
                        </a>
                    </li>
                    <li class="menu-title">Data Master</li>
                    <li>
                        <a href="akun-bank-user" class="waves-effect">
                            <i class="ri-bank-line"></i>
                            <span>Rekening Bank</span>
                        </a>
                    </li>
                    <!-- END TAMPILAN MEMBER -->
                <?php } ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>