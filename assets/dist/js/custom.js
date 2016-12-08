function Custom(){
    this.ajaxPro = ajaxPro;    
    this.concatString = concatString;    
    this.notify = notify;    
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
        }
        //        onShow: null,
        //        onShown: null,
        //        onClose: null,
        //        onClosed: null,
        //        icon_type: 'class',
        //        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        //    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        //    '<span data-notify="icon"></span> ' +
        //    '<span data-notify="title">{1}</span> ' +
        //    '<span data-notify="message">{2}</span>' +
        //    '<div class="progress" data-notify="progressbar">' +
        //    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        //    '</div>' +
        //    '<a href="{3}" target="{4}" data-notify="url"></a>' +
        //    '</div>'
    });
}
