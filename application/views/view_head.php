<?php
$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
$this->output->set_header('Pragma: no-cache');
?>
    
<head>	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>L-FIS</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/dist/img/logo.gif" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css">    
    <!-- Notify -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/notify/animate.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/ionicons-master/css/ionicons.min.css">  
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->        
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- DataTables -->          
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-2/datatables.net-dt/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-2/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-2/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">    
    <!-- FileInput -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fileinput/css/fileinput.min.css">  
    <!-- Morris charts -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
    <!-- Validator -->
    <link href="<?php echo base_url(); ?>assets/plugins/validator/dist/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />   
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        #user-login:hover, #user-login:focus, #user-login:active, #user-login:visited, #user-login:link, .nav.nav-title:hover, .nav.nav-title:focus, .nav.nav-title:active, .nav.nav-title:visited, .nav.nav-title:link,{
            background:transparent;
            color: #ffffff;
        }
        .center {
            margin: auto;
            width: 50%;
            border: 3px solid #73AD21;
            padding: 10px;
        }
        /*        .content-wrapper{
                    padding-top: 50px;
                }        */
        textarea{
            resize: none;
        }
        .nav-tabs-custom .tab-pane .box-footer{
            margin: -10px;
            padding: 10px 10px 0px 20px;
        }		
        
        .deal{
            display:inline-block;
        }
        
        .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }
        .kv-avatar .file-input {
            display: table-cell;
            max-width: 220px;
        }
    </style>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>