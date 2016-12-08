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
                        Setting
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Setting</li>
                    </ol>
                </section>
                    
                <!-- Main content -->
                <section class="content">                    
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs" id="nav-tabs">
                                    <li class="active"><a href="#setting-user" data-toggle="tab"><i class="fa fa-dashboard"></i> User</a></li>
                                    <li><a href="#setting-photo" data-toggle="tab">Photo</a></li>
                                    <li><a href="#setting-profil" data-toggle="tab">Profil</a></li>
                                    <li><a href="#setting-password" data-toggle="tab">Change password</a></li>   		                                                                                                                                                                            		                                                                                                                                        
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="setting-user">
                                        <table id="dt-setting-user" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="150"><center>NIP</center></th>
                                            <th width="150"><center>Name</center></th>
                                            <th width="150"><center>Gender</center></th>                                       
                                            <th width="150"><center>Language</center></th>                                       
                                            <th width="150"><center>Permission</center></th>                                       
                                            <th width="150"><center>Password</center></th>                                       
                                            <th width="150"></th>										
                                            </tr>
                                            </thead>																		
                                        </table>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="setting-photo">								
                                        <div id="kv-avatar-errors" class="center-block" style="width:800px;display:none"></div>
                                        <form id="form-setting-photo" class="text-center" action="/avatar_upload.php" method="post" enctype="multipart/form-data">
                                            <div class="kv-avatar center-block" style="width:200px">
                                                <input id="avatar" name="photo" type="file" class="file-loading">
                                            </div>
                                            <!-- include other inputs if needed and include a form submit (save) button -->
                                        </form>
                                    </div><!-- /.tab-pane -->                                    
                                    <div class="tab-pane" id="setting-profil">								
                                        <form role="form" id="form-setting-profil">
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
                                                    <label>Born Date</label>
                                                    <input name="born_date" type="text" class="form-control" readonly="true">
                                                </div><!-- /.form group -->
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select name="gender_id" class="form-control"></select>
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
                                    </div><!-- /.tab-pane --> 
                                    <div class="tab-pane" id="setting-password">
                                        <form role="form" id="form-setting-password">
                                            <div class="box-body">                                               
                                                <div class="form-group">
                                                    <label>Old password</label>
                                                    <input type="password" class="form-control" name="old_password" value="" placeholder="Enter ...">
                                                </div>
                                                <div class="form-group">
                                                    <label>New password</label>
                                                    <input type="password" class="form-control" name="new_password" value="" placeholder="Enter ...">
                                                </div>
                                                <div class="form-group">
                                                    <label>Re-enter new password</label>
                                                    <input type="password" class="form-control" name="re_new_password" value="" placeholder="Enter ...">
                                                </div>                                       
                                            </div><!-- /.box-body -->
                                                
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>                                                                                                                            
                                    </div><!-- /.tab-pane -->   
                                    <div class="tab-pane" id="setting-username">
                                        <form role="form" id="form-setting-username">
                                            <div class="box-body">                                               
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username" value="" placeholder="Enter ...">
                                                </div>                                                
                                            </div><!-- /.box-body -->                                                
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>                                                                                                                            
                                    </div><!-- /.tab-pane -->   
                                    <div class="tab-pane" id="setting-database">
                                        <form role="form" id="form-setting-database" action="/l-fis/setting/exportDB" method="POST">
                                            
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn btn-block btn-success">Export Database</button>
                                            </div>
                                        </form>                                                                                                                            
                                    </div><!-- /.tab-pane -->   
                                </div><!-- /.tab-content -->
                            </div><!-- nav-tabs-custom -->
                        </div><!--/.col -->                        
                    </div><!-- /.row (main row) -->                    
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'view_modal.php'; ?>
            <?php include 'view_main_footer.php'; ?>
        </div>
        <?php include 'view_footer.php'; ?>
        <script src="<?php echo base_url(); ?>assets/plugins/hideShowPassword/hideShowPassword.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){                
                
                
                var staff = new Staff();                
                staff.initFI();
                staff.initDRP('#form-setting-profil input[name=born_date]');
                staff.initDRP('#form-staff input[name=born_date]');
                
                staff.getAll_Gender('#form-setting-profil select[name=gender_id]');
                staff.getAll_Gender('#form-staff select[name=gender_id]');
                staff.getAll_Language('#form-staff select[name=language_id]');
                staff.getAll_PermissionUser();
                
                
                var setting = new Setting();
                setting.initDT();
                setting.getTabMenu();
                setting.inputType();
                setting.getBySession();
                setting.profilUpdate();
                setting.initFISetting();
                setting.photoUpdate();
                setting.photoPassword();
                setting.settingUsername();
                setting.initUsername();
                setting.initSHP();
//                setting.settingDB();
            });
        </script>
    </body>
</html>