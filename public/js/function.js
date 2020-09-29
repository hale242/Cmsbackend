$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$.extend( true, $.fn.dataTable.defaults, {
    "pageLength": 50,
    "processing": true,
    "serverSide": true,
    "order": [[ 1, "asc" ]],
    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
    "language": {
        "aria": {
            "sortAscending": ": เรียงจากน้อยไปมาก",
            "sortDescending": ": เรียงจากมากไปน้อย"
        },
        "emptyTable": "ไม่พบข้อมูล",
        "info": "แสดงข้อมูล _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
        "infoEmpty": " ",
        "infoFiltered": "(filtered1 จาก _MAX_ total รายการ)",
        "lengthMenu": "_MENU_",
        "search": "ค้นหา :",
        "zeroRecords": "ไม่พบข้อมูล"
    },
    // responsive: true,
    "drawCallback": function( settings ) {
        $('[data-toggle="tooltip"]').tooltip();
    }
} );

function loadingButton(btn){
    var org_text = btn.data('loading');
    var current_text = btn.html();
    if(org_text===undefined){
        org_text = '<i class="fa fa-spinner fa-spin"></i>';
    }
    btn.attr('disabled','disabled');
    btn.html(org_text);
    btn.data('loading' , current_text);
}


function resetButton(btn){
    var org_text = btn.data('loading');
    var current_text = btn.html();
    if(!org_text){
        org_text = '<i class="fa fa-refresh fa-spin"></i>';
    }
    btn.removeAttr('disabled','disabled');
    btn.html(org_text);
    btn.data('loading' , current_text);
}


$('body').on('click', '[data-toggle="tooltip"]' , function () {
    $(this).tooltip('hide')
});

$('body').on('keydown','.number-only',function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

if($(".form_year").length>0){
    $(".form_year").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'yyyy',
        minView: 4,
        startView:4
    });
}
if($(".form_month").length>0){
    $(".form_month").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'mm/yyyy',
        minView: 3,
        startView:3
    });
}

if($(".form_date").length>0){
    $(".form_date").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'dd/mm/yyyy',
        minView: 2
    });
}

if($(".form_date_time").length>0){
    $(".form_date_time").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'dd/mm/yyyy hh:ii'
    });
}

if($(".form_time").length>0){
    $(".form_time").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'hh:ii',
        startView:1
    });
}

$('body').on('click','.remove_date_time',function(){
    $(this).prev().val('');
});

$('body').on('click','.trigger_date_time',function(){
    $(this).prev().prev().click();
    $(this).prev().prev().trigger('click');
    $(this).prev().prev().focus();
});

$('body').on('keyup', '.price', function(){
    if($(".price").length>0){
        $('.price').priceFormat({
            prefix: '',
            suffix: ''
        });
    }
});

function addNumformat(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function deleteNumformat(nStr){
    var spl = nStr.split(",");
    var x = "";
    for(i in spl){
        x =x+spl[i];
    }
    return x;
}
