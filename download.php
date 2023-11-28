<?php
$sname=$_GET['sname'];
$cname=$_GET['cname'];
$lmode=$_GET['lmode'];
$level=$_GET['clevel'];
$maxid=$_GET['maxid']+1;
$dptc=$_GET['dptc'];

include_once('tcpdf/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
// set document information
$pdf->SetCreator('MIST');
$pdf->SetTitle('Admission Form');
	
// set default header data
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderData('./images/mist.png', PDF_HEADER_LOGO_WIDTH, '', '', array(0,0,0), array(255, 255, 255));

// set default footer data

$pdf->setFooterData(array(0,64,0), array(0,64,128));

$pdf->SetMargins(20, 0, 20, true);
$pdf->AddPage('P',"A4");
date_default_timezone_set('Africa/Nairobi');
$dateYmd = date('Y-m-d');
$mnth=date('m');$yr=date('Y');
 $html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
      <div class="row col-xs-8 block2 center">

 <div align="middle"><img src="./images/header.png" width="800px"/></div>
<p style="font-size:11px; font-family: "Times New Roman", Times, serif;line-height: 1;">Our Ref: $level<br>
Date: $dateYmd			<br>				
Dear $sname <br>
<b><u>RE: ADMISSION LETTER</u></b><br>
Congratulations.<br>
We are pleased to offer you an admission to pursue $cname. Your admission number is ($dptc$level/$mnth$maxid/$yr) and you have been admitted under $lmode mode of study. Your personalized email address is ($dptc$level/$mnth$maxid/$yr@mist.ac.ke) and your first-time password is 123456789.
You are joining thousands of others who have benefitted from the academic and holistic training offered by this great institution.<br>
You are required to report on 4th January 2023 (reporting date) and not later than 13th January 2023 (close of reporting). You can find a copy of your fees statement from your students’ portal. To login to your student’s portal, download the app from Google Play Store and use your admission number and 123456789 as your first-time login password. 
Our fees payment policy requires you to pay at least 50% of the fees when reporting or at the beginning of the term, 30% by 5th of the second month and 20% by 5th of the third month.
At admission, you are expected to bring your academic papers, a copy of your ID and Birth Certificate, three passport size photos, two reams of printing paper and one ream of foolscaps. You are also expected to pay ksh 1500 for your Polo school T-shirt and smart ID..
Below are our fees payment details:<br>
<b>KCB BANK 1302441078<br>
MPESA PAYBILL NO: 4096183 (Write your full admission number as your Account Number e.g. $dptc$level/$mnth$maxid/$yr)
</b>
<br>
You are allowed to change your course of study or defer your studies within the first two weeks of reporting.
Once more congratulations on securing a chance to study with the Musket1eers Institute of Science and Technology, Your Technical Training Partner. 
<br><br>
Sincerely yours,</b><p style="font-size:12px; font-family: "Times New Roman", Times, serif;line-height: 0.8;">
<img src="./images/sign.png" width="50px"/>
<p style="font-size:11px; font-family: "Times New Roman", Times, serif;line-height: 1;"><b>MBOMA, PATRICK MULWA</b><br>
<b>REGISTRAR</b></p>
</p><br>
 <div align="middle"><img src="./images/footer.png" width="800px"/></div></div>
<?php
EOF;

$pdf->writeHTML($html, true, false, true, false, ''); 

//Close and output PDF document
$pdf->Output('AdmissionForm.pdf', 'D');
?>