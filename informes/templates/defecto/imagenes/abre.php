<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/html2pdf/html2pdf.class.php');
	include('../../../lib/datos.php');
 	ob_start();

?>

<table width="118" height="66" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="78%" height="66" align="left" valign="top">hola
       <img src="/public_html/agenda/contenido/templates/defecto/imagenes/logoDocumentos.jpg" width="86" height="62" /></td>
    </tr>
</table>
<?php
	$content = ob_get_clean();
	$html2pdf = new HTML2PDF('P','Letter','es', array(20, 20, 20, 20));
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('Certificado.pdf');
?>