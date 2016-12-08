/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Sidebar(){
    this.initSd = getMenuBySession;
    this.initUsername = getUsername;
}

function getMenuBySession(){    
    var formData = new FormData();        
    formData.append('detail', 'Sidebar'); 
    ajaxPro('POST', base_url+'menu/getByIdType', formData, 'JSON', false, false, false, false, success, success, null);     
    function success(output) {           
        var html = '';
        $(output.data).each(function(i, v){
            html += '<li>';
            html += '<a href="'+base_url+"/"+v.controller+'">';
            html += '<i class="'+v.icon+'"></i> <span>'+v.detail+'</span>';
            html += '</a>';
            html += '</li>';
        });
        $('#sidebar-menu').html(html);
    } 
}

function getUsername(){            
    ajaxPro('POST', base_url+'staff/getBySession', null, 'JSON', false, false, false, false, success, success, null);     
    function success(output) {           
        var html = '';
        html += '<img src="'+output.data.photo+'" class="user-image" alt="User Image">';
        html += '<span class="hidden-xs">'+output.data.username+'</span>';
        $('#user-login').html(html);
    } 
}