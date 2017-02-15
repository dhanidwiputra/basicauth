<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Artishare</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
</head>
<body style="padding-top: 70px;">
	
	<nav class="navbar navbar-default navbar-fixed-top " style="border-bottom: 1px solid #d9d9d9 !important;">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="<?php echo base_url(); ?>">
	        <img alt="Brand" src="assets/img/logo.png" width="110px" style="margin-top: -5px;">
	      </a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      
	      <form class="navbar-form navbar-left">
	        <div class="form-group">
	          <input style="border-radius: 0px !important;" type="text" class="form-control" placeholder="Cari article yang anda inginkan ..." size="100%">
	        </div>
	        <button type="submit" style="border-radius: 0px !important;" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
	      </form>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Daftar</a></li>
	        <li><a href="#" onclick="document.getElementById('id01').style.display='block'">Masuk</a></li>
	        <!-- <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li> -->
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	

	<div id="id01" class="w3-modal">
	    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">

	      <div class="w3-center"><br>
	        <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">&times;</span>
	        <div id="profilep"><img src="assets/img/default.jpg" alt="Avatar" style="width:20%" class="w3-circle w3-margin-top w3-animate-right"></div>
	      </div>

	      <form class="w3-container" action="form.asp">
	        <div class="w3-section">
	          <label><b>Username</b></label><span id="usern"></span>
	          <input  class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="txt_username" onchange="cek_login_username(this.value)" required>
	          <label><b>Password</b></label>
	          <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required><br>
	          <button class="btn btn-default btn-block " type="submit">Login</button>
	          
	        </div>
	      </form>

	      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
	        <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
	        <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
	      </div>

	    </div>
	</div>
	
	<script>
		function cek_login_username (vars) {

			
			var username = vars;

			
			$.ajax({
				url	: '../artishare/index.php/home/cek_login_username',
				//mengirimkan username dan password ke script login.php
				data	: 'var_usn='+username, 
				//Method pengiriman
				type	: 'POST',
				//Data yang akan diambil dari script pemroses
				dataType: 'html',
				//Respon jika data berhasil dikirim
				success	: function(pesan){
					var pesans = pesan.split("#")
					if(pesans[0] == 'OK'){
						//Arahkan ke halaman admin jika script pemroses mencetak kata ok
						//window.location = url_admin;
						$('#usern').html('<span style="color:red;margin-left:5px;" class="glyphicon glyphicon-ok w3-animate-right"></span?>');
						$('#profilep').html('<img src="assets/img/'+ pesans[1] +'" alt="Avatar" style="width:20%" class="w3-circle w3-margin-top w3-animate-right">');
					}
					else{
						//Cetak peringatan untuk username & password salah
						// alert(pesan);
						// $('#btnLogin').attr('value','Coba lagi ...');
						$('#usern').html('<span style="color:red;margin-left:5px;" class="glyphicon glyphicon-remove w3-animate-right"></span?>');
					}
				},
			});
		}
	</script>

</body>


</html>