<?php
	//nusoap	
	require_once ("nusoap.php");
	
	//instance server
	$serv = new nusoap_server();
	
	$serv->configureWSDL('akademikws','http://localhost/ws/appserver1.php?wsdl');
	
	//mendefinisikan tipe data complex (buatan)
	// mhs("nim":string, "nama":string) 
	$serv->wsdl->addComplexType(
			'mahasiswa',		//1.nama tipe
			'complexType',				//2.jenis
			'struct',					//3.tipe record
			'sequence',					//4. sequence
			'',		//5.encoding array shg record kosong jika array diisi SOAP-ENC:Array
			array(   //6.deklarasi elemen-2 record
			  'nim'=>array('name'=>'nim','type'=>'xsd:string'),
			  'nama'=>array('name'=>'nama','type'=>'xsd:string'),
			  'prodi'=>array('name'=>'prodi','type'=>'xsd:string')
			)
	);
	
	$serv->wsdl->addComplexType(
			'arrayOfMahasiswa',		//1.nama tipe
			'complexType',				//2.jenis
			'array',					//3.tipe record
			'',					//4. sequence
			'SOAP-ENC:Array',		//5.encoding array shg record kosong jika array diisi SOAP-ENC:Array
			array(),
			array(
			   array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'tns:mahasiswa[]')
			),
			'tns:mahasiswa'   
	);
	
	$serv->wsdl->addComplexType(
			'matakuliah',		//1.nama tipe
			'complexType',				//2.jenis
			'struct',					//3.tipe record
			'sequence',					//4. sequence
			'',		//5.encoding array shg record kosong jika array diisi SOAP-ENC:Array
			array(   //6.deklarasi elemen-2 record
			  'kdmk'=>array('name'=>'kdmk','type'=>'xsd:string'),
			  'nmmk'=>array('name'=>'nmmk','type'=>'xsd:string'),
			  'sks'=>array('name'=>'sks','type'=>'xsd:integer'),
			  'prodi'=>array('name'=>'prodi','type'=>'xsd:string')
			)
	);
	
	$serv->wsdl->addComplexType(
			'arrayOfMatakuliah',		//1.nama tipe
			'complexType',				//2.jenis
			'array',					//3.tipe record
			'',					//4. sequence
			'SOAP-ENC:Array',		//5.encoding array shg record kosong jika array diisi SOAP-ENC:Array
			array(),
			array(
			   array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'tns:matakuliah[]')
			),
			'tns:matakuliah'   
	);
	
	
	
	//register layanan
	$serv -> register("inputmhs",					//1.nama metode
					  array('mhs'=>'tns:mahasiswa'),//2.input
					  array('return'=>'xsd:string'),//3.output
					  'http://localhost/akademikws',				//4.namespace
					  'http://localhost/akademikws#inputmhs',	//5.soap-action
					  'rpc',						//6.style
					  'encoded',					//7.use
					  'Untuk menyimpan data mahasiswa baru'  //8.ket  	
	);
	
	$serv -> register("inputmhs2",					//1.nama metode
					  array('mhs'=>'xsd:string'),//2.input
					  array('return'=>'xsd:string'),//3.output
					  'http://localhost/akademikws',				//4.namespace
					  'http://localhost/akademikws#inputmhs2',	//5.soap-action
					  'rpc',						//6.style
					  'encoded',					//7.use
					  'Untuk menyimpan data mahasiswa baru'  //8.ket  	
	);
	

	$serv -> register("inputmk",					//1.nama metode
					  array('mk'=>'tns:matakuliah'),//2.input
					  array('return'=>'xsd:string'),//3.output
					  'http://localhost/akademikws',				//4.namespace
					  'http://localhost/akademikws#inputmk',	//5.soap-action
					  'rpc',						//6.style
					  'encoded',					//7.use
					  'Untuk menyimpan data mata kuliah baru'  //8.ket  	
	);


	$serv -> register("carimhs",
					array('nim'=>'xsd:string'),
					array('return'=>'tns:mahasiswa'),
					'http://localhost/akademikws',				//4.namespace
					'http://localhost/akademikws#carimhs',	//5.soap-action
					'rpc',						//6.style
					'encoded',					//7.use
					'Untuk mencari profil mahasiswa'	
	);
	
	$serv -> register("daftarmhsperprodi",
					array('prodi'=>'xsd:string'),
					array('return'=>'tns:arrayOfMahasiswa'),
					'http://localhost/akademikws',				//4.namespace
					'http://localhost/akademikws#daftarmhsperprodi',	//5.soap-action
					'rpc',						//6.style
					'encoded',					//7.use
					'Untuk menampilkan daftar mahasiswa per program studi'	
	);
	
	$serv -> register("carimk",
					array('kdmk'=>'xsd:string'),
					array('return'=>'tns:matakuliah'),
					'http://localhost/akademikws',				//4.namespace
					'http://localhost/akademikws#carimk',	//5.soap-action
					'rpc',						//6.style
					'encoded',					//7.use
					'Untuk mencari info mata kuliah'	
	);
	
	$serv -> register("daftarmkperprodi",
					array('prodi'=>'xsd:string'),
					array('return'=>'tns:arrayOfMatakuliah'),
					'http://localhost/akademikws',				//4.namespace
					'http://localhost/akademikws#daftarmkperprodi',	//5.soap-action
					'rpc',						//6.style
					'encoded',					//7.use
					'Untuk menampilkan daftar matakuliah per program studi'	
	);
	
	$serv -> register("ambilKrs",
					array('thakd'=>'xsd:string','nim'=>'xsd:string','ambilmk'=>'tns:arrayOfMatakuliah'),
					array('return'=>'xsd:string'),
					'http://localhost/akademikws',				//4.namespace
					'http://localhost/akademikws#ambilKrs',	//5.soap-action
					'rpc',						//6.style
					'encoded',					//7.use
					'Untuk transaksi pengambilan matakuliah per mahasiswa'	
	);
	
	
	//provided services (function/method)
	function inputmhs($mhs) {

		$nim  = $mhs['nim'];
		$nama = $mhs['nama'];
		$prodi= $mhs['prodi'];
		
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		mysql_query("insert into mahasiswa(nim,nama,prodi) values('$nim', '$nama','$prodi')",$cn);
		if (mysql_affected_rows($cn)>0) {
			return "Berhasil";
		} else {
			return "Gagal";
		}
	}
	function inputmhs2($mhs) {

		$nim  = $mhs['nim'];
		$nama = $mhs['nama'];
		$prodi= $mhs['prodi'];
		
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		mysql_query("insert into mahasiswa(nama) values('$nama')",$cn);
		if (mysql_affected_rows($cn)>0) {
			return "Berhasil";
		} else {
			return "Gagal";
		}
	}
	
	function inputmk($mk) {

		$kdmk  = $mk['kdmk'];
		$nmmk = $mk['nmmk'];
		$sks = $mk['sks'];
		$prodi= $mk['prodi'];
		
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		mysql_query("insert into matakuliah(kdmk,nmmk,sks,prodi) values('$kdmk', '$nmmk','$sks','$prodi')",$cn);
		if (mysql_affected_rows($cn)>0) {
			return "Berhasil";
		} else {
			return "Gagal";
		}
	}
	
	function carimhs($nim) {
	
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		$hasil = mysql_query("select nim,nama,prodi from mahasiswa where nim = '$nim'",$cn);
		$data = mysql_fetch_row($hasil);
		$m = array('nim' => $data[0], 'nama' => $data[1], 'prodi' => $data[2]);
		return $m;	
	}
	
	function carimk($kdmk) {
	
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		$hasil = mysql_query("select kdmk,nmmk,sks,prodi from matakuliah where kdmk = '$kdmk'",$cn);
		$data = mysql_fetch_row($hasil);
		$m = array('kdmk' => $data[0], 'nmmk' => $data[1], 'sks' => $data[2], 'prodi' => $data[3]);
		return $m;	
	}
	
	function daftarmhsperprodi($prodi){
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		$hasil = mysql_query("select nim,nama,prodi from mahasiswa where prodi = '$prodi' ",$cn);
		while($data = mysql_fetch_row($hasil)){
			$m[] = array('nim' => $data[0], 'nama' => $data[1], 'prodi' => $data[2]);
		}	
		return $m;
	}
	
	function daftarmkperprodi($prodi){
		$cn = mysql_connect("localhost", "root", "");
		mysql_select_db("akademik",$cn);
		$hasil = mysql_query("select kdmk,nmmk,sks,prodi from matakuliah where prodi = '$prodi' ",$cn);
		while($data = mysql_fetch_row($hasil)){
			$m[] = array('kdmk' => $data[0], 'nmmk' => $data[1], 'sks' => $data[2], 'prodi' => $data[3]);
		}	
		return $m;
	}
	
	function ambilKrs($thakd, $nim, $ambilmk){
		if (!empty($thakd) && !empty($nim) && !empty($ambilmk)){
			$cn = mysqli_connect("localhost","root","","akademik");
			mysqli_autocommit($cn, false);
			$valid = true;
			
			for($i=0; $i<count($ambilmk); $i++){
				$kdmk = $ambilmk[$i]['kdmk'];
				$sql = "INSERT INTO nilai(thakd, nim, kdmk) ";
				$sql .= "VALUES('$thakd', '$nim', '$kdmk') ";
				$hasil = mysqli_query($cn, $sql);
				$valid = $valid && $hasil;
			}
			if ($valid){
				mysqli_commit($cn);
				$msg = "Transaksi ambil mata kuliah berhasil disimpan.";
			}else{
				mysqli_rollback($cn);
				$msg = "Transaksi ambil mata kuliah gagal.";
			}
		}else{
			$msg = "Data transaksi tidak valid!";
		}
		return $msg;
	}
	
	//define event listener's variable
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA : "";
	$serv -> service($HTTP_RAW_POST_DATA);
	
?>