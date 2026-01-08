<?php
error_reporting(0);
session_start();
$kd=$_GET['part'];
$qty_pr=$_GET['qty'];
$pch_part=explode("|",$kd);
$part=$pch_part[0];
$spp=$pch_part[1];
$pr=$pch_part[2];
$qt=$pch_part[3];
$list_part=str_replace(",","','",$part);	  
include "../koneksi.php";
$sect=$_SESSION["area"]; 
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1];
echo "<script>alert('$kd');</script>";	
?> 
 <table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
	<thead>
<tr>	
<th>No</th>
<th>Kode Supplier</th>
<th>PR No</th>
<th>Part No</th>
<th>Total Qty</th>
<th>Price</th>
</tr>	
	</thead>
	<tbody>
<?php
/*$sqCC="select distinct term,periode,kode_supp,pr_no,part_no,part_nm,part_dtl,lp,sum(qty_act) as qty,curr,price_tot,uom,min(dateadd(DD,3,pr_date)) as min_po from bps_tmpPR a where penawaran='YES' and no_Quo is not null and exists (select distinct no_doc from bps_approve where jns_doc='PR' and status='FINISH') and a.kode_supp<>'' and not exists (select * from bps_podtl b where b.part_no=a.part_no and b.pr_no=a.pr_no) and kode_supp like '%$spp%' and lp like '%$sec%' and part_no like '%$part%' and pr_no in ('$pr') group by term,periode,kode_supp,pr_no,part_no,curr,price_tot,uom,lp,part_nm,part_dtl order by a.part_no";
*/

$sqCC="SELECT distinct no_quo,pr_no,kode_supp,part_no,part_nm,part_dtl,part_desc,price_tot as price,lp,'$po_no' as po_no,'$pic' as pic_updt,getdate() as tgl_updt,sum(qty_act) as qty,term,periode,curr,uom from bps_tmpPR where kode_supp like '%$spp%' and part_no='".$np2[0]."' and pr_no='".$np2[2]."' group by no_quo,pr_no,kode_supp,part_no,part_nm,part_dtl,part_desc,price_tot,lp,term,periode,curr,uom";

// echo $sqCC;
$tbsqCC=odbc_exec($koneksi_lp,$sqCC);
$row=0;
while($DCC=odbc_fetch_array($tbsqCC)){$row++;
	?>
        <tr>			
			<td><?php echo $row;?></td>		
			<td><?php echo odbc_result($tbsqCC,"kode_supp");?></td>				
			<td><?php echo odbc_result($tbsqCC,"pr_no");?></td>		
			<td><?php echo $part;?></td>			
			<td><?php echo odbc_result($tbsqCC,"qty");?></td>			
			<td><?php echo odbc_result($tbsqCC,"curr")." ".number_format(odbc_result($tbsqCC,"price_tot"),0,".",","); ?></td>			
        </tr>
		<?php } ?>  	
	</tbody>
	</table>