<html> 
	<head> 
		<title>Tugas 3</title>
		<style type="text/css"> 
		.labelfrm { 
			display:block; 
			font-size:small; 
			margin-top:5px; 
		} 
		.error { 
			font-size:small; 
			color:red; 
		} 
		</style> 
	</head>
<body>
<h1>Data Mahasiswa</h1> 
		<form action="clientmhsw.php" method="post" id="frm"> 
			<label for="nim" class="labelfrm">NIM: </label> 
			<input type="text" name="nim" id="nim" maxlength="15" class="required" size="15"/> 		 
			<label for="nama" class="labelfrm">NAMA: </label> 
			<input type="text" name="nama" id="nama" size="30" class="required"/> 
 			<label for="nama" class="labelfrm">PRODI: </label> 
			<input type="text" name="prodi" id="prodi" size="30" class="required"/> 
			<label for="submit" class="labelfrm">&nbsp;</label> 
			<input type="submit" name="Input" value="Input" id="input"/> 
		</form> 
</body>
</html>