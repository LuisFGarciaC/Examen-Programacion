<?php

	include("conexion/conexion.php");
	
	$cn = Conexion();

	if(substr($_FILES['archivo_csv']['name'], -3)=="csv")
	{
		$fecha 		= date('Y-m-d');
		$carpeta 	= "tmp_excel/";
		$n_archivo  = $fecha.'-'.$_FILES['archivo_csv']['name'];

		$row = 1;

		move_uploaded_file($_FILES['archivo_csv']['tmp_name'], $carpeta.$n_archivo);

		$fp = fopen($carpeta.$n_archivo, "r");

		while($data = fgetcsv($fp, 1000, ","))
		{
			if($row!=1)
			{
				$sql_archivo  = "INSERT INTO datos(nombres,apellidos,direccion,celular)";
				$sql_archivo .= "VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')";

				$rpta_archivo = mysqli_query($cn,$sql_archivo) or die(mysqli_error($cn));

				if(!$sql_archivo)
				{
					echo "Hubo un problema. Por favor siga participando";
					exit;					
				}

			}

		$row++;

		}

		fclose($fp);

		echo "El archivo CSV se a subido exitosamente";

		exit();

	}