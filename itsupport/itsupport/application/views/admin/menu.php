
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler hidden-phone">
                    </div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                <?php 
                   $url = $this->uri->segment(2);
                ?>
                <li class="start <?php echo ($url == 'home')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/admin/home">
                        <i class="fa fa-home"></i>
                        <span class="title"> Dashboard </span>
                        <span class="selected"> </span>
                    </a>
                </li>
                <li class="start <?php echo ($url=='addTitle'||$url=='addCategory'||$url=='addContent'||$url=='viewContent')? 'active':'' ?>">
                    <a href="#">
                        <i class="fa fa-map-marker"></i>
                        <span class="title">Category</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" >
                        <li class="<?php echo ($url == 'addCategory')? 'active':'' ?>">
                            <a href="<?php echo base_url(); ?>index.php/adminhome/addCategory"><i class="fa fa-location-arrow"></i>
                                <span class="title">Add Category</span>
                                <span> </span>
                            </a>
                      </li>
                      <li class="<?php echo ($url == 'addTitle')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/adminhome/addTitle"><i class="fa fa-crosshairs"></i>
                                <span class="title">Add Title</span>
                                <span> </span>
                           </a>
                      </li>
                      <li class="<?php echo ($url == 'addContent')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/adminhome/addContent"><i class="fa fa-crosshairs"></i>
                                <span class="title">Add Content</span>
                                <span> </span>
                           </a>
                      </li>
                      <li class="<?php echo ($url == 'viewContent')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/adminhome/viewContent"><i class="fa fa-crosshairs"></i>
                                <span class="title">View Content</span>
                                <span> </span>
                           </a>
                      </li>
                     </ul>
                </li>
                <li class="start <?php echo ($url=='addContinents'||$url=='addCountries' || $url=='uploadxl')? 'active':'' ?>">
                    <a href="#">
                        <i class="fa fa-globe"></i>
                        <span class="title">Continents</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" >
                        <li class="<?php echo ($url == 'addContinents')? 'active':'' ?>">
                            <a href="<?php echo base_url(); ?>index.php/adminhome/addContinents"><i class="fa fa-globe"></i>
                                <span class="title">Add Continents</span>
                                <span> </span>
                            </a>
                      </li>
                      <li class="<?php echo ($url == 'addCountries')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/adminhome/addCountries"><i class="fa fa-flag-checkered"></i>
                                <span class="title">Add Country</span>
                                <span> </span>
                           </a>
                      </li>
                      <li class="<?php echo ($url == 'uploadxl')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/adminhome/uploadxl"><i class="fa fa-crosshairs"></i>
                                <span class="title">Import xls</span>
                                <span> </span>
                           </a>
                      </li>
                      <li class="<?php echo ($url == 'exportExcel')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/adminhome/exportExcel"><i class="fa fa-crosshairs"></i>
                                <span class="title">Export</span>
                                <span> </span>
                           </a>
                      </li>
                     </ul>
                </li>
                <li class="start <?php echo ($url=='logout'||$url=='changePassword' )? 'active':'' ?>">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span class="title">Settings</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" >
                        <li class="<?php echo ($url == 'changePassword')? 'active':'' ?>">
                            <a href="<?php echo base_url(); ?>index.php/admin/changePassword"><i class="fa fa-location-arrow"></i>
                                <span class="title">Change Password</span>
                                <span> </span>
                            </a>
                      </li>
                      <li class="<?php echo ($url == 'logout')? 'active':'' ?>">
                           <a href="<?php echo base_url(); ?>index.php/admin/logout"><i class="fa fa-power-off"></i>
                                <span class="title">Logout</span>
                                <span> </span>
                           </a>
                      </li>
                      </ul>
                </li>
                <li class="start <?php echo ($url == 'sendNotification')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/admin/sendNotification">
                        <i class="fa fa-bell"></i>
                        <span class="title">Notification</span>
                        <span> </span>
                    </a>
                </li>
                <!--li class="start <?php echo ($url == 'orderList' || $url == 'orderDetail')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="title">Order</span>
                        <span> </span>
                    </a>
                </li>
                <li class="start <?php echo ($url == 'restaurantList' || $url == 'addRestaurant' || $url == 'editRestaurant')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/adminhome/restaurantList">
                        <i class="fa fa-cutlery"></i>
                        <span class="title">Restaurant</span>
                        <span> </span>
                    </a>
                </li>
                <li class="start <?php echo ($url == 'userList' || $url == 'editUser')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/adminlevelone/userList">
                        <i class="fa fa-user"></i>
                        <span class="title">User</span>
                        <span> </span>
                    </a>
                </li>
                <li class="start <?php echo ($url == 'delivererList' || $url == 'editDeliverer')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/adminlevelone/delivererList">
                        <i class="fa fa-truck"></i>
                        <span class="title">Deliverer</span>
                        <span> </span>
                    </a>
                </li>
                
                <li class="start <?php echo ($url == 'changePassword')? 'active':'' ?>">
                    <a href="<?php echo base_url(); ?>index.php/adminlevelone/changePassword">
                        <i class="fa fa-unlock-alt"></i>
                        <span class="title">Change Password</span>
                        <span> </span>
                    </a>
                </li-->
                <!--li class="start ">
                    <a href="<?php echo base_url()?>index.php/admin/logout">
                        <i class="fa fa-power-off "></i>
                        <span class="title">Log Out</span>
                        <span> </span>
                    </a>
                </li-->
           </ul>
        </div>
    </div>
    <!-- END SIDEBAR -->
