<?php
$con  = new mysqli("localhost", "root", "", "BDReproductor");
$sql = "SELECT LISTA_id FROM listaiframe ";
if($resultado=mysqli_query($con, $sql))
{
	while ($lista=mysqli_fetch_object($resultado))
	{
		echo $lista->LISTA_id;
	
	}
}
?>