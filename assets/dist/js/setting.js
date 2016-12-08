var dt_setting_user;

function Setting(){
    this.initDT = initSettingDT;
    this.getTabMenu = getSettingMenu;
    this.inputType = inputTypeSetting;
    this.getBySession = getBySessionSetting;
    this.profilUpdate = settingProfilUpdate;
    this.photoUpdate = settingPhotoUpdate;
    this.photoPassword = settingPasswordUpdate;
    this.settingUsername = settingUsernameUpdate;
    this.initFISetting = initFISettingStaff;  
    this.initUsername = initSettingUsername;  
    this.settingDB = settingDatabase;  
    this.initSHP = initShPassword;
}

function initShPassword(){
    $('#form-staff #show-password').change(function(){
        $('#form-staff #password').hideShowPassword($(this).prop('checked'));
    }); 
    $('#form-staff input[name=nip]').bind("change keyup", function(event){
        $('#password').val($(this).val());
    });       
}

function initFISettingStaff(){ 
    ajaxPro('POST', base_url+'/staff/getBySession', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                   
        var btnCust = '<button type="submit" class="btn btn-default" title="Add picture tags">' +
                '<i class="fa fa-upload"></i>' +
                '</button>'; 
        $('#form-setting-photo input[name=photo]').fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            browseLabel: '',
            removeLabel: '',
            browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="'+output.data.photo+'" alt="Your Avatar" style="width:160px">',
            layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    }     
}


function inputTypeSetting(){    
    $('#form-staff').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {    
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
                dt_setting_user.ajax.reload();
                $("#form-staff")[0].reset();
                $("#form-staff").bootstrapValidator('resetForm', true); 
                $('#setting-user-modal').modal('hide');
                notify('info', output, null);                                
            }   
            return false;
        });    
    });               
}

function settingProfilUpdate(){    
    $('#form-setting-profil').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {       
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
        $('#form-setting-profil').submit(function (event) {
            event.preventDefault();                
            var id_length = $('#form-setting-profil input[name=staff_id]').val().split('').length;
            var formData = new FormData($(this)[0]);                
            ajaxPro('POST', base_url+'/staff/settingProfil', formData, 'html', false, false, false, false, success, success, null);       
            function success(output) {            
                
                $("#form-setting-profil").bootstrapValidator('resetForm', true);                 
                notify('info', output, null);                                
            }   
            return false;
        });    
    });               
}

function initSettingUsername(){            
    ajaxPro('POST', base_url+'/staff/getBySession', null, 'JSON', false, false, false, false, success, success, null);     
    function success(output) {                   
        $('#form-setting-username input[name=username]').val(output.data.username);
    } 
}

function settingPasswordUpdate(){    
    $('#form-setting-password').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            old_password: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    },
                    remote: {
                        type: 'POST',
                        url: base_url+'/staff/getCurrentPassword',
                        message: 'Old password is wrong!',
                        delay: 1000
                    }
                }
            },
            new_password: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    },
                    identical: {
                        field: 're_new_password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            re_new_password: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    },
                    identical: {
                        field: 'new_password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        $('#form-setting-password').submit(function (event) {
            event.preventDefault();                            
            var formData = new FormData($(this)[0]);                
            ajaxPro('POST', base_url+'/staff/settingPassword', formData, 'html', false, false, false, false, success, success, null);       
            function success(output) {            
                $("#form-setting-password")[0].reset();
                $("#form-setting-password").bootstrapValidator('resetForm', true);                 
                notify('info', output, null);                                
            }   
            return false;
        });    
    });               
}

function settingPhotoUpdate(){    
    $('#form-setting-photo').submit(function (event) {
        event.preventDefault();                
        var id_length = $('#form-setting-profil input[name=staff_id]').val().split('').length;
        var formData = new FormData($(this)[0]);                
        ajaxPro('POST', base_url+'/staff/settingPhoto', formData, 'html', false, false, false, false, success, success, null);       
        function success(output) {                                              
            notify('info', output, null);                                
        }   
        return false;
    });                
}

function settingDatabase(){    
    $('#form-setting-database').submit(function (event) {
        event.preventDefault();                        
        var formData = new FormData($(this)[0]);                
        ajaxPro('POST', base_url+'/setting/exportDB', formData, 'html', false, false, false, false, success, success, null);       
        function success(output) {                                              
            notify('info', output, null);                                
        }   
        return false;
    });                
}

function settingUsernameUpdate(){    
    $('#form-setting-username').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    },
                    remote: {
                        type: 'POST',
                        url: base_url+'/staff/getAvailableUsername',
                        message: 'Username already used!',
                        delay: 1000
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        $('#form-setting-username').submit(function (event) {
            event.preventDefault();                            
            var formData = new FormData($(this)[0]);                
            ajaxPro('POST', base_url+'/staff/settingUsername', formData, 'html', false, false, false, false, success, success, null);       
            function success(output) {            
                $("#form-setting-username")[0].reset();
                $("#form-setting-username").bootstrapValidator('resetForm', true);                 
                notify('info', output, null);                                
            }   
            return false;
        });    
    });                     
}

function initSettingDT(){
    dt_setting_user = $('#dt-setting-user').DataTable({
        ajax : base_url+'/staff/getAllUser',
        dom: 'Bfrtip', //B -> Button
        //        buttons: [
        //            'copy', 'csv', 'excel', 'pdf', 'print'
        //        ],
        buttons: [
            {
                text: '<i class="fa fa-user-plus"></i>',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    $('#setting-user-modal').modal('show');
                }
            }
        ],
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
                "data" : "password"
            }, {
                "data" : "staff_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getEditSetting(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getDeleteSetting(this);"><i class="fa fa-trash-o"></i> Delete</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5     
    });      
}

function getSettingMenu(){
    var formData = new FormData($(this)[0]);        
    formData.append('detail', 'Tab');  
    ajaxPro('POST', base_url+'/menu/getByIdType', formData, 'JSON', false, false, false, false, success, success, null);          
    function success(output) {   
        var html = '';
        $(output.data).each(function(i, v){
            html += '<li><a href="'+v.controller+'" data-toggle="tab"><i class="'+v.icon+'"></i> '+v.detail+'</a></li>';
        });
        $('#nav-tabs').html(html); 
        $('#nav-tabs li:eq(0)').addClass('active');
        var id = $('#nav-tabs li.active').find('a').attr('href');
        if(id==='#setting-photo'){            
            $('#setting-user').removeClass('active');
            $(id).addClass('tab-pane active');
        }        
        
    } 
}

function getEditSetting(i){
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
        $('#setting-user-modal').modal('show');
    } 
}

function getDeleteSetting(i){
    var staff_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('staff_id', staff_id);                        
    ajaxPro('POST', base_url+'/staff/delete', formData, 'html', false, false, false, false, success, success, null);          
    function success(output) {   
        dt_setting_user.ajax.reload();
        notify('info', output, null);
    } 
}

function getBySessionSetting(){
    ajaxPro('POST', base_url+'/staff/getBySession', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {   
        $('#form-setting-profil .form-group').each(function(i, v){
            var element_tag = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var element_name = $(this).children().eq('1').prop("name").toString().toLowerCase();                        
            var key = Object.keys(output.data);
            $(key).each(function(j, w){
                if(key[j]===element_name){
                    var value = output.data[key[j]];            
                    $('#form-setting-profil '+element_tag+'[name='+key[j]+']').val(value); 
                    return false;
                }
            });
        });                     
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