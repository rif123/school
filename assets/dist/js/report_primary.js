var dt_report_primary = null;
var oTable = null;
var url  = base_url+'report_primary/resourcesAllMerge';
var urlExcel = base_url+'report_primary/resourceExportExcel';
function ReportPrimary(){
    this.initDT = initReportPrimaryDT;
    this.getClass = getReportPrimaryClass;
    this.getEducation = getReportPrimaryEducation;
    this.initDRP = initReportPrimaryDRP;
    this.resetField = resetReportPrimaryField;
    this.primaryFilter = primaryReportPrimaryFilter;
}

function initReportPrimaryDT(globalUsername){
    var url = base_url+'report_primary/resourcesAllMerge';

        oTable = $('#dt-report-primary').dataTable({
            "processing": true,
            "serverSide": true,
            dom: 'Bfrtip', //B -> Button
            "buttons": [
                        {
                            text: '<i class="fa fa-filter"></i> Filter',
                            className: 'btn btn-default',
                            action: function ( e, dt, node, config ) {
                                $('#primary-report-filter').modal('show');
                            }
                        },
                        {
                            text: '<i class="fa fa-print"></i> Export excel',
                            className: 'btn btn-default customerSearchButton',
                            action: function ( e, dt, node, config ) {
                                exportExcel();
                            }
                        }
            ],
            "ajax": url,
            "order": [[1, 'asc']]
        });
}
function exportExcel(){
        window.location = urlExcel;
}
function primaryReportPrimaryFilter(){
    $('#form-primary-filter').submit(function (event) {
        event.preventDefault();
        var education = $('#form-primary-filter select[name=education]').val();
        var classes = $('#form-primary-filter select[name=class]').val();
        var status = $('#form-primary-filter select[name=status]').val();
        var start_date = $('#form-primary-filter input[name=start_date]').val();
        var end_date = $('#form-primary-filter input[name=finish_date]').val();

        var url = base_url+'report_primary/resourcesAllMerge';
            oTable = $('#dt-report-primary').dataTable({
                "processing": true,
                "serverSide": true,
                "bDestroy": true,
                dom: 'Bfrtip', //B -> Button
                "buttons": [
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

                                }
                            }
                ],
                ajax:{
                       url: url, // Change this URL to where your json data comes from
                       type: "GET", // This is the default value, could also be POST, or anything you want.
                       data: function(d) {
                           d.education = education;
                           d.class = classes;
                           d.status = status;
                           d.end_date = end_date;
                           d.start_date = start_date;
                       }

                  },
                "order": [[1, 'asc']]
            });
        // oTable.ajax.reload();
        // oTable.column(0).search(education);
        // oTable.draw();
        // oTable.ajax.reload();
        // dt_report_primary.column(3).search(classes);
        // dt_report_primary.column(7).search(status);
        // dt_report_primary.draw();
        // dt_report_primary.ajax.reload();
        $('#primary-report-filter').modal('hide');
        return false;
    });
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
    ajaxPro('POST', base_url+'education/getAllNew', null, 'json', false, false, false, false, success, success, null);
    function success(output) {
        var html = '<option value=""> - </option>';
        $(output.data).each(function(i, v){
            html += '<option value="'+v.nameEdu+'">'+v.nameEdu+'</option>';
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




function concatString(val) {
    if (val.toString().length === 1) {
        val = '0' + val;
    }
    return val;
}
