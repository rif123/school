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
                        Menu
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Menu</li>
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
                                <form role="form" id="form-menu">
                                    <div class="box-body">
                                        <div class="form-group hide">                                            
                                            <label>Menu Id</label>
                                            <input type="text" name="menu_id" class="form-control" placeholder="Enter ..."/>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="detail" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Controller</label>
                                            <input name="controller" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input name="icon" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select name="menu_type_id" class="form-control"></select>
                                        </div>                                          
                                        <div class="form-group">
                                            <label>Permission</label>
                                            <select name="permission_id" class="form-control"></select>
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
                                    <table id="dt-menu" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><center>Name</center></th>
                                                <th width="30"><center>Controller</center></th>                                       
                                                <th width="80"><center>Icon</center></th>                                       
                                                <th width="30"><center>Type</center></th>                                       
                                                <th width="30"><center>Permission</center></th>                                       
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
                var menu = new Menu();                
                menu.initDT();
                menu.inputType();
                menu.getAll_Permission();                
                menu.getAll_MenuType();                
            });
        </script>
    </body>
</html>