var dt_payment = null;

function Payment(){
    this.initDT = initPaymentDT;
    this.inputType = inputTypePayment;
    this.inputTypePrimary = inputTypePrimaryPayment;
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

function initPaymentDT(){    
    //    alert($('#student_id').html());
    
    dt_payment = $('#dt-payment').DataTable({
            // ajax : base_url+'/student/getPayment?student_id='+$('#student_id').html(),
          ajax : {
                    'url' : base_url+'student/getPayment',
                    'type' : 'get',
                    'data' : function (d){
                        d.student_id = $('#student_id').html();
                        d.payment_status = $('.update-data-btn').attr('value');
                    }
                },
        dom: 'Bfrtip', //B -> Button
        buttons: [
            {
                text: '<i class="fa fa-arrow-left"></i> Back',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    window.location.href = "/l-fis/student";         
                }
            },
            {
                text: '<i class="fa fa-history"></i> All',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {                    
                    dt.column(1).search('');
                    dt.ajax.reload();
                }
            },
            {
                text: '<i class="fa fa-th-list"></i> PSB',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    $('.update-data-btn').text('Update Primary');
                    $('.update-data-btn').attr('value', 1);
                    dt.column(1).search('Primary');
                    dt.ajax.reload();
                }
            },
            {
                text: '<i class="fa fa-list"></i> SPP',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    $('.update-data-btn').text('Update Other');
                    $('.update-data-btn').attr('value', 0);
                    dt.column(1).search('Other');
                    dt.ajax.reload();
                }
            },
            {
                text: '<i class="fa fa-pencil-square-o"></i> <span class="update-data-btn" value="1">Update PSB</span>',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) { 
                    var formData = new FormData();        
                    formData.append('student_id', $('#student_id').html());   
                    formData.append('payment_status', $('.update-data-btn').attr('value'));   
                    ajaxPro('POST', base_url+'student/getSelectedPrimaryPayment', formData, 'json', false, false, false, false, success, success, null);          
                    function success(output) {
                        $('#form-primary-payment .form-group').each(function(i, v){
                            var element_tag = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
                            var element_name = $(this).children().eq('1').prop("name").toString().toLowerCase();                        
                            var key = Object.keys(output.data);                    
                            $(key).each(function(j, w){
                                if(key[j]===element_name){
                                    var value = output.data[key[j]];       
                                    $('#form-primary-payment .form-group '+element_tag+'[name='+key[j]+']').val(value);                     
                                    return false;
                                }                                
                            }); 
                            
                        });             
                    }     
                    $('#primary-payment-student-modal').modal('show');
                    //                    dt.column(1).search('Other');
                    //                    dt.ajax.reload();
                      $('#form-primary-payment input[name=payment_date]').daterangepicker({ 
                        "drops": "up",
                        "singleDatePicker": true,   
                        "timePicker": true,                        
                        locale: {
                            format: 'YYYY-MM-DD hh:mm:ss',
                            cancelLabel:'Reset'
                        }
                    });
                }
            }
        ],
        columns : [
            {
                "data" : "detail"
            },{
                "data" : "payment_status"
            },{
                "data" : "total"
            }, {
                "data" : "total_payment"
            }, {
                "data" : "payment_date"
            }, {
                "data" : "payment_type_id",
                "render" : function (data, type, row) {		
                 
                    var html = '<center><div class="btn-group">';
                    if(row.remain==0){
                        html += '<button type="button" class="detail btn btn-primary" value="' + data + '" onclick="getUpdatePayment(this);" disabled><i class="fa fa-pencil-square-o" ></i> Update</button>';
                    }else{
                        html += '<button type="button" class="detail btn btn-primary" value="' + data + '" onclick="getUpdatePayment(this);"><i class="fa fa-pencil-square-o"></i> Update</button>';
                    }
                    
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getRevisionPayment(this);"><i class="fa fa-wrench"></i> Revision</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getPrintPayment(this);"><i class="fa fa-print"></i> Print</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if(aData.remain == 0){
                $('td', nRow).css('background-color', '#53DF83');
                $('td', nRow).css('color', '#ffffff');
                 
            }             
        },
        "ordering": false,
        //        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 10
    });          
}

function getRevisionPayment(i){
    var payment_type_id = $(i).val();
    var student_id = $('#student_id').html();
    
    var form = document.createElement('form');
    form.action = base_url+'/payment_revision';
    form.method = 'post';
    
    var input1 = document.createElement('input');
    input1.type = 'hidden';
    input1.name = 'student_id';
    input1.value = student_id;    
    
    var input2 = document.createElement('input');
    input2.type = 'hidden';
    input2.name = 'payment_type_id';
    input2.value = payment_type_id;
    
    form.appendChild(input1);
    form.appendChild(input2);
    
    form.submit();
}

function getPrintPayment(i){
     var payment_type_id = $(i).val();
    var student_id = $('#student_id').html();
    
    // var form = document.createElement('form');
    // form.action = '/l-fis/payment_print';
    // form.method = 'post';
    
    // var input1 = document.createElement('input');
    // input1.type = 'hidden';
    // input1.name = 'student_id';
    // input1.value = student_id;    
    
    // var input2 = document.createElement('input');
    // input2.type = 'hidden';
    // input2.name = 'payment_type_id';
    // input2.value = payment_type_id;
    
    // form.appendChild(input1);
    // form.appendChild(input2);
    
    // form.submit();
    
     var jForm = $('<form></form>', {
        action: base_url+'/payment_print',
        method: 'post'
    });

    $("<input>", {
        name: 'student_id',
        value: student_id,
        type: 'hidden'
    }).appendTo(jForm);
    
    $("<input>", {
        name: 'payment_type_id',
        value: payment_type_id,
        type: 'hidden'
    }).appendTo(jForm);

    jForm.appendTo('body').submit();
    
}

function getUpdatePayment(i){
    var payment_type_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('student_id', $('#student_id').html());                        
    formData.append('payment_type_id', payment_type_id);                        
    ajaxPro('POST', base_url+'student/getSelectedPayment', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {           
        $('#form-payment .form-group').each(function(i, v){
            var element_tag = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var element_name = $(this).children().eq('1').prop("name").toString().toLowerCase();                        
            var key = Object.keys(output.data);                        
            $(key).each(function(j, w){
                if(key[j]===element_name){
                    var value = output.data[key[j]];                    
                    $('#form-payment .form-group '+element_tag+'[name='+key[j]+']').val(value);                     
                    return false;
                }                                
            });                 
        });             
            
	$('#form-payment input[name=payment_date]').daterangepicker({ 
                        "drops": "up",
                        "singleDatePicker": true,   
                        "timePicker": true,                        
                        locale: {
                            format: 'YYYY-MM-DD hh:mm:ss',
                            cancelLabel:'Reset'
                        }
        });
} 	
    $('#payment-student-modal').modal('show');
}

function inputTypePrimaryPayment(){    
    $('#form-primary-payment').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {    
            total:{
                validators: {
                    callback: {
                        message: 'Input out of the range',
                        callback: function(value, validator) {
                            var invoice = validator.getFieldElements('invoice').val();
                            var total_payment = validator.getFieldElements('total_payment').val();                            
                            var input = true;                            
                            if((parseInt(value) < 0) || (parseInt(value) > (invoice - total_payment))) input = false;                            
                            return input;
                        }
                    }
                }                                
            }          
        }
    }).on('success.form.bv', function (e) {
        $('#form-primary-payment').submit(function (event) {
            event.preventDefault();                 
            var formData = new FormData($(this)[0]);                
            formData.append('student_id', $('#student_id').html());
            formData.append('payment_status', $('.update-data-btn').attr('value'));   
            ajaxPro('POST', base_url+'/student/getSelectedPrimaryPayment2', formData, 'json', false, false, false, false, success, success, null);          
            function success(output){ 
                var d = new Date();
                var total = $('#form-primary-payment input[name=total]').val();               
                var payment_group = '1222'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + (Math.floor(Math.random() * (9999999999 - 1000000000) + 1000000000));
               $(output.data).each(function(i, v){                                        
                    if((v.remain > 0) && (total > 0)){             
                        var tempTotal = total - v.remain;
                        var payment_id = '120'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                        formData.append('payment_id', payment_id);
                        formData.append('payment_group', payment_group);
                        formData.append('payment_type_id', v.payment_type_id);                         
                        if(tempTotal >= 0){                          
                            formData.append('total', v.remain);     
                            ajaxPro('POST', base_url+'/payment/insert', formData, 'json', false, false, false, false, null, null, null);
                            total = tempTotal;
                        }else{                            
                            formData.append('total', total);                            
                            ajaxPro('POST', base_url+'/payment/insert', formData, 'json', false, false, false, false, null, null, null);
                            total = 0;
                        }                        
                        //                        alert(v.payment_type_id);
                    }                    
                    
                });  
                $('#form-primary-payment')[0].reset();
                $('#form-primary-payment').bootstrapValidator('resetForm', true);                 
                $('#primary-payment-student-modal').modal('hide');
                dt_payment.ajax.reload();
                
            }      
            
            return false;
        });    
    });               
}

function inputTypePayment(){    
    $('#form-payment').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {    
            total:{
                validators: {
                    callback: {
                        message: 'Input out of the range',
                        callback: function(value, validator) {
                            var invoice = $('#form-payment input[name=invoice]').val();
                            var total_payment = $('#form-payment input[name=total_payment]').val();                            
                            var input = true;
                            if((parseInt(value) < 0) || (parseInt(value) > (invoice - total_payment))) input = false;                            
                            return input;
                        }
                    }
                }                                
            }          
        }
    }).on('success.form.bv', function (e) {
        $('#form-payment').submit(function (event) {
            event.preventDefault();                            
            var formData = new FormData($(this)[0]);                
            var d = new Date();                 
            var payment_id = '120'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
            var payment_group = '1222'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + (Math.floor(Math.random() * (9999999999 - 1000000000) + 1000000000));    
            formData.append('payment_id', payment_id);                        
            formData.append('payment_group', payment_group);              
            ajaxPro('POST', base_url+'/payment/insert', formData, 'html', false, false, false, false, success, success, null);          
            function success(output) {            
                dt_payment.ajax.reload();
                $("#form-payment")[0].reset();
                $("#form-payment").bootstrapValidator('resetForm', true); 
                $('#payment-student-modal').modal('hide');
                notify('info', output, null);                                
            }   
            return false;
        });    
    });               
}
