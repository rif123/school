var dt_registration = null;

function Registration(){
    this.initDT = initRegistrationDT;
    this.inputType = inputTypeStudent;       
    this.initFI = initFIRegistration;  
    this.getAll_Education = getAllReg_Education;
    this.getAll_Period = getAllReg_Period;
}

function initFIRegistration(){    
    $('#form-student input[name=photo]').fileinput({
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


function initRegistrationDT(){
    dt_registration = $('#dt-registration').DataTable({});  
}
function inputTypeStudent(){    
    $('#form-student').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
//            nis: {
//                message: 'Invalid value',
//                validators: {
//                    notEmpty: {
//                        message: 'Required'
//                    }
//                }
//            },
            name: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    }
                }
            },
            total_payment: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    },
                    remote: {      
                        type: 'POST',
                        url: '/l-fis/payment_type/getMinMaxValidate2',
                        data: function(validator) {                            
                            return {
                                education_id: validator.getFieldElements('education_id').val(),
                                period_id: validator.getFieldElements('period_id').val(),
                                status : 1
                            };
                        }                        
                    }                  
                }
            }
        }
    }).on('success.form.bv', function (e) {
        $('#form-student').submit(function (event) {
            event.preventDefault();                            
            var formData = new FormData($(this)[0]);                
            var d = new Date();     
            var student_id = '112'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
            formData.append('student_id', student_id);
            ajaxPro('POST', '/l-fis/registration/insert', formData, 'html', false, false, false, false, success, success, null);         
            function success(output) {            
                formData.append('status', 1);
                ajaxPro('POST', '/l-fis/payment_type/getByStatusEducationPeriod', formData, 'json', false, false, false, false, success2, success2, null);          
                function success2(output) {                      
                    var total = $('#form-student [name=total_payment]').val();
                    var payment_group = '1222'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + (Math.floor(Math.random() * (9999999999 - 1000000000) + 1000000000));    
                    $(output.data).each(function(i, v){             
                        if(total>0){
                            var tempTotal = total - v.total;
                            var payment_id = '120'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                            formData.append('payment_id', payment_id);
                            formData.append('payment_group', payment_group);
                            formData.append('payment_type_id', v.payment_type_id);                        
                            if(tempTotal >= 0){
                                formData.append('total', v.total);                                                        
                                ajaxPro('POST', '/l-fis/payment/insert', formData, 'json', false, false, false, false, null, null, null);
                                total = tempTotal;
                            }else{
                                formData.append('total', total);                            
                                ajaxPro('POST', '/l-fis/payment/insert', formData, 'json', false, false, false, false, null, null, null);
                                total = 0;
                            }
                        }                        
                        //                        console.log(v.payment_type_id);
                    });                            
                } 
                
                //                dt_registration.ajax.reload();
                $("#form-student")[0].reset();
                $("#form-student").bootstrapValidator('resetForm', true); 
                notify('info', output, null);
            }   
            return false;
        });    
    });               
}


function getAllReg_Period(){
    ajaxPro('POST', '/l-fis/period/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.period_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-student select[name=period_id]').html(html);
    } 
}


function getAllReg_Education(){
    ajaxPro('POST', '/l-fis/education/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.education_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-student select[name=education_id]').html(html);
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