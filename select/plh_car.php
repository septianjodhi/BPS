<?php

	  
 // }
?> 
<div class="col-md-12">
<div class="box box-primary">
  <section class="content-header">
      <h1>PILIH CARLINE<small>Pilih Data Carline sesuai DRMS</small></h1>
	  
 </section> 
	<body class="hold-transition skin-blue sidebar-mini">
<section class="content">
    <div class="row">
 <table class="table table-bordered table-striped tabel2">
	<thead>
<tr>	
<th>Code Carline </th>
<th>Carline</th>
<th>Short name</th>
</tr>	
	</thead>
	<tbody>
<?php
$periCC=date("Y-m")."-01";
$sqCC="select * from ms_carline";
$tbsqCC=odbc_exec($koneksi_DRMS,$sqCC);
$row=0;
while($DCC=odbc_fetch_array($tbsqCC)){$row++;
	?>
        <tr onclick="javascript:pilih(this);">
		
			<td><?php echo trim(odbc_result($tbsqCC,"clcode"));?></td>			
            <td><?php echo trim(odbc_result($tbsqCC,"clname"));?></td>
            <td><?php echo trim(odbc_result($tbsqCC,"shortname"));?></td>	
        </tr>
		<?php } ?>  	
	</tbody>
	</table>

</div>
  </section>
</body>  
	 </div></div> 
<script>
    function pilih(row){	
		var kd_pel0=row.cells[0].innerHTML;
		var kd_pel1=row.cells[1].innerHTML;
		var kd_pel2=row.cells[2].innerHTML;
		window.opener.parent.document.getElementById("hdr_cln").value = kd_pel1;
	
        window.close();
    }
</script>