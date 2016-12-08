var dt_payment_revision = null;

function PaymentRevision(){
    this.initDT = initPaymentRevisionDT;
    this.initDRP = initPRDRP;
    this.inputType = inputTypePaymentRevision;
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

function initPaymentRevisionDT(){    
    dt_payment_revision = $('#dt-payment-revision').DataTable({
        ajax : base_url+'payment/getSelectedPayment?student_id='+$('#student_id').html()+'&payment_type_id='+$('#payment_type_id').html(),
        dom: 'Bfrtip', //B -> Button
        buttons: [
            {
                text: '<i class="fa fa-arrow-left"></i> Back',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    var student_id = $('#student_id').html();                       
                    var form = document.createElement('form');
                    form.action = '/l-fis/payment';
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
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getUpdatePaymentRevision(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        //        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 10
    });          
}

function getUpdatePaymentRevision(i){
    var payment_id = $(i).val();
    var formData = new FormData($(this)[0]);            
    formData.append('payment_id', payment_id);                        
    ajaxPro('POST', base_url+'/payment/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {           
        $('#form-payment-revision .form-group').each(function(i, v){
            var element_tag = $(this).children().eq('1').prop("tagName").toString().toLowerCase();            
            var element_name = $(this).children().eq('1').prop("name").toString().toLowerCase();                        
            var key = Object.keys(output.data);                        
            $(key).each(function(j, w){
                if(key[j]===element_name){
                    var value = output.data[key[j]];                    
                    $('#form-payment-revision .form-group '+element_tag+'[name='+key[j]+']').val(value);                     
                    return false;
                }                                
            });                 
        });             
    }     
    $('#payment-revision-modal').modal('show');
}

function inputTypePaymentRevision(){    
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
            ajaxPro('POST', '/l-fis/payment/edit', formData, 'html', false, false, false, false, success, success, null);          
            function success(output) {            
                dt_payment_revision.ajax.reload();
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
        "drops": "down",
        locale: {
            format: 'YYYY-MM-DD H:mm:ss',
            cancelLabel:'Reset'
        }
    });  
}
