var dt_education;
//var custom = new Custom();

function Education(){
    this.initDT = initEducationDT;    
    this.inputType = inputTypeEducation;    
}

function initEducationDT(){
    dt_education = $('#dt-education').DataTable({
        ajax : base_url+'/education/getAll',
        dom: 'lfrtip', //B -> Button
        //        buttons: [
        //            'copy', 'csv', 'excel', 'pdf', 'print'
        //        ],
        //                buttons: [
        //                    {
        //                        text: 'Button 1',
        //                        className: 'btn btn-primary',
        //                        action: function ( e, dt, node, config ) {
        //                            alert( 'Button 1 clicked on' );
        //                        }
        //                    }
        //                ],
        columns : [{
                "data" : "detail"
            }, {
                "data" : "education_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getEditEducation(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getDeleteEducation(this);"><i class="fa fa-trash-o"></i> Delete</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5        
    });  
}

function inputTypeEducation(){    
    $('#form-education').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            detail: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        $('#form-education').submit(function (event) {
            event.preventDefault();                
            var id_length = $('#form-education input[name=education_id]').val().split('').length;
            var formData = new FormData($(this)[0]);                
            if (id_length>0) {
                ajaxPro('POST', base_url+'education/edit', formData, 'html', false, false, false, false, success, success, null);          
            }else{
                var d = new Date();         
                var education_id = '114'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                formData.append('education_id', education_id);                        
                ajaxPro('POST', base_url+'education/insert', formData, 'html', false, false, false, false, success, success, null);          
            }
            function success(output) {            
                dt_education.ajax.reload();
                $("#form-education")[0].reset();
                $("#form-education").bootstrapValidator('resetForm', true); 
                notify('info', output, null);
            }        
            return false;
        });    
    });               
}

function getEditEducation(i){
    var education_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('education_id', education_id);                        
    ajaxPro('POST', base_url+'/education/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {   
        $('#form-education .form-group').each(function(i, v){
            var element = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var key = Object.keys(output.data)[i];
            var value = output.data[Object.keys(output.data)[i]];            
            $(this).find(element+'[name='+key+']').val(value);            
        });
        //        $('#form-education .form-group').each(function(i, v){
        //            var element = $('#form-education .form-group:eq('+i+')').children().last().prop("tagName").toString().toLowerCase();
        //            
        //            
        //            alert(element);
        //            
        //        });                
    } 
}

function getDeleteEducation(i){
    var education_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('education_id', education_id);                        
    ajaxPro('POST', base_url+'education/delete', formData, 'html', false, false, false, false, success, success, null);          
    function success(output) {   
        dt_education.ajax.reload();
        notify('info', output, null);
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