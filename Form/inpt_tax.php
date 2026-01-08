<section class="content">
  <div class="container-fluid">
    <div class="block-header">
      <h2>MASTER DATA KODE FAKTUR</h2>
    </div>

    <div class="row clearfix">
      <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>
              INPUT DATA KATEGORI BARANG
              <small>Input master data kategori barang sebagai acuan penentuan jenis pajak </small>
            </h2>
          </div>
          <div class="body">
            <form role="form"  name="form1" id="form1" method="post" action="">
              <div class="row clearfix">
                <input type="hidden" name="kd_tax">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Area</label>
                    <div class="form-line">
                      <select class="form-control show-tick" name="area" required>
                        <option value="">--Pilih Area-</option>
                        <option>All</option>
                        <option>Prd</option>
                        <option>Non-Prd</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Kode Faktur</label>
                    <div class="form-line">
                      <select class="form-control show-tick" name="kd_faktur" required>
                        <option value="">--Pilih Kode--</option>
                        <option>01</option>
                        <option>07</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Kategori Barang</label>
                    <div class="form-line">
                      <input type="text" class="form-control" data-role="tagsinput" id="kat_brg" name="kat_brg" placeholder="Kategori Barang" required>
                    </div> 
                  </div>
                </div>
              </div>
              <div class="row clearfix">     
                <button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>     
                <button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
              </div>  
            </form>
            <?php 
            $pic=$_SESSION['nama'];
            if(isset($_POST['smpn']) or isset($_POST['del'])){
              $area=$_POST['area']; 
              $kd_faktur=$_POST['kd_faktur'];
              $kat_brg=$_POST['kat_brg'];
              $kd_tax=$_POST['kd_tax'];

              if($kd_tax==""){
                $cr_kd="select max(RIGHT(kd_tax,3)) as jj from bps_tax ";
                $tb_no=odbc_exec($koneksi_lp,$cr_kd);
                $no_tax=odbc_result($tb_no,"jj");
                $no_tax=$no_tax+1;  
                $no_tax1="T-".substr('000'.$no_tax,-3);
              // $qry_del="delete from bps_tax where kd_tax='$part_no'";
                $qry_add="insert into bps_tax(kd_tax, area, kd_faktur,kat_brg,pic_updt, tgl_updt) values('$no_tax1','$area','$kd_faktur','$kat_brg','$pic',getdate())";
              // echo $qry_add;
              // $tb_del=odbc_exec($koneksi_lp,$qry_del);
              }else{
                $qry_add="update bps_tax set area='$area',kd_faktur='$kd_faktur' ,kat_brg='$kat_brg',pic_updt='$pic', tgl_updt=getdate() where kd_tax='$kd_tax' ";
              }
            }
            if(isset($_POST['smpn']) ){ 
              $tb_add=odbc_exec($koneksi_lp,$qry_add);
              // $sq_crpart="select * from bps_tax where kd_tax='$no_tax1'";
            }
            ?>

          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>INPUT<small>Upload Master Part</small></h2>
          </div>
          <div class="body">
            <div class="row clearfix">
              <form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
                <div class="form-group">
                  <label>Open File</label>
                  <div class="form-line">
                    <input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
                  </div>
                </div>
                <button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
                  <i class="material-icons">saves</i>UPLOAD
                </button>
              </form>
              <?php
              if(isset($_POST['upld']) )
              {
                require_once "excel_reader2.php";
                //nama file (tanpa path)
                $file_name = $_FILES['file']['name']; 
                //nama local temp file di server
                $tmp_name  = $_FILES['file']['tmp_name'];
                //ukuran file (dalam bytes) 
                $file_size = $_FILES['file']['size'];
                //tipe filenya (langsung detect MIMEnya) 
                $file_type = $_FILES['file']['type']; 
                // open file (read-only, binary)
                $fp1 = fopen($tmp_name, 'r'); 
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

                  $dataok=0;$datan=0;     
                  for ($i=5; $i<=$fixedbaris; $i++){
                    $kolA=$data->val($i,1);
                    $kolB=$data->val($i,2);
                    $kolC=$data->val($i,3);
                    $kolD=$data->val($i,4);

                    $cr_kd="select max(RIGHT(kd_tax,3)) as jj from bps_tax ";

                    $tb_no=odbc_exec($koneksi_lp,$cr_kd);
                    $no_tax=odbc_result($tb_no,"jj");
                    $no_tax=$no_tax+1;  
                    $no_tax1="T-".substr('000'.$no_tax,-3);

                    $sql_updt="insert into  bps_tax(kd_tax, area, kd_faktur,kat_brg,pic_updt, tgl_updt) values ('$no_tax1', '$kolB','$kolC','$kolD','$pic',getdate())";
                    $hasil = odbc_exec($koneksi_lp, $sql_updt);
                    // echo "<br>lht ".$i.$sql_updt;
                    if(!$hasil){
                      echo "<br>Error ".$i.$sql_updt;
                      $datan++;
                      print(odbc_error());
                    }else{$dataok++;}
                  }
                  unlink($_FILES['file']['name']);  
                  $sq_crpart="select * from bps_tax where tgl_updt=getdate()";
                  echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');'</script>";
                }else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_tax.php'</script>"; 
              }
            }
            ?>   
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            SUMMARY PENGGOLONGAN KODE FAKTUR
            <small>Summary master data kode faktur </small>
          </h2>
        </div>
        <div class="body">
          <form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
            <div class="row clearfix">
              <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
                  <thead>
                    <tr>  
                      <th>KODE TAX</th>
                      <th>AREA</th>
                      <th>KODE FAKTUR</th>
                      <th>KATEGORI BARANG</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query="SELECT * from bps_tax order by kd_tax asc";
                        // echo $sq_pr;
                    $tb_query=odbc_exec($koneksi_lp,$query);
                    $i=0;
                    while($baris=odbc_fetch_array($tb_query)){ $i++;
                      ?>  
                      <tr onclick="javascript:pilih(this);">
                        <td><?= $baris["kd_tax"] ;?></td>
                        <td><?= $baris["area"] ;?></td>
                        <td><?= $baris["kd_faktur"] ;?></td>
                        <td><?= $baris["kat_brg"] ;?></td>
                      </tr>
                      <?php 
                    }
                    ?>  
                  </tbody>
                </table>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<script>
  function pilih(row){
    var kd_pel0=row.cells[0].innerHTML;
    var kd_pel3=row.cells[3].innerHTML;
    document.form1.kd_tax.value=kd_pel0;
    document.form1.kat_brg.value=kd_pel3;
  }
</script>