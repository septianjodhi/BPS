<style>
	.my-custom-scrollbar {
		position: relative;
		height: 400px;
		overflow: auto;
	}
	.table-wrapper-scroll-y {
		display: block;
	}
</style>
<script>
	function open_childX(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
</script>

<?php
error_reporting(0);
session_start();
$sect=$_SESSION["area"]; 
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1];
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>FORECAST</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>CARI DATA PER PERIODE</h2>
						<small><em>Pilih periode yang akan di buat forecast-nya</em></small>
					</div>
					<div class="body">
						<form action="" id="form" name="form" method="post"  enctype="multipart/form-data">
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group form-float">
										<label>Periode</label>
										<div class="form-line">
											<input type="number" class="periode form-control" id="periode" name="periode" value="<?php echo date("Ym"); ?>" placeholder="Periode" required>
										</div> 
									</div>
								</div>
								<button type="submit" name="cr_b" id="cr_b" class="btn bg-purple waves-effect"><i class="material-icons">search</i></button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>UPLOAD DATA FORECAST</h2>
						<small><em>Format upload sama dengan format yang di download</em></small>
					</div>
					<div class="body">
						<form action="" id="form" name="form" method="post"  enctype="multipart/form-data">
							<div class="row clearfix">
								<div class="col-md-6">	
									<div class="form-group">
										<label>Pilih File Forecasrt</label>
										<div class="form-line">
											<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>											
										</div>
									</div>
								</div>
								<button type="submit" name="upld" id="upld" class="btn bg-purple waves-effect"><i class="material-icons">cloud_upload</i></button>								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
		if(isset($_POST['upld']) ){
			require_once "excel_reader2.php";
			// echo "<script>alert('upload data');</script>"; 
			$file_name = $_FILES['file']['name']; //nama file (tanpa path)
			$tmp_name  = $_FILES['file']['tmp_name']; //nama local temp file di server
			$file_size = $_FILES['file']['size']; //ukuran file (dalam bytes)
			$file_type = $_FILES['file']['type']; //tipe filenya (langsung detect MIMEnya)
			$fp1 = fopen($tmp_name, 'r'); // open file (read-only, binary)
			$fp = fopen($tmp_name, 'r');		
			$pecah=explode(".",$file_name);
			$ekstensi=$pecah[1];
			$extensionList=array("xls","XLS");
			if(in_array($ekstensi,$extensionList)){		
				$target = basename($_FILES['file']['name']) ;
				move_uploaded_file($_FILES['file']['tmp_name'], $target);			 
				$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);  
				$baris = $data->rowcount($sheet_index=0);
				$fixedbaris = $baris;	 

				$pic=$_SESSION['nama'];
				for ($i=9; $i<=$fixedbaris; $i++){		
					$kolA=$data->val($i,1);//No	
					$kolB=$data->val($i,2);//No Ctrl	
					$kolC=$data->val($i,3);//Part No
					$kolD=$data->val($i,4);//Part nm
					$kolE=$data->val($i,5);//Part dtl
					$kolF=$data->val($i,6);//Part desc
					$kolG=$data->val($i,7);//Uom
					$kolH=$data->val($i,8);//Curr
					$kolI=$data->val($i,9);//Qty STP
					$kolJ=$data->val($i,10);//Price STP
					$kolK=$data->val($i,11);//qty forecast
					$kolL=$data->val($i,12);//price forecast
					if($kolK>$kolI){$qty_forecast=$kolI;}else{$qty_forecast=$kolK;}
					if($kolL>$kolJ){$price_forecast=$kolJ;}else{$price_forecast=$kolL;}

					if($kolK!=""){
						$sql_updt="UPDATE bps_budget set qty_fcs=$qty_forecast,
						price_fcs=$price_forecast where no_ctrl='$kolB' ";
						$hasil = odbc_exec($koneksi_lp, $sql_updt);
					// echo "<br>lht ".$i.$sql_updt;
						if(!$hasil){
							echo "<br>Error ".$i.$sql_updt;
							print(odbc_error());
						}
					}
				}
				$baris_data=$fixedbaris-8;
				echo "<script>alert('Ada $baris_data baris. Data Berhasil di Upload'); window.location = '?page=form/inpt_forcase.php'</script>";
				unlink($_FILES['file']['name']);
			}else{ 
				echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_forcase.php'</script>"; 
			}
		}
		?>	 

		<div class="row clearfix">
			<div class="col-md-12">
				<div class="card">
					<div class="header">
						<h2>PLAN STP BUDGET</h2>
					</div>
					<div class="body">
						<div class="table-responsive">
							<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
								<thead>
									<tr>	
										<th>No</th>
										<th>No Control</th>
										<th>Part No</th>
										<th>Part Name</th>
										<th>Part Detail</th>
										<th>Part Desc</th>
										<th>UOM</th>
										<th>Curr</th>
										<th>Qty STP</th>
										<th>Price STP</th>
										<th>Qty Forecast</th>
										<th>Price Forecast</th>									
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($_POST['cr_b']) ){	
										$periode=$_POST['periode'];
										$sq_acc="SELECT *,(select top 1 price from bps_Quotation where lp_rekom='YES' and 
										part_no=a.part_no order by tgl_updt desc) as price_quo 
										FROM bps_budget a where sect='$sect' and periode='$periode' and Not existS (select *
										from bps_tmpPR where no_ctrl=a.no_ctrl)";
									// $sq_acc="SELECT * FROM bps_budget where sect='$sect' and periode='$periode'" ;
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
									}
									$row=0;
									while($baris1=odbc_fetch_array($tb_acc)){
										$row++;
										$price_quo=$baris1["price_quo"];
										$price_fcs=$baris1["price_fcs"];
										if($price_fcs==""){$price=$price_quo;}else if($price_quo==""){$price=$baris1["price"];}else{$price=$price_fcs;}
										if($curr=="USD"){$harga=number_format($price,18);}else{$harga=$price;}
										?>	
										<tr onclick="javascript:pilih(this);">
											<td><?php echo $row; ?></td>
											<td><?php echo $baris1["no_ctrl"]; ?></td>
											<td><?php echo $baris1["part_no"]; ?></td>
											<td><?php echo $baris1["part_nm"]; ?></td>
											<td><?php echo $baris1["part_dtl"]; ?></td>
											<td><?php echo $baris1["part_desc"]; ?></td>
											<td><?php echo $baris1["uom"]; ?></td>
											<td><?php echo $baris1["curr"]; ?></td>
											<td><?php echo $baris1["qty"]; ?></td>
											<td align="right"><?php echo $baris1["price"]; ?></td>
											<td><?php echo $baris1["qty_fcs"]; ?></td>
											<td align="right"><?php if($price==0){echo 0;}else{ echo $price;} ; ?></td>
										</tr>	
										<?php 
									}
									?>	
								</tbody>
								<tfoot><tr></tr></tfoot>							
							</table>
							<?php if(count($tb_acc)>0){ ?>
								<button type="button" class="btn bg-purple waves-effect" onclick="open_child('Exp_xls/exp_forecast.php?p=<?php echo $periode;?>&s=<?php echo $sect;?>','Forcase <?php echo $docno;?>','800','500'); return false;">
									<i class="material-icons">file_download</i>
									<span>Download</span>
								</button>	
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.periode').bootstrapMaterialDatePicker({
			format: 'YYYYMM', Date : new Date(),
			clearButton: true,
			weekStart: 1,
			time: false
		});	
	});
</script>	