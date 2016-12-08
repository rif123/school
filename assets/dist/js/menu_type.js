var default_date = '0000-00-00 00:00:00';
var dt_menu_type = null;
function Menu_Type(){
    this.initDT = initMenuTypeDT;    
    this.inputType = inputTypeMenuType;
}

function inputTypeMenuType(){    
    $('#form-menu-type').bootstrapValidator({
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
        $('#form-menu-type').submit(function (event) {
            event.preventDefault();                
            var id_length = $('#form-menu-type input[name=menu_type_id]').val().split('').length;            
            var formData = new FormData($(this)[0]);                        
            if (id_length>0) {                
                ajaxPro('POST', '/l-fis/menu_type/edit', formData, 'html', false, false, false, false, success, success, null);                          
            }else{                
                var d = new Date();         
                var education_id = '128'+d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) + (Math.floor(Math.random() * (99 - 10) + 10));    
                formData.append('menu_type_id', education_id);                        
                ajaxPro('POST', '/l-fis/menu_type/insert', formData, 'html', false, false, false, false, success, success, null);                          
            }
            function success(output) {            
                dt_menu_type.ajax.reload();
                $("#form-menu-type")[0].reset();
                $("#form-menu-type").bootstrapValidator('resetForm', true); 
                notify('info', output, null);
            }   
            return false;
        });    
    });               
}

function initMenuTypeDT(){
    dt_menu_type = $('#dt-menu-type').DataTable({
        ajax : '../l-fis/menu_type/getAll',
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
                "data" : "menu_type_id",
                "render" : function (data, type, row) {						                    
                    var html = '<center><div class="btn-group">';
                    html += '<button type="button" class="detail btn btn-warning" value="' + data + '" onclick="getEditMenuType(this);"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    html += '<button type="button" class="detail btn btn-danger" value="' + data + '" onclick="getDeleteMenuType(this);"><i class="fa fa-trash-o"></i> Delete</button>';
                    html += '</div></center>';
                    return html;
                }
            }
        ],
        aLengthMenu : [[5, 10, -1], [5, 10, "All"]],
        pageLength : 5  
    });  
}

function getEditMenuType(i){
    var menu_type_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('menu_type_id', menu_type_id);     
    ajaxPro('POST', '/l-fis/menu_type/getById', formData, 'json', false, false, false, false, success, success, null);          
    function success(output) {           
        $('#form-menu-type .form-group').each(function(i, v){
            var element = $(this).children().eq('1').prop("tagName").toString().toLowerCase();                        
            var key = Object.keys(output.data)[i];            
            var value = output.data[Object.keys(output.data)[i]];                        
            $(this).find(element+'[name='+key+']').val(value);            
        });            
    } 
}

function getDeleteMenuType(i){
    var menu_type_id = $(i).val();
    var formData = new FormData($(this)[0]);        
    formData.append('menu_type_id', menu_type_id);                      
    ajaxPro('POST', '/l-fis/menu_type/delete', formData, 'html', false, false, false, false, success, success, null);          
    function success(output) {   
        dt_menu_type.ajax.reload();
        notify('info', output, null);
    } 
}

function initMenuTypeDRP(){
    $('#form-menu-type input[name=finish_date]').daterangepicker({        
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
    $('#form-menu-type input[name=finish_date]').val(default_date);
    $('#form-menu-type input[name=finish_date]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val(default_date);
    });
}
