
// toastr.options = {
//     "closeButton": false,
//     "debug": false,
//     "newestOnTop": false,
//     "progressBar": false,
//     "positionClass": "toast-top-right",
//     "preventDuplicates": false,
//     "onclick": null,
//     "showDuration": "300",
//     "hideDuration": "1000",
//     "timeOut": "5000",
//     "extendedTimeOut": "1000",
//     "showEasing": "swing",
//     "hideEasing": "linear",
//     "showMethod": "fadeIn",
//     "hideMethod": "fadeOut"
//   }



//Ckeditor
window.editors = {};


window.editors = {};

document.querySelectorAll( '.editor' ).forEach( ( node, index ) => {
    ClassicEditor
        .create( node, {} )
        .then( newEditor => {
            window.editors[ index ] = newEditor 
        } );
} );

var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const axiosInstance = axios.create({
    headers: {
        'X-CSRF-TOKEN': token
    }
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': token
    }
});

window.dTable = null;


function get_query(){
    var url = location.search;
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}

function pageLoader(status = 1, text = 'Loading...') {
    if (status == 0) {
        $("#pageLoader").fadeOut(200, function () {
            $(this).remove();
        });
    } else {
        if ($("#pageLoader").length == 0) {
            $("body").append("<div id='pageLoader' style='position:fixed;top:0;left:0;width:100%;height:100%;z-index:999999999;background: rgba(0,0,0,0.4);'><div style='width: 120px; height: 40px; position: absolute; top: 0px; bottom: 0px; left: 0px; right: 0px; margin: auto; background: none repeat scroll 0% 0% rgb(238, 238, 238); text-align: center; line-height: 38px; border: 1px solid rgb(221, 221, 221); vertical-align: middle; border-radius: 5px ! important; color: rgb(131, 131, 131);'><i class='fa fa-spinner fa-spin'></i> " + text + "</div></div>");
            $("body>div:last").hide().fadeIn(200);
        }
    }
    setTimeout(function (e) {
        $("#pageLoader").fadeOut(200, function () {
            $(this).remove();
        });
    }, 30000);
}

function preloader(param) {
    $(document).find("#preloader")
    if (param) {
        $(document).find("#preloader").hide();
    }
}

function dTReload(){
    window.dTable.ajax.reload();

}

function basicAlert(html,type='error') {
    Swal.fire({html:html, icon:type});
}


function printData(divToPrint)
{
//    var divToPrint = document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}


function get_hours(){
    let unix_timestamp = Date.now();
    // Create a new JavaScript Date object based on the timestamp
    // multiplied by 1000 so that the argument is in milliseconds, not seconds.
    var date = new Date(unix_timestamp * 1000);
    // Hours part from the timestamp
    var hours = date.getHours();
    // Minutes part from the timestamp
    var minutes = "0" + date.getMinutes();
    // Seconds part from the timestamp
    var seconds = "0" + date.getSeconds();

    // Will display time in 10:30:23 format
    var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
}

function initUiElements(){
	$('[data-toggle="tooltip"]').tooltip();
	$('.toggleSwitcher').bootstrapToggle();
}

$.fn.modal.Constructor.prototype.enforceFocus = function() {};


function dTReload(){
    window.dTable.ajax.reload();

}

