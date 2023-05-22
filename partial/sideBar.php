<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="dasbor" class="waves-effect">
                        <i class="mdi mdi-home-variant-outline"></i><span class="badge rounded-pill bg-primary float-end">3</span>
                        <span>Dasbor</span>
                    </a>
                </li>

                <?php if($role_user == "ADMIN"){ ?>
                    <!-- ========== START TAMPILAN ADMIN ========== -->
                    <li class="menu-title">Data Master </li>
                    <li>
                        <a href="akun-bank-admin" class="waves-effect">
                            <i class="ri-bank-line"></i>
                            <span>Rekening Bank</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-share-line"></i>
                            <span>Harga & Bonus</span>
                        </a> 
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="javascript: void(0);">Harga DP</a></li>
                            <li><a href="javascript: void(0);">Harga Paket Pelunasan</a></li>
                        </ul>
                    </li>
                    <!-- END TAMPILAN ADMIN -->
                <?php }else{ ?>
                    <!-- ========== START TAMPILAN MEMBER ========== -->
                    
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