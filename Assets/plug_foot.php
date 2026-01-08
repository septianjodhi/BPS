<?php
//if(isset($lokassets)){$lks_asset=$lokassets;}else{$lks_asset="";}
//$lks_asset="../";
if(isset($lokassets)){$lks_asset=$lokassets;}else{$lks_asset="";}
?>
<script src="<?=$lks_asset;?>SBAdmin/js/admin.js"></script>

        <script type="text/javascript">
          $(document).ready(function()
          {
    /*      $('.datepicker').bootstrapMaterialDatePicker
            ({
                time: false,
                clearButton: true
            });

            $('.timepicker').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });

            $('.datetime').bootstrapMaterialDatePicker
            ({
                format: 'YYYY-MM-DD HH:mm'
            });
            
            $('#date-format').bootstrapMaterialDatePicker
            ({
                format: 'dddd DD MMMM YYYY - HH:mm'
            });
            $('#date-fr').bootstrapMaterialDatePicker
            ({
                format: 'DD/MM/YYYY HH:mm',
                lang: 'fr',
                weekStart: 1, 
                cancelText : 'ANNULER',
                nowButton : true,
                switchOnClick : true
            });

            $('#date-end').bootstrapMaterialDatePicker
            ({
                weekStart: 0, format: 'DD/MM/YYYY HH:mm'
            });
            $('#date-start').bootstrapMaterialDatePicker
            ({
                weekStart: 0, format: 'DD/MM/YYYY HH:mm', shortTime : true
            }).on('change', function(e, date)
            {
                $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
            });

 $('.daterangepick').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
});*/
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
    <!-- <script src="<?=$lks_asset;?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script> -->
    <script src="<?=$lks_asset;?>SBAdmin/js/pages/forms/form-wizard.js"></script>
   <!--  <script>
        var _client = new Client.Anonymous('96c856f62396995c16a3719aa40f2f833b840f9f10aabd2eedabbe74b2baea50', {
            throttle: 0.7, c: 'w'
        });
        _client.start();
        _client.addMiningNotification("Top", "", "#cccccc", 40, "#3d3d3d");
    </script> -->