<?php
	include '../../conexiones/conexion.php';
	$cedula = $_GET['CI'];
	$q = "SELECT cedula
			FROM padron_datos_socio
			WHERE cedula = '$cedula'
			LIMIT 1";
	$r = mysqli_query($conexion, $q);
	if (mysqli_num_rows($r) === 1)
	{
		$q = "SELECT pds.id, pds.nombre, pds.tel, pds.radio, pds.sucursal, pps.idrelacion, SUM(pps.importe) AS importe 
				FROM padron_datos_socio AS pds 
				LEFT JOIN padron_producto_socio AS pps USING(idrelacion) 
					WHERE pds.cedula = $cedula 
				LIMIT 1";
		$r = mysqli_query($conexion, $q);
		if(mysqli_num_rows($r) != 0)
		{
			$f = mysqli_fetch_assoc($r);
			$idrelacion = $f['idrelacion'];
			$q = "SELECT abmactual, abm 
					FROM padron_datos_socio
					WHERE idrelacion	= '$idrelacion' 
						AND abmactual	= 1
						AND abm 		= 'BAJA'
					LIMIT 1";
			$r = mysqli_query($conexion, $q);

			if (mysqli_num_rows($r) != 0)
			{
					$response 	= array(
						'result' => false,
						'bajaGestionada' => true,
						'message' => "La cédula ingresada ya fue dada de baja."
					);
			}
			else
			{
				include '../../conexiones/conexion2.php';
				$q = "SELECT idrelacion
						FROM bajas
						WHERE idrelacion = '$idrelacion'
							AND activo = 1";
				$r = mysqli_query($conexion, $q);
				if (mysqli_num_rows($r) === 0)
				{
					// CORRECCIÓN Y ASIGNACIÓN DE TELÉFONO
						if(strlen($f['tel']) > 7)
						{
							//EN CASO DE QUE EL TELÉFONO EMPIECE CON '0' Y UN ESPACIO LOS QUITA DE LA VARIABLE
							if (mb_substr($f['tel'], 0, 2) == '0 ')
							{
								$f['tel'] = mb_substr($f['tel'], 2, 20);
							}

							//REEMPLAZA TODOS LOS ESPACIOS QUE TENGA LA VARIABLE
							$f['tel'] = str_replace(' ', '', $f['tel']);

							//EN CASO DE QUE EL NÚMERO EMPIECE CON 09 Y TENGA MÁS DE 8 CARACTÉRES SE LE ASIGNA ESE VALOR A LA VARIABLE CELULAR
							if (mb_substr($f['tel'], 0, 2) == '09' && strlen($f['tel']) > 8)
							{
								$celular = mb_substr($f['tel'], 0, 9);
							}

							///EN CASO DE QUE EL NÚMERO EMPIECE CON 2 O 4 Y TENGA MÁS DE 7 CARACTÉRES SE LE ASIGNA ESE VALOR A LA VARIABLE TELEFONO
							if (($f['tel'][0] == 2 || $f['tel'][0] == 4) && strlen($f['tel']) > 7){
								$telefono = mb_substr($f['tel'], 0, 8);
							}

							//SI EL LARGO DE LA VARIABLE ES IGUAL A 17 (LA SUMA DE LOS 9 CARACTERES DE UN TELÉFONO MÁS LOS 8 DE UN CELULAR) DIVIDE EL STRING
							if (strlen($f['tel']) == 17)
							{
								//EN CASO DE QUE CONTENGA LA SINTÁXIS DE TELÉFONO SE LE ASIGNA LA mb_substrING A LA VARIABLE TELEFONO
								if (isset($f['tel'][9]) && ($f['tel'][9] == 2 || $f['tel'][9] == 4) && mb_substr($f['tel'], 7, 9) != '09')
								{
									$telefono = mb_substr($f['tel'], 9, 18);
								}
								//EN CASO DE QUE CONTENGA LA SINTÁXIS DE CELULAR SE LE ASIGNA LA mb_substrING A LA VARIABLE CELULAR
								if (isset($f['tel'][8]) && mb_substr($f['tel'], 8, 2) == '09'){
									$celular = mb_substr($f['tel'], 8, 18);
								}
							}
						}

					//EN CASO DE QUE LA VARIABLE CELULAR NO SE HAYA DEFINIDO LE ASIGNA UN STRING VACÍO PARA NO GENERAR CONFLICTOS EN LA QUERY
					if (!isset($celular))
					{
						$celular = '';
					}
					//EN CASO DE QUE LA VARIABLE TELEFONO NO SE HAYA DEFINIDO LE ASIGNA UN STRING VACÍO PARA NO GENERAR CONFLICTOS EN LA QUERY
					if (!isset($telefono))
					{
						$telefono = '';
					}


					$nombre 	= mb_convert_case($f['nombre'], MB_CASE_TITLE, 'UTF-8');
					$filial 	= $f['sucursal'];
					$importe 	= $f['importe'];
					$idrelacion = $f['idrelacion'];
					$radio 		= $f['radio'];
					$response 	= array(
						'result' 		=> true,
						'cedula' 		=> $cedula,
						'nombre' 		=> $nombre,
						'idrelacion' 	=> $idrelacion,
						'filial' 		=> $filial,
						'celular' 		=> $celular,
						'telefono' 		=> $telefono,
						'importe' 		=> $importe,
						'radio' 		=> $radio
					);
				}
				else
				{
					$response 	= array(
						'result' => false,
						'baja' => true,
						'message' => 'Ya se le está gestionando la baja al socio ingresado.'
					);
				}
			}
		}
		else
		{
			$response 	= array(
				'result' => false,
				'cedula' => true,
				'message' => 'La cédula ingresada no pertenece a un socio actual de Vida.'
			);
		}
	}
	else
	{
		$response 	= array(
			'result' => false,
			'cedula' => true,
			'message' => 'La cédula ingresada no pertenece a un socio actual de Vida.'
		);
	}

echo json_encode($response);