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
                        Payment
                        <small>Control panel</small>
                        <small id="student_id" class="hide"><?php echo $student_id;?></small>                        
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Payment</li>
                    </ol>
                </section>
                    
                <!-- Main content -->
                <section class="content">                    
                    <!-- Main row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-success">
                                <div class="box-body">
                                    <table id="dt-payment" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="230"><center>Name</center></th>
                                                <th width="230"><center>Type</center></th>
                                                <th width="230"><center>Invoice</center></th>
                                                <th width="230"><center>Paid</center></th>
                                                <th width="230"><center>Paid Date</center></th>
                                                <th width="350"></th>										
                                            </tr>
                                        </thead>																		
                                    </table>
                                </div><!-- /.box-header -->   
                            </div><!-- /.box -->
                        </div><!--/.col -->
                    </div><!-- /.row (main row) -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'view_modal.php'; ?>
            <?php include 'view_main_footer.php'; ?>
        </div>
        <?php include 'view_footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){                
                var payment = new Payment();
                payment.initDT();
                payment.inputType();
                payment.inputTypePrimary();
            });
        </script>
    </body>
</html>