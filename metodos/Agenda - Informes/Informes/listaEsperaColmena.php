
 


<?php
//session_name("agenda2");
    //session_start();
    include ('../../../lib/conectar.php');
    //include('../../../lib/datos.php');
    //include('../../../lib/isapres/funciones.php');
	

    $conectar = conectar();
    
    ?>
<div align="center">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" class="titulo3"><h1>Lista de Espera Colmena</h1></td>
	</tr>
</table>
<form id="form1" name="form1" method="post" action="chk_listaEsperaColmena.php">
<input name="button" type="submit" class="botonNormal" id="button" style=" cursor: pointer" value="Exportar" />
<br>


    
        <?php 
            $sql = mysql_query("
            SELECT 
                    c.lisFecha,c.lisComuna,comunaine.NombreComuna,lisFinLicencia,lisFueraPlazo,lisGlosa
            FROM 
                    lista_espera_colmena c
            INNER JOIN `comunaine` ON (c.lisComuna = comunaine.codComuna)
	    ORDER BY c.lisComuna;
            
            ", $conectar);
		$contar = 0;

            	while($row = mysql_fetch_array($sql))
            	{
		$fecha = $row[lisFecha];
		$contar += 1;
		}
	;?>
<br>
<div align="center" style="font-size:140%">Fecha de Sincronizacion: <b>
	<?php echo $fecha; ?></b>
</div>
<div align="center" style="font-size:140%">Peritajes Pendientes: <b>
	<?php echo $contar; ?></b>
</div>
<br>
<table>
    <tr>
       <th align="center">Comuna - </th><th align="center">Fecha Termino de Licencia - </th><th align="center">Fuera de Plazo - </th><th>Especialidad</th>
    </tr>            
	
	<?php 
            $sql = mysql_query("
            SELECT 
                    c.lisFecha,c.lisComuna,comunaine.NombreComuna,lisFinLicencia,lisFueraPlazo,lisGlosa
            FROM 
                    lista_espera_colmena c
            INNER JOIN `comunaine` ON (c.lisComuna = comunaine.codComuna)
	    ORDER BY c.lisComuna;
            
            ", $conectar);

	while($row = mysql_fetch_array($sql))
            {
       	?>
    <tr>
<?php 
	$comuna = str_replace('í','i',$row[NombreComuna]);
	$comuna = str_replace('ó','o',$comuna);
	$comuna = str_replace('ñ','n',$comuna);
	$comuna = str_replace('Á','A',$comuna);
	$comuna = str_replace('á','a',$comuna);
?>
       <td align="center"><?php echo $comuna; ?></td><td align="center"><?php echo $row['lisFinLicencia']; ?></td><td align="center"><?php IF ($row[lisFueraPlazo] == '0')echo 'NO'; ELSE IF ($row[lisFueraPlazo] == '1')echo 'SI'; ?></td><td align="center"><?php echo $row['lisGlosa']; ?></td>
    </tr>
            <?php 
            }
            ?>
   
</table>

</form>


</div>

                            
