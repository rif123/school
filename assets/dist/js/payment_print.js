var dt_payment_print = null;

function PaymentPrint(){
    this.initDT = initPaymentPrintDT;
    this.initDRP = initPRDRP;
    this.inputType = inputTypePaymentPrint;
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

function initPaymentPrintDT(){    
    dt_payment_print = $('#dt-payment-revision').DataTable({
        ajax : base_url+'payment/getSelectedPayment?student_id='+$('#student_id').html()+'&payment_type_id='+$('#payment_type_id').html(),
        dom: 'Bfrtip', //B -> Button
        buttons: [
            {
                text: '<i class="fa fa-arrow-left"></i> Back',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    var student_id = $('#student_id').html();                       
                    var form = document.createElement('form');
                    form.action = base_url+'payment';
                    form.method = 'post';
    
                    var input1 = document.createElement('input');
                    input1.type = 'hidden';
                    input1.name = 'student_id';
                    input1.value = student_id;        
    
                    form.appendChild(input1);
                    form.submit();           
                }
            }
        ],
        columns : [
            {
                "data" : "total"
            }, {
                "data" : "payment_date"
            }, {
                "data" : "payment_id",
                "render" : function (data, type, row) {		                 
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getUpdatePaymentPrint(this);"><i class="fa fa-print"></i> Print</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        //        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 10
    });          
}

function getUpdatePaymentPrint(i){
    var payment_id = $(i).val();    
    // var form = document.createElement('form');
    // form.action = base_url+'payment_print/print_report';    
    // form.target = '_blank';    
    // form.method = 'post';
    
    // var input = document.createElement('input');
    // input.type = 'hidden';
    // input.name = 'payment_id';
    // input.value = payment_id;    
    // form.appendChild(input);    
    // form.submit();
    
    var jForm = $('<form></form>', {
        action: base_url+'payment_print/print_report',
        method: 'post',
        target:'_blank'
    });

    $("<input>", {
        name: 'payment_id',
        value: payment_id,
        type: 'hidden'
    }).appendTo(jForm);

    jForm.appendTo('body').submit();
    
}

function inputTypePaymentPrint(){    
    $('#form-payment-revision').bootstrapValidator({
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
                            if(parseInt(value) < 0) input = false;                            
                            return input;
                        }
                    }
                }                                
            }          
        }
    }).on('success.form.bv', function (e) {
        $('#form-payment-revision').submit(function (event) {
            event.preventDefault();                            
            var formData = new FormData($(this)[0]);                
            var d = new Date();     
            ajaxPro('POST', base_url+'payment/edit', formData, 'html', false, false, false, false, success, success, null);          
            function success(output) {            
                dt_payment_print.ajax.reload();
                $("#form-payment-revision")[0].reset();
                $("#form-payment-revision").bootstrapValidator('resetForm', true); 
                $('#payment-revision-modal').modal('hide');
                notify('info', output, null);                                
            }   
            return false;
        });    
    });               
}

function initPRDRP(){
    $('#form-payment-revision input[name=payment_date]').daterangepicker({        
        "singleDatePicker": true,
        "showDropdowns": true, 
        "timePicker": true,
        "timePickerSeconds": true,
        "timePicker24Hour": true,
        "drops": "up",
        locale: {
            format: 'YYYY-MM-DD H:mm:ss',
            cancelLabel:'Reset'
        }
    });  
}
