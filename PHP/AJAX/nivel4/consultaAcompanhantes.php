<?php
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	$serverName		= '192.168.252.12\NODUM-SERVER,1433';
	$connectionInfo	= array
	(
		'Database'		=> (string)	'nodum',
		'UID'			=> (string)	'consultas',
		'PWD'			=> (string)	'consultas.2k19',
		'CharacterSet'	=> (string)	'UTF-8'
	);
	$conexion = sqlsrv_connect( $serverName, $connectionInfo);

	if(!$conexion)
	{
		echo "Conexión no se pudo establecer.<br />";
		die(print_r( sqlsrv_errors(), true));
	}

	$q =
	"SELECT
		t.nombre_completo, t.telefono, t.doc_persona, t.fingreso, t.fegreso, d.nom_dpto, t.estado_trab
	FROM
		v_RHTrabajador AS t
	INNER JOIN
		ct_dptos AS d
		ON d.cod_dpto = t.cod_dpto
	WHERE
		t.cod_cargo = 501";
	if($r = sqlsrv_query($conexion, $q))
	{
		if(sqlsrv_has_rows($r))
		{
			while($f = sqlsrv_fetch_array($r, SQLSRV_FETCH_ASSOC))
			{
				var_dump($f);
			}
		}
	}