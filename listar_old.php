<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
<div id="area">
<?php
//echo "menu ediciones";

//---recepcion de variables --------------------

$cursoid=$_POST['edcursoid'];

// Variables para condicionales ----------------

$aedicionid=$_POST['aedicionid'];
$bedicionid=$_POST['bedicionid'];


//----------------------------------------------


//---condicional para altas---------------------
if($aedicionid){

  
  $sql1="UPDATE vm_mame_resumen_ediciones
            SET estadoid= '1',
                auditoria_usu = '$usu',
                auditoria_fecha = SYSDATE   
          WHERE resumen_edicionid = '$aedicionid'";

  $consulta=sql_do_query($sql1,'0',$usu);
  header("Location: index.php?estado=110");
}
//---------------------------------------------

//---condicional para bajas---------------------
if($bedicionid){
  $sql2="UPDATE vm_mame_resumen_ediciones
            SET estadoid= '0',
                auditoria_usu = '$usu',
                auditoria_fecha = SYSDATE  
          WHERE resumen_edicionid = '$bedicionid'";
  $consulta=sql_do_query($sql2,'0',$usu);
  header("Location: index.php?estado=110");
}
//---------------------------------------------

?>

<table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td class="fondo-III_sup_500">&nbsp;</td>
    </tr>
</table>
<table width="500" border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF'>
  <tr class="fondo-I">
    <td valign="middle" align='center'><strong>Sel. de Curso: </strong></td>
    <td valign="middle">
    <table width="300" border="0">
            <tr class="fondo-I">
              <td align="center">
              <form action="" method="post" name="curso">
                  <?php 
                        $sql = "SELECT a.resumen_cursoid AS id,
                                       a.nombre
                                  FROM vm_mame_resumen_cursos a
                                 WHERE  a.estadoid = 1;";
                        echo $cur = imp_combo_w( 'edcursoid', $sql, '1', $usu, $cursoid);
                        
                  ?>
              </td>
              <td align="center">
                  <input type="submit" value=" >> " />
              </td>
              </form>
              </td>
            </tr>
     </table>
     </td>
  </tr>
</table>
<table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td class="fondo-III_inf_500">&nbsp;</td>
    </tr>
</table>
<br />
<?php

if($cursoid){
              $sql=" SELECT rc.nombre
                       FROM vm_mame_resumen_cursos rc
                      WHERE rc.resumen_cursoid = '$cursoid';";
			//echo $sql;
		    $result = sql_do_query($sql,'1',$usu);
			$row=sql_do_array($result);

?>

		    		<table width="800" border="0" cellspacing="0" cellpadding="0">
						<tr class="fondo-III_sup_800">
							<td align="center">LISTADO DE EDICIONES DEL CURSO <?php echo substr(strtoupper($row['NOMBRE']), 0, 50);?>...</td>
						</tr>
					</table>

					<table width="800" border="1" cellpadding="0" cellspacing="0" bordercolor="#DFE4F9">
						<tr class="subt_chico_color_fondo_cent">
							<th>EDICION</th>
							<th>ESCUELA</th>
							<th>CIERRE INSC</th>
                            <th>INICIO</th>
							<th>ESTADO</th>      
							<th colspan="3">OPCIONES</th>
						</tr>
				
<?php

$sql="
                    SELECT re.resumen_edicionid, 
                           re.resumen_cursoid, 
                           re.cuatrigrama, 
                           e.nombre AS escuela, 
                           re.fecha_desde, 
                           re.fecha_cierre_inscripcion,
                           re.estadoid
                      FROM vm_mame_resumen_ediciones re, 
                           mame_efocapemm e
                     WHERE re.cuatrigrama = e.cuatrigrama
                       AND re.resumen_cursoid = '$cursoid';
            ";
          //echo $sql;
	      $result = sql_do_query($sql,'1',$usu);
		  
		  while($row=sql_do_array($result))
		  {
        	if($row['ESTADOID']=='0'){
        		$estado = "<strong>INACTIVO</strong>";
        	}else{
        		$estado =  "ACTIVO";
        	}

?> 
            <tr class="fondo-I" height="40">
              <td align="center"><?php echo $row['RESUMEN_EDICIONID'];?></td>
              <td><?php echo $row['ESCUELA'];?></td>
              <td align="center"><?php echo enmascararFecha($row['FECHA_CIERRE_INSCRIPCION']);?></td>
              <td align="center"><?php echo enmascararFecha($row['FECHA_DESDE']);?></td>
              <td align="center"><?php echo $estado;?> </td>
              <td align="center">    
                                  <form id="form1" name="form1" method="post" action="">
                                    <input type="hidden" name="aedicionid" value="<?php echo $row['RESUMEN_EDICIONID'];?>"/>
                                    <input type="submit" name="aboton" id="aboton" value="Alta" />
                                  </form>
              </td>
              <td align="center">
                                  <form id="form2" name="form2" method="post" action="">
                                    <input type="hidden" name="bedicionid" value="<?php echo $row['RESUMEN_EDICIONID'];?>"/>
                                    <input type="submit" name="bboton" id="bboton" value="Baja" />
                                  </form>
              </td>
              <td align="center">    
                                  <form id="form3" name="form3" method="post" action="index.php?estado=114">
                                    <input type="hidden" name="bedicionid" value="<?php echo $row['RESUMEN_EDICIONID'];?>"/>
                                    <input type="submit" name="cboton" id="cboton" value="Modificar" />
                                  </form>
              </td>

            </tr>
<?php
     	}
?>
	</tbody>
</table>
			<table width="800" border="0" cellspacing="0" cellpadding="0">
						<tr class="fondo-III_inf_800">
							<td>&nbsp;</td>
						</tr>
		    </table>
<?php
     	}
?>
             
<br/>
</div>
