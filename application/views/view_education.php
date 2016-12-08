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
                        Education
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Education</li>
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
                                <form role="form" id="form-education">
                                    <div class="box-body">
                                        <div class="form-group hide">                                            
                                            <label>Education Id</label>
                                            <input type="text" name="education_id" class="form-control" placeholder="Enter ..."/>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="detail" class="form-control" placeholder="Enter ..."/>
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
                                
                                <div class="box-body">
                                    <table id="dt-education" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th ><center>Name</center></th>                                                
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
                var education = new Education();
                education.initDT();
                education.inputType();
            });
        </script>
    </body>
</html>