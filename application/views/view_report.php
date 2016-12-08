<html>
    <?php include 'view_head.php'; ?>
    <body class="hold-transition skin-green-light sidebar-collapse sidebar-mini">
        <div class="wrapper">            
            <?php include 'view_header.php'; ?>
            <?php include 'view_sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
                
                <!-- Main content -->
                <section class="content">                    
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-success">                               
                                <div class="box-body">
                                    <table id="dt-report" class="table table-bordered table-hover"></table>
                                </div><!-- /.box-header -->                                    
                            </div><!-- /.box -->                           
                        </div><!--/.col -->    
                    </div><!-- /.row (main row) -->
                    <table id="table-print" class="table-print hide"></table>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'view_modal.php'; ?>
            <?php include 'view_main_footer.php'; ?>
            <?php 
                $username_data = $this->session->userdata('staff');
                $name = $username_data->name;
            ?>
        </div>
        <?php include 'view_footer.php'; ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/table2excel/jquery.table2excel.js"></script>        
        <script type="text/javascript">
            $(document).ready(function(){ 
                var globalUsername = "<?php echo $name; ?>";
                var report = new Report();
                report.initDT(globalUsername);
                report.getEducation('#form-other-filter select[name=education]');
                report.getClass('#form-other-filter select[name=class]');
                report.getPaymentType('#form-other-filter select[name=payment_type]');
                report.initDRP('#form-other-filter input[name=start_date]');
                report.initDRP('#form-other-filter input[name=finish_date]');
                report.resetField('#form-other-filter #reset_start_date', '#form-other-filter input[name=start_date]');
                report.resetField('#form-other-filter #reset_finish_date', '#form-other-filter input[name=finish_date]');
                report.otherFilter();
            });
        </script>
    </body>
</html>