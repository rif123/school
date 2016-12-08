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
                        Registraton
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
                                <div class="box-header with-border">
                                    <h3 class="box-title">Registration Form</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role="form">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Education</label>
                                            <select class="form-control">
                                                <option>option 1</option>
                                                <option>option 2</option>
                                                <option>option 3</option>
                                                <option>option 4</option>
                                                <option>option 5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control">
                                                <option>option 1</option>
                                                <option>option 2</option>
                                                <option>option 3</option>
                                                <option>option 4</option>
                                                <option>option 5</option>
                                            </select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="3" style="" placeholder="Enter ..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Total payment</label>
                                            <input type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
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
                                <div class="box-header with-border">
                                    <h3 class="box-title">Registration Data</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="dt-registration" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="230%"><center>Username</center></th>
                                        <th width="230%"><center>Email</center></th>
                                        <th width="230%"><center>Phone</center></th>
                                        <th width="30%"></th>										
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
                var registration = new Registration();
                registration.initDT();
            });
        </script>
    </body>
</html>