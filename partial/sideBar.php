<?php  

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

                <?php if($role_user == "ADMIN"){ ?>
                    <!-- ========== START TAMPILAN ADMIN ========== -->
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-email-alert-outline"></i><span class="badge rounded-pill bg-primary float-end">3</span>
                            <span>Permintaan</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="pending-dp"></i><span class="badge rounded-pill bg-primary float-end">3</span>Pembayaran DP</a></li>
                            <li><a href="javascript: void(0);"></i><span class="badge rounded-pill bg-primary float-end">3</span>Pembayaran Pelunasan</a></li>
                            <li><a href="javascript: void(0);"></i><span class="badge rounded-pill bg-primary float-end">3</span>Withdraw Komisi</a></li>
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
                            <li><a href="javascript: void(0);">Perekrut</a></li>
                            <li><a href="javascript: void(0);" class="has-arrow">Matching</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="javascript: void(0);">Rekap</a></li>
                                    <li><a href="javascript: void(0);">Detail</a></li>
                                </ul>
                            </li>         
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
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
                            <li><a href="setting-bonus-upline">Bonus Upline</a></li>
                        </ul>
                    </li>
                    <!-- END TAMPILAN ADMIN -->
                <?php }else{ ?>
                    <!-- ========== START TAMPILAN MEMBER ========== -->
                    <li>
                        <a href="order-paket" class="waves-effect">
                            <i class="ri-add-circle-line"></i>
                            <span>Order Paket</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-repeat-2-line"></i>
                            <span class="badge rounded-pill bg-primary float-end">3</span>
                            <span>Proses Order</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="pending-dp">
                                    <span class="badge rounded-pill bg-primary float-end">3</span>
                                    Pending DP
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <span class="badge rounded-pill bg-primary float-end">3</span>
                                    Menunggu Pelunasan
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <span class="badge rounded-pill bg-primary float-end">3</span>
                                    Pending Pelunasan
                                </a>
                            </li>
                        </ul>
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
                            <li><a href="javascript: void(0);">Penjualan Paket</a></li>
                            <li><a href="javascript: void(0);">Matching</a></li>         
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
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


                <!-- <li class="menu-title">Example</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-share-line"></i>
                        <span>Multi Level</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);">Level 1.1</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Level 2.1</a></li>
                                <li><a href="javascript: void(0);">Level 2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>