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
                        Student
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Student</li>
                    </ol>
                </section>                
                <!-- Main content -->
                <section class="content">                    
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-success">                                
                                <div class="box-body">
                                    <table id="dt-staff" class="table table-bordered table-hover">
                                        <thead>
                                            <tr id="filterrow">
                                                <th width="120" colspan="8" style="text-align:right">Education</th>                                       
                                            </tr>
                                            <tr >
                                                <th width="120"><center>NIS</center></th>
                                                <th width="120"><center>Name</center></th>
                                                <th width="120"><center>Gender</center></th>                                       
                                                <th width="120"><center>Address</center></th>                                       
                                                <th width="120"><center>Class</center></th>                                       
                                                <th width="120"><center>Education</center></th>                                       
                                                <th width="120"><center>Period</center></th>                                       
                                                <th width="180"></th>										
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
                var student = new Student();
                student.initDT();                
                student.initDRP();                
                student.getAllGender();                
                student.getAllEducation();                                
                student.getAllClass();                                                                              
                student.getAllPeriod();                                
                student.saveEdit();                                
            });       
        </script>
    </body>
</html>