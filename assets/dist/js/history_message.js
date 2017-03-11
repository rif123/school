var dt_history_message;
//var custom = new Custom();

function HistoryMessage(){
    this.initDT = initHistoryMessageDT;    
    this.inputType = inputTypeHistoryMessage;    
    this.getAll_HistoryType = getAllHM_HistoryType;    
    this.getAll_Language = getAllHM_Language;    
}

function initHistoryMessageDT(){
    dt_history_message = $('#dt-history-message').DataTable({
        ajax : base_url+'history_message/getAll',
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
                "data" : "history_message_detail"
            },{
                "data" : "history_detail"
            },{
                "data" : "language_detail"
            },{
                "data" : "history_message_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getEditHistoryMessage(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getDeleteHistoryMessage(this);"><i class="fa fa-trash-o"></i> Delete</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5        
    });  
}

function getAllHM_HistoryType(){
    ajaxPro('POST', base_url+'history_type/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.history_type_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-history-message select[name=history_type_id]').html(html);
    } 
}

function getAllHM_Language(){
    ajaxPro('POST', base_url+'language/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {          
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.language_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-history-message select[name=language_id]').html(html);
    } 
}

function inputTypeHistoryMessage(){    
    $('#form-history-message').bootstrapValidator({
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
        $('#form-history-message').submit(function (event) {
            event.preventDefault();                
            var id_length = $('#form-history-message input[name=history_message_id]').val().split('').length;
            var formData = new FormData($(this)[0]);                
            if (id_length>0) {                
                ajaxPro('POST', base_url+'history_message/edit', formData, 'html', false, false, false, false, success, success, null);          
            }else{                
                var d = new Date();         
                var history_message_id = '118'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                formData.append('history_message_id', history_message_id);                        
                ajaxPro('POST', base_url+'history_message/insert', formData, 'html', false, false, false, false, success, success, null);  
            }
            function success(output) {            
                dt_history_message.ajax.reload();
                $("#form-history-message")[0].reset();
                $("#form-history-message").bootstrapValidator('resetForm', true); 
                notify('info', output, null);
            }  
            return false;
        });    
    });               
}

function getEditHistoryMessage(i){
    var history_message_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('history_message_id', history_message_id);                        
    ajaxPro('POST', base_url+'history_message/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {           
        $('#form-history-message .form-group').each(function(i, v){
            var element = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var key = Object.keys(output.data)[i];
            var value = output.data[Object.keys(output.data)[i]];            
            $(this).find(element+'[name='+key+']').val(value);            
        });               
    } 
}

function getDeleteHistoryMessage(i){
    var history_message_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('history_message_id', history_message_id);                        
    ajaxPro('POST', base_url+'history_message/delete', formData, 'html', false, false, false, false, success, success, null);          
    function success(output) {   
        dt_history_message.ajax.reload();
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