var default_date = '0000-00-00 00:00:00';
var dt_payment_type = null;
function Payment_Type(){
    this.initDT = initPaymentTypeDT;
    this.initDRP = initPaymentTypeDRP;
    this.initDP = initPaymentTypeDP;
    this.getAllEducation = getAllPT_Education;
    this.getAllPeriod = getAllPT_Period;
    this.inputType = inputTypePaymentType;    
}

function inputTypePaymentType(){    
    $('#form-payment-type').bootstrapValidator({
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
            },
            month: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    }
                }
            },
            total: {
                message: 'Invalid value',
                validators: {
                    notEmpty: {
                        message: 'Required'
                    },
                    digits: {
                        message: 'The value can contain only digits'
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        $('#form-payment-type').submit(function (event) {
            event.preventDefault();                
            var id_length = $('#form-payment-type input[name=payment_type_id]').val().split('').length;
            var finish_date = $('#form-payment-type input[name=finish_date]').val();
            var formData = new FormData($(this)[0]);                        
            if(finish_date === default_date){
                finish_date = null;
            }            
            
            formData.append('finish_date', finish_date);
            
            if (id_length>0) {                
                ajaxPro('POST', base_url+'payment_type/edit', formData, 'html', false, false, false, false, success, success, null);                          
            }else{                
                var d = new Date();         
                var education_id = '121'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                formData.append('payment_type_id', education_id);                        
                ajaxPro('POST', base_url+'payment_type/insert', formData, 'html', false, false, false, false, success, success, null);                          
            }
            function success(output) {            
                dt_payment_type.ajax.reload();
                $("#form-payment-type")[0].reset();
                $("#form-payment-type").bootstrapValidator('resetForm', true); 
                notify('info', output, null);
            }   
            return false;
        });    
    });               
}

function initPaymentTypeDT(){
    dt_payment_type = $('#dt-payment-type').DataTable({
        ajax : base_url+'/payment_type/getAll',
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
                "data" : "detail"
            }, {
                "data" : "month"
            }, {
                "data" : "period"
            }, {
                "data" : "education"
            }, {
                "data" : "total"
            }, {            
                "data" : "payment_status"
            }, {                
                "data" : "finish_date"
            }, {
                "data" : "payment_type_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getEditPaymentType(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getDeletePaymentType(this);"><i class="fa fa-trash-o"></i> Delete</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5  
    });  
}


function getAllPT_Education(){
    ajaxPro('POST', base_url+'education/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.education_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-payment-type select[name=education_id]').html(html);
    } 
}

function getAllPT_Period(){
    ajaxPro('POST', base_url+'/period/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.period_id+'">'+v.detail+'</option>'; 
        });        
        $('#form-payment-type select[name=period_id]').html(html);
    } 
}

function getEditPaymentType(i){
    var payment_type_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('payment_type_id', payment_type_id);     
    ajaxPro('POST', base_url+'/payment_type/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {                   
        $('#form-payment-type .form-group').each(function(i, v){
            var element_tag = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var element_name = $(this).children().eq('1').prop("name").toString().toLowerCase();    
//            var element = $(this).children().eq('1').prop("tagName").toString().toLowerCase();                        
//            var key = Object.keys(output.data)[i];            
//            var value = output.data[Object.keys(output.data)[i]];                        
            var key = Object.keys(output.data);                        
            $(key).each(function(j, w){                
                if(key[j]===element_name){
                    var value = output.data[key[j]];                    
                    $('#form-payment-type .form-group '+element_tag+'[name='+key[j]+']').val(value);                     
                    return false;
                }                          
            });        
//            $(this).find(element+'[name='+key+']').val(value);            
        });            
    } 
}

function getDeletePaymentType(i){
    var payment_type_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('payment_type_id', payment_type_id);                      
    ajaxPro('POST', base_url+'/payment_type/delete', formData, 'html', false, false, false, false, success, success, null);          
    function success(output) {   
        dt_payment_type.ajax.reload();
        notify('info', output, null);
    } 
}

function initPaymentTypeDRP(){
    $('#form-payment-type input[name=finish_date]').daterangepicker({        
        "singleDatePicker": true,
        "showDropdowns": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss ',
            cancelLabel:'Reset'
        }
    });
    $('#form-payment-type input[name=finish_date]').val(default_date);
    $('#form-payment-type input[name=finish_date]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val(default_date);
    });
}

function initPaymentTypeDP(){
    $('#form-payment-type input[name=period]').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
}
