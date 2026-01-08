 <script >
  alert("LOAD FUNCTION");
function datetime_min(id){
  $('#'+id).bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm', minDate : new Date() });
}
function date_min(id) {
$('#'+id).bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', minDate : new Date(),time: false });
}
function datetime(id) {
  $('#'+id).bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', Date : Date(),time: false });
}
function datetime_rg(argument) {
  $('#'+id).bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss', Date : Date(),time: false });
}
function selectpicker(id) {
  $('#'+id).selectpicker();
}
function tabel2(id) {
  $('#'+id).DataTable();
}
function date_pick(id) {
  $('#'+id).bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD',time: false });
}
function periode(id) {
  $('#'+id).bootstrapMaterialDatePicker({format: 'YYYYMM', minDate : new Date(),clearButton: true,weekStart: 1,time: false });  
}
function setperiode(id) {
  $('#'+id).bootstrapMaterialDatePicker({format: 'YYYYMM', Date : new Date(),clearButton: true,weekStart: 0,time: false});
}
//$.material.init()

function open_child(url,title,w,h){
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
    status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
    width='+w+',height='+h+',top='+top+',left='+left);
};

    </script>