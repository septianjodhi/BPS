 <script type="text/javascript">
$(document).ready(function()
  {

$('.datetime-min').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm', minDate : new Date() });
$('.date-min').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', minDate : new Date(),time: false });
$('.datetime').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', Date : Date(),time: false });
$('.datetime-rg').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss', Date : Date(),time: false });
$.material.init()
$('.selectpicker').selectpicker();
$(".tabel2").DataTable();
$('.periode').bootstrapMaterialDatePicker({format: 'YYYYMM', minDate : new Date(),clearButton: true,weekStart: 1,time: false });	
$('.date-pick').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD',time: false });
$('.setperiode').bootstrapMaterialDatePicker({format: 'YYYYMM', Date : new Date(),clearButton: true,weekStart: 0,time: false});
});

          function open_child(url,title,w,h){
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
                status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
                width='+w+',height='+h+',top='+top+',left='+left);

        };

    </script>
    <h3>TEST FUNC_GLOBAL</h3>