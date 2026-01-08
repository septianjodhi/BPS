 <script type="text/javascript">
 	function loginX(url){
	//alert("test);
	var usr=document.sign_in.Username.value;
	var pss=document.sign_in.password.value;
	var alamat=url+"?username="+usr+"&password=" + pss;
	if(usr=='' || pss==''){
		alert("DATA TIDAK LENGKAP");}
		else{
			$("#data_kk").empty();
			$("#data_kk").load(alamat);
		}
	};
</script>
<section class="content" >
	<div class="login-page">
		<div class="container-fluid">
			<div class="login-box">
				<div class="logo">
					<a href="javascript:void(0);">Login <b>BPS</b></a>
					<h4 style="text-align: center">Budget and<br>Purchasing System</h4>
				</div>
				<div class="card">
					<div class="body">
						<form id="sign_in" name="sign_in" method="POST" action="sisip/login.php">
							
							<input type="hidden" name="latitude" id="latitude">
							<input type="hidden" name="longitude" id="longitude">

							<div class="msg">Masuk Untuk mengakses data BPS</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="material-icons">User</i></span>
								<div class="form-line">
									<input type="text" class="form-control" id="username" name="username" placeholder="Username" required autofocus>
								</div></div>
								<div class="input-group">
									<span class="input-group-addon"><i class="material-icons">lock</i></span>
									<div class="form-line">
										<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
									</div></div>
									
									<div class="input-group">
										<span class="input-group-addon"><i class="material-icons">home</i></span>
										<div class="form-line">
											<select class="selectpicker"  style="width: 100%;"  name="lok" id="lok" required>
												<option selected="selected" value="">---Pilih Lokasi--</option>
												<option value="TF">SAMI Tugu</option>
												<option value="JF">SAMI Jepara</option>
												<!-- <option value="Candi">SAMI Candi</option> -->
											</select>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-8 p-t-5">
                            <!--input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            	<label for="rememberme">Tetap Masuk</label-->

                            	</div>
                            	<div class="col-xs-4">
                            		<!-- <button class="btn btn-block bg-pink waves-effect" type="submit" id="cmdlogin" name="cmdlogin" onclick="loginX('sisip/login.php'); return false;" >Login</button> -->
                            		<button class="btn btn-block bg-pink waves-effect" type="submit" id="cmdlogin" name="cmdlogin" >Login</button>
                            	</div>
                            </div>
                    <!--div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="sign-up.html">Register Now!</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div-->
                </form>
                <div id="data_kk"></div>
            </div>
        </div>
    </div>
</div>
</div>
</section>	
<?php 
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
/*
if(isset($_POST["cmdlogin"])){
	//include="sisip/login.php";
	
session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
 
	
    $sql2 = "select * from login_employee where NIK='".$username."' and PASSWORD='".$password."' ";
	$query=odbc_exec($koneksi,$sql2);
    if($query){
		
	$row=0;
	//session_register("nama");
	//session_register("status");
	while($baris=odbc_fetch_array($query)){
			$nama		=odbc_result($query,"Nama");
			$akses		=odbc_result($query,"Akses");
			$area		=odbc_result($query,"Area");
			$users		=odbc_result($query,"nik");
			$website="Esys";
			$row++;
	}
	if($row==0){
	 echo "<script>alert('Username & Password tidak cocok = $sql2');'</script>";
	}else{
			$_SESSION['isLoggedIn']=1;
           	$_SESSION['nama']=$nama;
			$_SESSION['akses']=$akses;
			$_SESSION['users']=$users;
			$tgal=date("Y-m-d H:i:s",strtotime("now"));
			$_SESSION['website']=$website;
			
			$sql_us = "insert into log_login(nik,nama,waktu,STATUS) values ('$users','$nama','$tgal','Login')";
			$query_us=odbc_exec($koneksi,$sql_us);
			//echo "<script>window.location = 'index.php?page=index1.php'</script>";	
		
		echo "<script>window.location = 'index.php'</script>";
        }
        
    }
}*/
?>
<script>
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else { 
			x.innerHTML = "Geolocation tidak didukung oleh browser ini.";
		}
	}

	function showPosition(position) {
		document.getElementById("latitude").innerHTML =position.coords.latitude;
		document.getElementById("longitude").innerHTML =position.coords.longitude;
	}
	
</script>