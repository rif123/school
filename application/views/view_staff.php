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
                        Staff
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Staff</li>
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
                                <form role="form" id="form-staff" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group hide">                                            
                                            <label>Staff Id</label>
                                            <input type="text" name="staff_id" class="form-control" placeholder="Enter ..."/>
                                        </div>  
                                        <div class="form-group">
                                            <label>NIP</label>
                                            <input type="text" name="nip" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">                                                
                                                <input type="password" name="password" id="password" class="form-control" readonly="true">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" id="show-password"> Show Password
                                                </span>
                                            </div>
                                        </div>    
                                        <div class="form-group">
                                            <label>Photo</label>
                                            <input name="photo" type="file" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Born Date</label>
                                            <input name="born_date" type="text" class="form-control" readonly="true">
                                        </div><!-- /.form group -->
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Language</label>
                                            <select name="language_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Permission</label>
                                            <select name="permission_id" class="form-control"></select>
                                        </div>  
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control" rows="3" style="" placeholder="Enter ..."></textarea>
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
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-success">                                
                                <div class="box-body">
                                    <table id="dt-staff" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="150"><center>NIP</center></th>
                                        <th width="150"><center>Name</center></th>
                                        <th width="150"><center>Gender</center></th>                                       
                                        <th width="150"><center>Language</center></th>                                       
                                        <th width="150"><center>Permission</center></th>                                       
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
        <script src="<?php echo base_url(); ?>assets/plugins/hideShowPassword/hideShowPassword.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){                
                var staff = new Staff();
                staff.initDT();
                staff.initFI();
                staff.initDRP('#form-staff input[name=born_date]');
                staff.inputType();
                staff.getAll_Gender('#form-staff select[name=gender_id]');
                staff.getAll_Language('#form-staff select[name=language_id]');
                staff.getAll_Permission();
                
                var setting = new Setting();               
                setting.initSHP();
                
                //				setInterval(screenWidth, 1000);				
                
            });
            
            //			function screenWidth(){				
            //					if($(window).width()>960){
            //						$('.deal').width(($('.col-md-12').width()/$('.deal').length)-3);				
            //					}				
            //				}							
        </script>
    </body>
</html>