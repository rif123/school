var dt_report = null;

function Report(){
    this.initDT = initReportDT;
    this.getClass = getReportClass;
    this.getEducation = getReportEducation;
    this.getPaymentType = getReportPaymentType;
    this.initDRP = initReportDRP;
    this.resetField = resetReportField;
    this.otherFilter = otherReportFilter;
}

function initReportDT(globalUsername){  
    $('#dt-report').append('<tfoot><tr><th colspan="8"><center>Total</center></th><th></th></tr></tfoot>');
    dt_report = $('#dt-report').DataTable({
        ajax : base_url+'report/getOther',       
        dom: 'Bfrtip', //B -> Button
        buttons: [
            {
                text: '<i class="fa fa-filter"></i> Filter',
                className: 'btn btn-default',
                action: function ( e, dt, node, config ) {
                    $('#other-report-filter').modal('show');
                }
            },
            {
                text: '<i class="fa fa-print"></i> Export excel',
                className: 'btn btn-default',                
                action: function ( e, dt, node, config ) {    
                    var tempReport = [];
                    var d = new Date();    
                    var thead = $('#dt-report thead').html();
                    var tbody = $('#dt-report tbody').html();
                    var tfoot = $('#dt-report tfoot').html();
                        
                    $(tbody).each(function(i, v){
                        var find = false;
                        $(tempReport).each(function(j, w){
                            if($(v).find('td:eq(0)').html().toString().trim().toUpperCase() === w.education.toString().trim().toUpperCase()){
                                find = true;
                                return false;
                            }
                        });
                            
                        if (find===false) {
                            tempReport.push({
                                'payment_type': 'Lain-lain',
                                'education':$(v).find('td:eq(0)').html().trim().toUpperCase(),
                                'count':0,
                                'total':0
                            });
                        }                            
                        //                            console.log($(v).find('td:eq(0)').html());
                    });
                    
                    $(tbody).each(function(i, v){
                        var tdMaxIndex = $(v).find("td").length-1;                                                                                    
                        $(tempReport).each(function(j, w){                               
                            if($(v).find('td:eq(0)').html().toString().trim().toUpperCase() === w.education.toString().trim().toUpperCase()){
                                w['count'] += 1;
                                w['total'] += parseInt($(v).find('td:eq('+tdMaxIndex+')').html().toString().trim());                                    
                                return false;                                    
                            }                                
                        });
                    });
                    
                    var tCount = 0;
                    var tTotal = 0;
                        
                    $(tempReport).each(function(j, w){                               
                        tCount += w.count;
                        tTotal += w.total;                            
                    });
                        
                    tempReport.push({
                        'payment_type': '',
                        'education':'',
                        'count':tCount,
                        'total':tTotal
                    });
                    
                    tTotal = 0;                
                    $(tbody).each(function(i, v){                            
                        tempReport.push({
                                'payment_type': $(v).find('td:eq(5)').html(),
                                'education': $(v).find('td:eq(3)').html(),
                                'count':$(v).find('td:eq(0)').html(),
                                'total':parseInt($(v).find('td:eq(6)').html())
                            });
                            tTotal += parseInt($(v).find('td:eq(6)').html());                           
                    });
                    
                    tempReport.push({
                        'payment_type': '',
                        'education':'',
                        'count':tCount,
                        'total':tTotal
                    });
                        
                    $(tempReport).each(function(j, w){                               
                        //console.log(w);
                    });
                    var dataNow = getDateJs();
                    var html = "";
                    
                     // header
                        html += "<tr>";
                            html += "<th colspan='5' style='font-size:18px;'>Laporan Pembayaran SPP  Tanggal "+dataNow+"</th>";                          
                        html += "</tr>";
                        
                        html += "<tr>";
                            html += "<th colspan='5'></th>";                          
                        html += "</tr>";
                    // header
                    
                    html += "<tr>";
                    html += "<th style='border:1px solid black; font-size:16px'>Payment</th>";
                    html += "<th style='border:1px solid black; font-size:16px'>Education</th>";
                    html += "<th style='border:1px solid black; font-size:16px'>QTY</th>";
                    html += "<th style='border:1px solid black; font-size:16px'>Total</th>";
                    html += "</tr>";
                    $(tempReport).each(function(j, w){  
                        if (w.education==="") {
                            html += "<tr>";
                            html += "<td colspan='3' style='border:1px solid black; font-size:16px'><center><b>Total</b></center></td>";                                
                            html += "<td style='border:1px solid black; font-size:16px'>"+w.total+"</td>";
                            html += "</tr>";                                                   
                        }else{
                            html += "<tr>";
                            html += "<td style='border:1px solid black; font-size:16px'>"+w.payment_type+"</td>";
                            html += "<td style='border:1px solid black; font-size:16px'>"+w.education+"</td>";
                            html += "<td style='border:1px solid black; font-size:16px'>"+w.count+"</td>";
                            html += "<td style='border:1px solid black; font-size:16px'>"+w.total+"</td>";
                            html += "</tr>";                                                   
                        }
                    });
                    
                    
                     // footer
                            html += "<tr>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                            html += "</tr>";
                            
                            html += "<tr>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td>Dibuat Oleh</td>";
                            html += "</tr>";     
                            
                            html += "<tr>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                            html += "</tr>";
                            
                            html += "<tr>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                            html += "</tr>";  
                            
                            html += "<tr>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td></td>";
                                html += "<td>"+globalUsername+"</td>";
                            html += "</tr>";   
                         
                        // footer
                        
                        
                    $('.table-print').html(html);
                    //                        $('.table-print').html(thead+tbody+tfoot);
                    $("#table-print").table2excel({
                        exclude: ".table-print",
                        name: "Worksheet Name",
                        filename: "Other Report "+ d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) //do not include extension
                    });                        
                }
                //                extend: 'csv',
                //                exportOptions: {
                //                    modifier: {
                //                        page: 'current'
                //                    }
                //                }
            }
        ],
        "columnDefs": [
            { "title": "Education", "targets": 0, "visible": true },
            { "title": "Class", "targets": 1, "visible": true },
            { "title": "NIS", "targets": 2, "visible": true },
            { "title": "Name", "targets": 3, "visible": true },
            { "title": "Address", "targets": 4, "visible": true },
            { "title": "Payment Type", "targets": 5,  "visible": true },
            { "title": "Payment Date", "targets": 6,  "visible": false },
            { "title": "Payment Status", "targets": 7,  "visible": false },
            { "title": "Amount", "targets": 8, "visible": true }
        ],
        columns : [{
                "data" : "education_detail"
            },{
                "data" : "class_detail"
            },{
                "data" : "nis"
            }, {
                "data" : "name"
            }, {
                "data" : "address"
            }, {
                "data" : "payment_type_detail"
            }, {
                "data" : "pmt_date"            
            }, {
                "data" : "pmt_status"            
            }, {
                "data" : "payment_total"
            }
        ],
        drawCallback: function( settings ) {
            var api = this.api();            
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                i : 0;
            };
            var total = api.column(8).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );           
            
            var pageTotal = api.column(8, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
            $('#dt-report tfoot th:last-child').html(pageTotal); 
        },
        footerCallback: function ( row, data, start, end, display ) {            
            var api = this.api();            
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                i : 0;
            };
            var total = api.column(8).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            var pageTotal = api.column(8, { page: 'current'} ).data().reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
            
            $('#dt-report tfoot th:last-child').html(pageTotal); 
        },
        pageLength : -1,
        order: [[ 8, 'asc' ]]
    });                 
    
    $.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
        var min = new Date($('#form-other-filter input[name=start_date]').val());
        var max = new Date($('#form-other-filter input[name=finish_date]').val());
        var value = new Date(data[6]); // use data for the age column
 
        if ((isNaN(min) && isNaN(max)) || (isNaN(min) && value <= max ) || ( min <= value   && isNaN( max ) ) ||( min <= value   && value <= max ) ){
            return true;
        }
        return false;
    });    
}

function getReportClass(element){
    ajaxPro('POST', base_url+'classes/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '<option value=""> - </option>';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.detail+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    } 
}

function getDateJs(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    } 

    if(mm<10) {
        mm='0'+mm
    } 

    today = dd+'-'+mm+'-'+yyyy;
    return today;
}

function getReportEducation(element){
    ajaxPro('POST', base_url+'education/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '<option value=""> - </option>';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.detail+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    }  
}

function getReportPaymentType(element){
    ajaxPro('POST', base_url+'payment_type/getAllGrouped', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '<option value=""> - </option>';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.detail+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    }  
}

function initReportDRP(element){
    $(element).daterangepicker({        
        "singleDatePicker": true,
        "showDropdowns": true,        
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel:'Reset'
        }
    });
    $(element).val('');
}

function resetReportField(trigger, target){
    $(trigger).click(function(){
        $(target).val('');
    });
}

function otherReportFilter(){
    $('#form-other-filter').submit(function (event) {
        event.preventDefault();                    
        var education = $('#form-other-filter select[name=education]').val();
        var classes = $('#form-other-filter select[name=class]').val();
        var status = $('#form-other-filter select[name=status]').val();
        var payment_type = $('#form-other-filter select[name=payment_type]').val();
        dt_report.column(0).search(education);
        dt_report.column(1).search(classes);
        dt_report.column(5).search(payment_type);
        dt_report.column(7).search(status);         
        dt_report.draw();
        dt_report.ajax.reload();
        $('#other-report-filter').modal('hide');
        return false;
    });   
}
