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
                                    <table id="dt-report-primary" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               <th>Education</th>
                                               <th>NIS</th>
                                               <th>Name</th>
                                               <th>Class</th>
                                               <th>Payment Date</th>
                                               <th>PSB TK 2016</th>
                                               <th>Amount</th>
                                           </tr>
                                       </thead>
                                    </table>
                                </div><!-- /.box-header -->
                            </div><!-- /.box -->
                        </div><!--/.col -->
                    </div><!-- /.row (main row) -->
                    <table id="table-print" class="table-print hide" ></table>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'view_modal.php'; ?>
            <?php include 'view_main_footer.php'; ?>
        </div>
        <?php include 'view_footer.php'; ?>
        <?php
            $username_data = $this->session->userdata('staff');
            $name = $username_data->name;
        ?>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/report_primary.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/table2excel/jquery.table2excel.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var globalUsername = "<?php echo $name; ?>";
                var rp = new ReportPrimary();
                rp.initDT(globalUsername);
                rp.getEducation('#form-primary-filter select[name=education]');
                rp.getClass('#form-primary-filter select[name=class]');
                rp.initDRP('#form-primary-filter input[name=start_date]');
                rp.initDRP('#form-primary-filter input[name=finish_date]');
                rp.resetField('#form-primary-filter #reset_start_date', '#form-primary-filter input[name=start_date]');
                rp.resetField('#form-primary-filter #reset_finish_date', '#form-primary-filter input[name=finish_date]');
                rp.primaryFilter();
            });
        </script>
    </body>
</html>
