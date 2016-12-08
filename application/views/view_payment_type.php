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
                        Payment Type
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Registration</li>
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
                                
                                <!-- form start -->
                                <form role="form" id="form-payment-type">
                                    <div class="box-body">
                                        <div class="form-group hide">                                            
                                            <label>Payment Type Id</label>
                                            <input type="text" name="payment_type_id" class="form-control" placeholder="Enter ..."/>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="detail" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Month</label>
                                            <input name="month" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Period</label>
                                            <select name="period_id" class="form-control"></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Education</label>
                                            <select name="education_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input name="total" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1">PSB</option>
                                                <option value="0">SPP</option>
                                            </select>
                                        </div>        
                                        <!-- Date range -->
                                        <div class="form-group">
                                            <label>Finish Date</label>
                                            <input name="finish_date" type="text" class="form-control" readonly="true">
                                        </div><!-- /.form group -->
                                    </div><!-- /.box-body -->
                                        
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div><!--/.col -->
                    </div><!-- /.row (main row) -->                        
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-success">                                
                                <div class="box-body">
                                    <table id="dt-payment-type" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><center>Name</center></th>
                                                <th width="30"><center>Month</center></th>                                       
                                                <th width="30"><center>Period</center></th>                                       
                                                <th width="30"><center>Education</center></th>                                       
                                                <th width="30"><center>Total</center></th>                                       
                                                <th width="30"><center>Status</center></th>                                       
                                                <th width="130"><center>Finish Date</center></th>                                       
                                                <th width="150"></th>										
                                            </tr>
                                        </thead>																		
                                    </table>
                                </div><!-- /.box-header -->
                                    
                            </div><!-- /.box -->
                        </div><!--/.col -->
                    </div><!-- /.row (main row) -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'view_main_footer.php'; ?>
        </div>
        <?php include 'view_footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){                
                var pt = new Payment_Type();                                
                pt.initDT();
                pt.initDRP();
//                pt.initDP();
                pt.inputType();
                pt.getAllEducation();
                pt.getAllPeriod();
            });
        </script>
    </body>
</html>