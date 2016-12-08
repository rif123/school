var default_date = '0000-00-00';
var dt_staff;

function Staff(){
    this.initDT = initStaffDT;    
    this.initFI = initFIStaff;          
    this.initDRP = initStaffDRP;   
    this.inputType = inputTypeStaff;       
    this.getAll_Permission = getAllStaff_Permission;
    this.getAll_Language = getAllStaff_Language;
    this.getAll_Gender = getAllStaff_Gender;
    this.getAll_PermissionUser = getAllStaff_PermissionUser;
}

function initFIStaff(){    
    var btnCust = '<button type="button" class="btn btn-default" title="Add picture tags" ' + 
            'onclick="alert(\'Call your custom code here.\')">' +
            '<i class="glyphicon glyphicon-tag"></i>' +
            '</button>'; 
    $('#form-staff input[name=photo]').fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showUpload: false,
        browseClass: 'btn btn-default',
        //        showCaption: false,
        //        browseStaff: '',
        //        removeStaff: '',
        //        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        //        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        //        removeTitle: 'Cancel or reset changes',
        //        elErrorContainer: '#kv-avatar-errors',
        //        msgErrorClass: 'alert alert-block alert-danger',
        //        defaultPreviewContent: '<img src="assets/dist/img/default-50x50.gif" alt="Your Avatar" style="width:160px">',
        //        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
}

function initStaffDT(){
    dt_staff = $('#dt-staff').DataTable({
        ajax : base_url+'/staff/getAll',
        //        dom: 'lfrtip', //B -> Button
        //        //        buttons: [
        //        //            'copy', 'csv', 'excel', 'pdf', 'print'
        //        //        ],
        //        //                buttons: [
        //        //                    {
        //        //                        text: 'Button 1',
        //        //                        className: 'btn btn-primary',
        //        //                        action: function ( e, dt, node, config ) {
        //        //                            alert( 'Button 1 clicked on' );
        //        //                        }
        //        //                    }
        //        //                ],
        columns : [{
                "data" : "nip"
            },{
                "data" : "name"
            }, {
                "data" : "gender_detail"
            }, {
                "data" : "language_detail"
            }, {
                "data" : "permission_detail"
            }, {
                "data" : "staff_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getEditStaff(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getDeleteStaff(this);"><i class="fa fa-trash-o"></i> Delete</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5        
    });  
}

function inputTypeStaff(){    
    $('#form-staff').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nip: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    },
                    remote: {
                        type: 'POST',
                        url: '/l-fis/staff/getByNip',
                        message: 'The username is available',
                        delay: 1000
                    }
                }
            },
            name: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        $('#form-staff').submit(function (event) {
            event.preventDefault();                
            var id_length = $('#form-staff input[name=staff_id]').val().split('').length;
            var formData = new FormData($(this)[0]);                
            if (id_length>0) {
                ajaxPro('POST', base_url+'/staff/edit', formData, 'html', false, false, false, false, success, success, null);       
            }else{
                var d = new Date();     
                var staff_id = '111'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                formData.append('staff_id', staff_id);                        
                ajaxPro('POST', base_url+'/staff/insert', formData, 'html', false, false, false, false, success, success, null);          
            }            
            function success(output) {            
                dt_staff.ajax.reload();
                $("#form-staff")[0].reset();
                $("#form-staff").bootstrapValidator('resetForm', true); 
                notify('info', output, null);
            }   
            return false;
        });    
    });               
}

function initStaffDRP(element){
    $(element).daterangepicker({        
        "singleDatePicker": true,
        "showDropdowns": true,        
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel:'Reset'
        }
    });
    $(element).val(default_date);
    $(element).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val(default_date);
    });
}

function getEditStaff(i){
    var staff_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('staff_id', staff_id);                        
    ajaxPro('POST', base_url+'/staff/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {   
        $('#form-staff .form-group').each(function(i, v){
            var element = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var key = Object.keys(output.data)[i];
            var value = output.data[Object.keys(output.data)[i]];            
            $(this).find(element+'[name='+key+']').val(value);            
        });             
    } 
}

function getDeleteStaff(i){
    var staff_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('staff_id', staff_id);                        
    ajaxPro('POST', base_url+'/staff/delete', formData, 'html', false, false, false, false, success, success, null);          
    function success(output) {   
        dt_staff.ajax.reload();
        notify('info', output, null);
    } 
}

function getAllStaff_Permission(){
    //    ajaxPro('POST', '/l-fis/permission/getAllUser', null, 'json', false, false, false, false, success, success, null);          
    ajaxPro('POST', base_url+'/permission/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.permission_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-staff select[name=permission_id]').html(html);
    } 
}

function getAllStaff_PermissionUser(){
    //    ajaxPro('POST', '/l-fis/permission/getAllUser', null, 'json', false, false, false, false, success, success, null);          
    ajaxPro('POST', base_url+'/permission/getAllUser', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.permission_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-staff select[name=permission_id]').html(html);
    } 
}

function getAllStaff_Gender(element){
    ajaxPro('POST', base_url+'/gender/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.gender_id+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    } 
}

function getAllStaff_Language(element){
    ajaxPro('POST', base_url+'/language/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.language_id+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    } 
}

function ajaxPro(type, url, data, dataType, async, cache, contentType, processData, success, error, complete) {
    $.ajax({
        type : type,
        url : url,
        data : data,
        dataType : dataType,
        async : async,
        cache : cache,
        contentType : contentType,
        processData : processData,
        success : success,
        error : error,
        complete : complete
    });
}

function concatString(val) {
    if (val.toString().length === 1) {
        val = '0' + val;
    }
    return val;
}


function notify(type, message, icon) {
    $.notify({
        // options
        icon : icon,
        //        title: 'Bootstrap notify',
        message : message
        //        url: 'https://github.com/mouse0270/bootstrap-notify',
        //        target: '_blank'
    }, {
        // settings
        element : 'body',
        position : null,
        type : type,
        allow_dismiss : true,
        newest_on_top : false,
        showProgressbar : false,
        placement : {
            from : "top",
            align : "right"
        },
        offset : 20,
        spacing : 10,
        z_index : 1031,
        delay : 3000,
        timer : 1000,
        //        url_target: '_blank',
        //        mouse_over: null,
        animate : {
            enter : 'animated fadeInDown',
            exit : 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" style="background:#8BCBDE;color:#FFFFFF" class="col-xs-11 col-sm-3 alert" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                //                '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
    });
}