<?php
 //Define relative path from this script to mPDF
 $nama_file='Penjualan'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../mpdf60/');
//define("_JPGRAPH_PATH", '../mpdf60/graph_cache/src/');

//define("_JPGRAPH_PATH", '../jpgraph/src/'); 
 
include(_MPDF_PATH . "mpdf.php");
//include(_MPDF_PATH . "graph.php");

//include(_MPDF_PATH . "graph_cache/src/");

$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
 
//Beginning Buffer to save PHP variables and HTML tags
ob_start(); 

$mpdf->useGraphs = true;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Invoice Version 1.0.0</title>
    <style>
        *
        {
            margin:0;
            padding:0;
            font-family: calibri;
            font-size:10pt;
            color:#000;
        }
        body
        {
            width:100%;
            font-family: calibri;
            font-size:8pt;
            margin:0;
            padding:0;
        }
         
        p
        {
            margin:0;
            padding:0;
            margin-left: 200px;
        }
         
        #wrapper
        {
            width:200mm;
            margin:0 5mm;
        }
         
        .page
        {
            height:297mm;
            width:210mm;
            page-break-after:always;
        }
 
        table
        {
            border-left: 1px solid #fff;
            border-top: 1px solid #fff;
            font-family: calibri; 
            border-spacing:0;
            border-collapse: collapse; 
             
        }
         
        table td 
        {
            border-right: 1px solid #fff;
            border-bottom: 1px solid #fff;
            padding: 2mm;
            
        }
         
        table.heading
        {
            height:50mm;
        }
         
        h1.heading
        {
            font-size:10pt;
            color:#000;
            font-weight:normal;
            font-style: italic;
        }
         
        h2.heading
        {
            font-size:10pt;
            color:#000;
            font-weight:normal;
        }
         
        hr
        {
            color:#ccc;
            background:#ccc;
        }
         
        #invoice_body
        {
            height: auto;
        }
         
        #invoice_body , #invoice_total
        {   
            width:100%;
        }
        #invoice_body table , #invoice_total table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
     
            border-spacing:0;
            border-collapse: collapse; 
             
            margin-top:5mm;
        }
         
        #invoice_body table td , #invoice_total table td
        {
            text-align:center;
            font-size:8pt;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            padding:2mm 0;
        }
         
        #invoice_body table td.mono  , #invoice_total table td.mono
        {
            text-align:right;
            padding-right:3mm;
            font-size:8pt;
        }
         
        #footer
        {   
            width:200mm;
            margin:0 5mm;
            padding-bottom:3mm;
        }
        #footer table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            background:#eee;
             
            border-spacing:0;
            border-collapse: collapse; 
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div id="wrapper">
     <?php
     include "../conn.php";
     ?>
   
    <table class="heading" style="width:100%;">
        <tr>
        <td> <center><p style="text-align:center; font-size: 18px; font-weight:bold;">LAPORAN KEHADIRAN EVENT</p></center></td>
        </tr>
        <tr>
        <td> <center><p style="text-align:center; font-size: 12px; font-weight:bold;">www.optimajasa.co.id</p></center></td>
        </tr>
    </table><br />
         <table>
         <tr>
        <td><td><p style="text-align:left; font-size: 12px; font-weight:bold;">Dari Tanggal : <?php echo $_GET['kd']; ?> </p></td></td>
        <td><td><p style="text-align:left; font-size: 12px; font-weight:bold;">Sampai Tanggal : <?php echo $_GET['kode']; ?> </p></td></td>
        </tr>
         </table>
         
    <div id="content">
         
        <div id="invoice_body">
        <?php
            $kd=$_GET['kd'];
            $kode=$_GET['kode'];
            $query1="SELECT kehadiran.*, karyawan.* FROM  kehadiran, karyawan 
	               where kehadiran.nik=karyawan.nik AND(kehadiran.tanggal between '$kd'
	               and '$kode')";
        
            $tampil=mysqli_query($koneksi, $query1) or die(mysqli_error());
            ?>
            <table border="1">
            
            <tr>
                <td style="width:10%;"><b>Nik</b></td>
                <td style="width:20%;"><b>Nama</b></td>
                <td style="width:15%;"><b>Tanggal</b></td>
                <td style="width:45%;"><b>Event</b></td>
                <td style="width:10%;"><b>Status</b></td>
            </tr>
            <?php
            $no=0;
                     while($data1=mysqli_fetch_array($tampil))
                    { $no++; ?>
            <tr>
                <td style="width:10%;" class="mono"><center><b><?php echo $data1['nik']; ?></b></center></td>
                <td style="width:20%;" class="mono"><center><b><?php echo $data1['nama']; ?></b></center></td>
                <td style="width:15%;" class="mono"><center><b><?php echo $data1['tanggal']; ?></b></center></td>
                <td style="width:45%;" class="mono"><center><b><?php echo $data1['event']; ?></b></center></td>
                <td style="width:10%;" class="mono"><center><b><?php echo $data1['status']; ?></b></center></td>
            </tr>         
             <?php   
              } 
              ?>
        </table>
        </div>
        <!--<div id="invoice_total">
            <table border="1">
                <tr>
                  <td colspan="3" style="width:10%;" class="mono"><b><center>Total</b></center></td>  
                  <td style="width:15%;" class="mono"><b>Rp. <?php // echo number_format($data1['pro'],0,",","."); ?></b></td>
                  <td style="width:15%;" class="mono"><b>Rp. <?php // echo number_format($data1['tot'],0,",","."); ?></b></td>
                </tr>
            </table>
        </div>-->
         
        <!--<table border="1" style="width:100%; height:35mm;">
            <tr >
               <td style="border: 1px solid black; border-top: 1px solid black;"><center><b>Kepala</b></center></td>
              <td style="border: 1px solid black; border-top: 1px solid black;"><center><b>Wali Kelas</b></center></td>
               <td style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid white; border-top: 1px solid white;" rowspan="8"></td>
               <td style="border: 1px solid black; "><center><b>Orang Tua Siswa</b></center></td>
               <td style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid white; border-top: 1px solid white;" rowspan="8"></td>
               <td style="border: 1px solid black;"><center><b>Siswa</b></center></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="border-right: 1px solid black;"></td>
            </tr>
             <tr>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white; border-right: 1px solid black;"></td>
            </tr>
            <tr>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white; border-right: 1px solid black;"></td>
            </tr>
            <tr>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1p solid white; border-right: 1px solid black;"></td>
            </tr>
            <tr>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1px solid white;"></td>
            <td style="border-top: 1p solid white; border-right: 1px solid black;"></td>
            </tr>
            <tr>
            <td style="border-bottom: 1px solid black;"><center></center> </td>
            <td style="border-bottom: 1px solid black;"><center></center></td>
            <td style="border-bottom: 1px solid ;"><center> </center></td>
            <td style="border-bottom: 1px solid black; border-right: 1px solid black;"><center></center></td>
            
            </tr>
        </table>-->
    </div>
    <br />
    </div>
     
     <?php

$html = ob_get_contents(); //Proses untuk mengambil data
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,1);

$mpdf->Output($nama_file."-".date("Y/m/d H:i:s").".pdf" ,'I');

 


exit; 
?>
</body>
</html>