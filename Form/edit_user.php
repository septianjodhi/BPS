<?php 
include("koneksi.php");
$nik=$_SESSION['nik'];
$pic=$_SESSION['nama'];
$sect=$_SESSION['area'];
$pc_sect=explode("-", $sect);
$dept=$pc_sect[0];
$area=$_SESSION['area'];
$lokasi=$_SESSION['lokasi'];

$select="SELECT * FROM tbl_user where nik='$nik' ";
$dt=mysql_fetch_array(mysql_query($select));
?>
<!-- Masked Input -->
<section class="content">
  <div class="container-fluid">
    <div class="block-header">
      <h2>Edit User</h2>
    </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>
              Profile
              <small>Ubah User Profile</small>
            </h2>
          </div>
          <form method="post" action="">
            <div class="body">
              <div class="demo-masked-input">
                <div class="row clearfix">

                  <div class="col-md-6">
                    <b>Nama</b>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">credit_card</i>
                      </span>
                      <div class="form-line">
                        <input type="text" class="form-control" name="nama" value="<?= $dt['nama'] ;?>" placeholder="Nama Lengkap">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <b>Email</b>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">email</i>
                      </span>
                      <div class="form-line">
                        <input type="text" class="form-control email" name="email" value="<?= $dt['email'] ;?>" placeholder="Email resmi perusahaan">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <b>Username</b>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">credit_card</i>
                      </span>
                      <div class="form-line">
                        <input type="text" class="form-control" name="user" value="<?= $dt['user'] ;?>" value="<?= $dt['username'] ;?>" placeholder="Username">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <b>Password</b>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">vpn_key</i>
                      </span>
                      <div class="form-line">
                        <input type="password" class="form-control key" name="passw" value="<?= $dt['pass'] ;?>" placeholder="Password">
                      </div>
                    </div>
                  </div>

                  <button type="submit" name="smpn" class="btn btn-success"><i class="material-icons">saves</i>UPDATE</button>
                </div>
              </div>
            </div>
          </form>
          <?php
          if(isset($_POST['smpn'])){  
            $email=$_POST['email'];
            $nama=$_POST['nama'];
            $user=$_POST['user'];
            $passw=$_POST['passw'];

            $update="update tbl_user set nama='$nama',user='$user',pass='$passw',email='$email', tgl_updt=now(),pic_updt='$nama'
            where nik='$nik' and area='$area' and lokasi='$lokasi' and app_nm='BPS'";
            // echo $update;
            $query=mysql_query($update);

            $sql2 = "select * from tbl_user where user='$username' and pass='$password' and lokasi='$lokasi' and app_nm='BPS' and nik='$nik' ";
            $query=mysql_query($sql2);

            if($query)
            { 
              $row=0;
              while($baris=mysql_fetch_array($query))
              {
                $nik    =$baris['nik'];
                $nama   =$baris['nama'];
                $status =$baris['status'];
                $akses  =$baris['akses'];
                $area   =$baris['area'];
                $users  =$baris['user'];
                $website="BPS";
                $lokasi =$lokasi;
                $row++;
              }
              if($row > 0)
              {
                $_SESSION['isLoggedIn']=1;
                $_SESSION['nik']=$nik;
                $_SESSION['nama']=$nama;
                $_SESSION['akses']=$akses;
                $_SESSION['area']=$area;
                $_SESSION['user']=$users;
                $_SESSION['status']=$status;
                $_SESSION['website']=$website;    
                $_SESSION['lok']=$lokasi; 
                $_SESSION['lokasi']=$lokasi;
                $tgal=date("Y-m-d H:i:s",strtotime("now"));

    //  $sql_us = "insert into Log_USER_ACT(NAMA,LOGIN,STATUS) values ('$users','$tgal','$status')";
    //  $query_us=mysql_query($sql_us);
                $updt_log="update tbl_user set last_login=now(),ip='$alamat_ip' 
                where app_nm='BPS' and user='$username' ";
                $query_updt=mysql_query($updt_log);
                echo "<script>window.location = '../index.php'</script>";
              }
            }

            echo "<script>alert('Data Profile Berhasil diperbarui'); 
            window.location = '?page=form/edit_user.php'</script>";
          // $sq_crpart="select * from tbl_user where app_nm='BPS' and lokasi='$lokasi' and 
          // nik='$nik' and user='$user' order by area asc";
          }
          ?>

        </div>
      </div>
    </div>
  </div>
</section>
