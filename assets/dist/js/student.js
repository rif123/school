var default_date = '0000-00-00';
var dt_student;

function Student(){
    this.initDT = initStudentDT;        
    this.initDRP = initStudentDRP;        
    this.getAllEducation = getAllStudent_Education;
    this.getAllClass = getAllStudent_Class;        
    this.getAllGender = getAllStudent_Gender;      
    this.getAllPeriod = getAllStudent_Period;      
    this.saveEdit = saveEditStudent;
}


function saveEditStudent(){    
    $('#form-student').bootstrapValidator({
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
        $('#form-student').submit(function (event) {
            event.preventDefault();                
            var formData = new FormData($(this)[0]);                
            ajaxPro('POST', base_url+'/student/edit', formData, 'html', false, false, false, false, success, success, null);       
            function success(output) {            
                dt_student.ajax.reload();
                $("#form-student")[0].reset();
                $("#form-student").bootstrapValidator('resetForm', true); 
                $('#profile-student-modal').modal('hide');
                notify('info', output, null);
            }   
            return false;
        });    
    });               
}

function initStudentDT(){
    $.ajax({
        type	: 'GET',
        url 	: base_url+"student/getEducation",
        success: function(retval) 
        {	
            $('#dt-staff thead tr#filterrow th').each( function () {
                            // if ($(this).index() == 1){
                                var title = $('#dt-staff thead th').eq( $(this).index() ).text();
                                var htmlEdu = "<select style='width:11%' onchange='educationEvent(this)'>";
                                    htmlEdu += "<option value='' >ALL</option>";
                                $(retval).each(function (n, v){
                                    htmlEdu += "<option value='"+v.nameEdu+"'>"+v.nameEdu+"</option>";
                                })
                                    htmlEdu += "</select>";
                                $(this).html(htmlEdu);
                            // }
           });
        }	
	});
    dt_student = $('#dt-staff').DataTable({
        ajax : base_url+'student/getAll',
        columns : [{
                "data" : "nis"
            },{
                "data" : "name"
            },{
                "data" : "gender_detail"
            }, {
                "data" : "address"
            }, {
                "data" : "class_detail"
            }, {
                "data" : "education_detail"
            }, {
                "data" : "period_detail"
            }, {
                "data" : "student_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-primary" value="' + data + '" onclick="getProfileStudent(this);"><i class="fa fa-user"></i> Profile</button>';
                    html += '<button type="button" class="detail btn btn-primary" value="' + data + '" onclick="getPaymentStudent(this);"><i class="fa fa-credit-card-alt"></i> Payment</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5        
    });  
    
    
}

function educationEvent(element){
    var nameEdu = $(element).val();
   $('#dt-staff').DataTable({
        ajax : base_url+'/student/getAll?findName='+nameEdu,
        columns : [{
                "data" : "nis"
            },{
                "data" : "name"
            },{
                "data" : "gender_detail"
            }, {
                "data" : "address"
            }, {
                "data" : "class_detail"
            }, {
                "data" : "education_detail"
            }, {
                "data" : "period_detail"
            }, {
                "data" : "student_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-primary" value="' + data + '" onclick="getProfileStudent(this);"><i class="fa fa-user"></i> Profile</button>';
                    html += '<button type="button" class="detail btn btn-primary" value="' + data + '" onclick="getPaymentStudent(this);"><i class="fa fa-credit-card-alt"></i> Payment</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5,
        "destroy" : true        
        });
}
    

function getProfileStudent(i){
    var student_id = $(i).val();    
    var formData = new FormData();        
    formData.append('student_id', student_id);                        
    ajaxPro('POST', base_url+'/student/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {           
        $('#form-student .form-group').each(function(i, v){
            $("#form-student").bootstrapValidator('resetForm', true); 
            var element_tag = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var element_name = $(this).children().eq('1').prop("name").toString().toLowerCase();                        
            var key = Object.keys(output.data);                        
            $('#form-student .form-group input[name=name]').val(1);                   
            $(key).each(function(j, w){                  
                if(key[j] === 'name'){
                    var value = output.data[key[j]];  
                    $('#form-student .form-group input[name=name]').val(value);                   
                } else  if(key[j]===element_name){                                          
                    var value = output.data[key[j]];  
                    if(key[j] ==='photo'){
                        var html = '<img src="'+value+'" alt="Your Avatar" style="width:160px">';
                        //                        console.log(html);
                        initFIStudent(html);
                    }else{
                        $('#form-student .form-group '+element_tag+'[name='+key[j]+']').val(value);                   
                    }
                    
                    return false;
                }    
            });
            
            //            $(key).each(function(j, w){                  
            //                if(key[j] ==='photo'){ 
            //                    var value = output.data[key[j]];  
            //                    initFIStudent(value);
            //                    return false;
            //                }else if(key[j]===element_name){                                          
            //                    var value = output.data[key[j]];  
            //                    $('#form-student .form-group '+element_tag+'[name='+key[j]+']').val(value);                   
            //                    return false;
            //                }                                
            //            });                 
        });             
    }                 
    $('#profile-student-modal').modal('show');
    $('#profile-student-modal').on('hidden.bs.modal', function () {
       $('#form-student input[name=photo]').fileinput('destroy');   
    });
}

function getPaymentStudent(i){
     var student_id = $(i).val();
    // var form = document.createElement('form');
    // form.action = base_url+'/payment';
    // form.method = 'post';
    // var input = document.createElement('input');
    // input.type = 'hidden';
    // input.name = 'student_id';
    // input.value = student_id;
    // form.appendChild(input);
    // form.appendTo('body').submit();
    // form.submit();
    
    var jForm = $('<form></form>', {
        action: base_url+'/payment',
        method: 'post'
    });

    $("<input>", {
        name: 'student_id',
        value: student_id,
        type: 'hidden'
    }).appendTo(jForm);

    jForm.appendTo('body').submit();
    
}

function initFIStudent(i){               
    $('#form-student input[name=photo]').fileinput('refresh', {
        //        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showUpload: false,
        browseClass: 'btn btn-default',
        initialPreview: i,
        //        showCaption: false,
        //        browseStaff: '',
        //        removeStaff: '',
        //        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        //        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        //        removeTitle: 'Cancel or reset changes',
        //        elErrorContainer: '#kv-avatar-errors',
        //        msgErrorClass: 'alert alert-block alert-danger',
        //        defaultPreviewContent: i,
        //        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
}
function initStudentDRP(){
    $('#form-student input[name=born_date]').daterangepicker({        
        "singleDatePicker": true,
        "showDropdowns": true,        
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel:'Reset'
        }
    });
    $('#form-student input[name=born_date]').val(default_date);
    $('#form-student input[name=born_date]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val(default_date);
    });
}


function getAllStudent_Period(){
    ajaxPro('POST', base_url+'/period/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.period_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-student select[name=period_id]').html(html);
    } 
}

function getAllStudent_Class(){
    ajaxPro('POST', base_url+'/classes/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.class_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-student select[name=class_id]').html(html);
    } 
}

function getAllStudent_Education(){
    ajaxPro('POST', base_url+'/education/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.education_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-student select[name=education_id]').html(html);
    } 
    //    $('#form-student select[name=class_id]').val($('#form-student select[name=class_id]:e').val());
    //    $('#form-student select[name=education_id]').change(function(){
    //        $('#form-student select[name=class_id]').val($('#form-student select[name=education_id]').val());
    //    });
}

function getAllStudent_Gender(){
    ajaxPro('POST', base_url+'/gender/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.gender_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-student select[name=gender_id]').html(html);
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