<?php
# Konek ke Web Server Lokal
$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "sia_42db";

# Konek ke Web Server Lokal
$koneksidb	= mysql_connect($myHost, $myUser, $myPass) or die ("Koneksi ke MySQL tidak berhasil ".mysql_error());

# Memilih database pd MySQL Server
mysql_select_db($myDbs, $koneksidb) or die ("Database <>$myDbs</> tidak ditemukan ! ".mysql_error());
?>