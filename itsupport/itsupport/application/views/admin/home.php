    <?php include_once 'header.php'; ?>
    <?php include_once'menu.php'; ?>	
    
    <!---------------------------------------- Start Body Top Content -------------------------------------->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Dashboard <small>statistics and more</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/admin/home"> Dashboard </a></li>
                        <li class="pull-right"><div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range"><i class="fa fa-calendar"></i><span></span><i class="fa fa-angle-down"></i></div>
                        </li>
                    </ul>
                </div>
            </div>
            
            
            
        </div>
    </div>
    <!---------------------------------------- End Body Top Content -------------------------------------->
    <!---------------------------------------- Start Student  Show-------------------------------------->
    <!---------------------------------------- End Student  Show-------------------------------------->

    <?php include_once 'footer.php'; ?>
     <script src="<?php echo base_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/custom/table-editable.js"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            TableEditable.init();
        });
    </script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>

    <script>
        $(document).ready(function() {
            $("#drop_menu").click(function() {
                $("#drop_menu").addClass("open");
            });
        });
    </script>    
    </body>
    </html>
