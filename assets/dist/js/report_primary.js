var dt_report_primary = null;

function ReportPrimary(){
    this.initDT = initReportPrimaryDT;
    this.getClass = getReportPrimaryClass;
    this.getEducation = getReportPrimaryEducation;
    this.initDRP = initReportPrimaryDRP;
    this.resetField = resetReportPrimaryField;
    this.primaryFilter = primaryReportPrimaryFilter;
}

function initReportPrimaryDT(globalUsername){
   
    ajaxPro('GET', base_url+'report_primary/resources', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {
        // console.log(output);
        $('#dt-report-primary').append('<tfoot><tr><th colspan="'+(output.columnDefs.length-1)+'"><center>Total</center></th><th></th></tr></tfoot>');
        $('#dt-report-primary').DataTable({
            serverSide: true,
            processing: true,
            paging: true,
            ajax : base_url+'report_primary/resources2',       
            dom: 'Bfrtip', //B -> Button
            buttons: [
                {
                    text: '<i class="fa fa-filter"></i> Filter',
                    className: 'btn btn-default',
                    action: function ( e, dt, node, config ) {
                        $('#primary-report-filter').modal('show');
                    }
                },
                {
                    text: '<i class="fa fa-print"></i> Export excel',
                    className: 'btn btn-default',
                    action: function ( e, dt, node, config ) {                        
                      
                        var tempReport = [];
                        var d = new Date();    
                        var thead = $('#dt-report-primary thead').html();
                        var tbody = $('#dt-report-primary tbody').html();
                        var tfoot = $('#dt-report-primary tfoot').html();
                        tTotal = 0;     
                        lit = 0;     
                        litCuoun = 0;
                        var li = 0;
                        var tTotalBaru = 0;
                        var tCountBaru = 0;
                        var nisNew = [];
                        var paymentDate = [];
                        var groupClass = [];
                        var nUm = 0;
                       $(tbody).each(function(i, v){
                            var olah = $(v).find('td:eq(0)').html().toString().trim();
                            var olah1 = olah.indexOf(" ")+1;
                            var olah2 = olah.length;
                            var olah3 = olah.substr(olah1, olah2);
                            var  checkGroup = groupClass.indexOf(olah3);    
                            if (checkGroup < 0)
                            {
                                groupClass[nUm] = olah3; 
                            }
                            nUm++;
                        }); 
                        var groupClass = groupClass.filter(function(e){return e });
                        $(tbody).each(function(i, v){                            
                            nisNew[li] = $(v).find('td:eq(1)').html();
                            paymentDate[li] = $(v).find('td:eq(4)').html();
                            li++;
                        });
                        
                        var litHeader = 0;
                        var totalData = 0;
                        var cont = 0;
                        var totalBaruHead = {};
                        var countHeader = {};
                        var education = [];
                        $.each(output.data, function (i, cc){
                            var start   = cc.education.toString().toUpperCase().trim().indexOf(" ");
                            var end     = cc.education.toString().toUpperCase().trim().length;    
                            var str     = cc.education.toString().toUpperCase().trim().substr(start+1, end);
                            var  checkClasses = groupClass.indexOf(str);
                            var  checkDate = paymentDate.indexOf(cc.payment_date);
                            var  checkNis  = nisNew.indexOf(cc.nis);
                            
                            if (checkClasses >= 0 && checkDate >= 0 && checkNis >= 0){
                                
                                // grouping total
                                    if( totalBaruHead[str] !== undefined ) {
                                        var totalEdu = totalBaruHead[str];
                                            totalData  = totalEdu + cc.amount;
                                            // console.log(totalData+"--"+str);
                                    }else{
                                        totalData = cc.amount;
                                    }              
                                    if( countHeader[str] !== undefined ) {
                                        var totalCountEdu = countHeader[str] + 1;
                                        cont = totalCountEdu;
                                    }else{
                                         cont = 1;
                                    }                                    
                                    totalBaruHead[str] = totalData;
                                    countHeader[str] = cont;
                                  
                                // grouping total
                                    
                                    
                                // grouping pendidikan
                                var  checkClassExist  = education.indexOf(str);
                                if (litHeader == 0){
                                     education[litHeader] = str;                                
                                }else{
                                    if (checkClassExist < 0){
                                        education[litHeader] = str;
                                    }
                                }
                                litHeader++;
                            }
                        });
                        var education = education.filter(function(e){return e });
                        var totalKumulatif = 0;
                        // console.log(RE);
                        $(education).each(function (a, b){
                            if (b!== undefined){
                                $(totalBaruHead).each(function (a, f){  
                                   console.log(countHeader[b]);
                                   tempReport.push({
                                            'payment_type': 'PSB',
                                            'education' : b,
                                            'count':countHeader[b],
                                            'total':totalBaruHead[b]
                                        });    
                                    totalKumulatif += totalBaruHead[b];    
                                });
                            }
                        });
                        
                        tempReport.push({
                                    'payment_type': '',
                                    'education' : '',
                                    'count':"",
                                    'total':totalKumulatif
                                });
                      // detail
                        $.each(output.data, function (i, v){        
                            var  checkDate = paymentDate.indexOf(v.payment_date);
                            var  checkNis  = nisNew.indexOf(v.nis);
                            if (checkDate >= 0 && checkNis >= 0){
                                tTotalBaru += v.amount;
                                tCountBaru++;
                            }
                        });
                        
                        $.each(output.data, function (i, v){        
                            var  checkDate = paymentDate.indexOf(v.payment_date);
                            var  checkNis  = nisNew.indexOf(v.nis);
                            if (checkDate >= 0 && checkNis >= 0){
                                tempReport.push({
                                            'payment_type': v.name.replace("_", " "),
                                            'education': v.education,
                                            'count':"",
                                            'total':v.amount
                                });
                                tTotal += v.amount;
                            }
                        });
                        tempReport.push({
                            'payment_type': '',
                            'education':'',
                            'count':tCountBaru,
                            'total':tTotal
                        });
                        
                        
                        var dataNow = getDateJs();
                        var html = "";
                    // header
                        html += "<tr>";
                            html += "<th colspan='5' style='font-size:18px;border:1px solid black'>Laporan Pembayaran PSB Tanggal "+dataNow+"</th>";                          
                        html += "</tr>";
                        
                        html += "<tr>";
                            html += "<th colspan='5'></th>";                          
                        html += "</tr>";
                    // header
                    
                        html += "<tr style='border:2px solid black'>";
                            html += "<th style='border:1px solid black; font-size:16px'>Payment</th>";
                            html += "<th style='border:1px solid black; font-size:16px'>Education</th>";
                            html += "<th style='border:1px solid black; font-size:16px'>QTY</th>";
                            html += "<th style='border:1px solid black; font-size:16px'>Total</th>";
                        html += "</tr>";
                        
                        $(tempReport).each(function(j, w){  
                            if (w.education==="") {
                                html += "<tr style='border:2px solid black'>";
                                html += "<td colspan='3' style='border:1px solid black; font-size:16px'><center><b>Total</b></center></td>";                                
                                html += "<td style='border:1px solid black; font-size:16px'>"+w.total+"</td>";
                                html += "</tr>";                                                   
                            }else{
                                html += "<tr style='border:2px solid black'>";
                                html += "<td style='border:1px solid black; font-size:16px'>"+w.payment_type+"</td>";
                                html += "<td style='border:1px solid black; font-size:16px'>"+w.education+"</td>";
                                html += "<td style='border:1px solid black; font-size:16px'>"+w.count+"</td>";
                                html += "<td style='border:1px solid black; font-size:16px'>"+w.total+"</td>";
                                html += "</tr>";                                                   
                            }
                        });
                        
                        // footer
                            html += "<tr style='border:3px solid black'>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                            html += "</tr>";
                            
                            html += "<tr style='border:3px solid black'>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td style='font-size:16px'>Dibuat Oleh</td>";
                            html += "</tr>";     
                            
                            html += "<tr style='border:3px solid black'>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                            html += "</tr>";
                            
                            html += "<tr style='border:3px solid black'>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                            html += "</tr>";  
                            
                            html += "<tr style='border:3px solid black'>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td ></td>";
                                html += "<td style='font-size:16px'>"+globalUsername+"</td>";
                            html += "</tr>";   
                         
                        // footer
                        
                        
                        $('.table-print').html(html);
                        
                        
                        
                        //                        $('.table-print').html(thead+tbody+tfoot);
                        $("#table-print").table2excel({
                            exclude: ".table-print",
                            name: "Worksheet Name",
                            filename: "Primary Report "+ d.getFullYear() + concatString((d.getMonth() + 1)) + concatString(d.getDate()) + concatString(d.getHours()) + concatString(d.getMinutes()) + concatString(d.getSeconds()) //do not include extension
                        });                        
                    }
                }
            ],
            "columnDefs": output.columnDefs,
            columns : output.columns,
            drawCallback: function( settings ) {
                var api = this.api();            
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                    i : 0;
                };
                var total = api.column(output.columnDefs.length-1).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );           
                
                var pageTotal = api.column(output.columnDefs.length-1, { page: 'current'} ).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
                $('#dt-report-primary tfoot th:last-child').html(pageTotal); 
            },
            footerCallback: function ( row, data, start, end, display ) {            
                var api = this.api();            
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                    i : 0;
                };
                var total = api.column(output.columnDefs.length-1).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var pageTotal = api.column(output.columnDefs.length-1, { page: 'current'} ).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
                $('#dt-report-primary tfoot th:last-child').html(pageTotal); 
            },
            // pageLength : -1,
            order: []
        });                 
        
        $.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
            var min = new Date($('#form-primary-filter input[name=start_date]').val());
            var max = new Date($('#form-primary-filter input[name=finish_date]').val());
            var value = new Date(data[4]); // use data for the age column
            
            if ((isNaN(min) && isNaN(max)) || (isNaN(min) && value <= max ) || ( min <= value   && isNaN( max ) ) ||( min <= value   && value <= max ) ){
                return true;
            }
            return false;
        });   
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
function getReportPrimaryClass(element){
    ajaxPro('POST',base_url+'classes/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '<option value=""> - </option>';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.detail+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    } 
}

function getReportPrimaryEducation(element){
    ajaxPro('POST', base_url+'education/getAll', null, 'json', false, false, false, false, success, success, null);          
    function success(output) {                  
        var html = '<option value=""> - </option>';
        $(output.data).each(function(i, v){                        
            html += '<option value="'+v.detail+'">'+v.detail+'</option>'; 
        });        
        $(element).html(html);
    }  
}

function initReportPrimaryDRP(element){
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

function resetReportPrimaryField(trigger, target){
    $(trigger).click(function(){
        $(target).val('');
    });
}

function primaryReportPrimaryFilter(){
    $('#form-primary-filter').submit(function (event) {
        event.preventDefault();                    
        var education = $('#form-primary-filter select[name=education]').val();
        var classes = $('#form-primary-filter select[name=class]').val();
        var status = $('#form-primary-filter select[name=status]').val();
        dt_report_primary.column(0).search(education);
        dt_report_primary.column(3).search(classes);
        dt_report_primary.column(7).search(status);         
        dt_report_primary.draw();
        dt_report_primary.ajax.reload();
        $('#primary-report-filter').modal('hide');
        return false;
    });   
}


function concatString(val) {
    if (val.toString().length === 1) {
        val = '0' + val;
    }
    return val;
}