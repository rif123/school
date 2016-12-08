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
                                <!-- form start -->
                                <form role="form" id="form-student" enctype="multipart/form-data">
                                    <div class="box-body">                                        
                                        <div class="form-group hide">
                                            <label>Student Id</label>
                                            <input name="student_id" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input name="nis" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Education</label>
                                            <select name="education_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Period</label>
                                            <select name="period_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Born Date</label>
                                            <input name="born_date" type="text" class="form-control" readonly="true">
                                        </div><!-- /.form group -->
                                        <div class="form-group">
                                            <label>Photo</label>
                                            <input name="photo" type="file" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control" rows="3" style="" placeholder="Enter ..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Total payment</label>
                                            <input name="total_payment" type="number" value="0" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                    </div><!-- /.box-body -->
                                    
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
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
                
                var staff = new Staff();                
                staff.initDRP('#form-student input[name=born_date]');                
                staff.getAll_Gender('#form-student select[name=gender_id]');                
                
                var registration = new Registration();
                registration.initDT();
                registration.initFI();
                registration.inputType();
                registration.getAll_Education();
                registration.getAll_Period();
            });
        </script>
    </body>
</html>