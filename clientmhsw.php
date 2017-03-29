<?php
include("koneksi.php");
if (isset($_POST['Input'])) {
	$nim  	= strip_tags($_POST['nim']);
	$nama  	= strip_tags($_POST['nama']);
	$prodi  = strip_tags($_POST['prodi']);
 
	//input ke db
	$query = sprintf("INSERT INTO mahasiswa VALUES('nim', 'nama', 'prodi')", 
			mysql_escape_string($nim), 
			mysql_escape_string($nama),
			mysql_escape_string($prodi)
		);
	$sql = mysql_query($query);
	if ($sql) {
		echo "Data berhasil disimpan";
	} else {
		echo "Data gagal disimpan ";
		echo mysql_error();
	}
}

// Pull in the NuSOAP code
require_once('nusoap.php');
// Create the client instance

$wsdl="http://localhost/webservice/servermhsw.php?wsdl";

$client =new nusoap_client($wsdl,true);
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
//$result = $client->call('ambilnama', array('name' => 'Unisbank'));
$param="select*from mahasiswa";
$result = $client->call('ambilnim', array($param));
// Check for a fault
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<h2>Result</h2><pre>';
        print_r($result);
    echo '</pre>';
    }
}
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>