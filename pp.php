<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
/*	require 'sqlbase.php';*/
	require 'data.php';
	require 'datapunto.php';
	
	

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$datos = json_decode(file_get_contents("php://input"),true);
		$inicio=$datos["inicio"];	
		$final=$datos["final"];
		$area=$datos["area"];
		$plataforma=$datos["plataforma"];
		$responsable=$datos["responsable"];
		$medio=$datos["medio"];
		$punto=$datos["punto"];
		$tipo=$datos["tipo"];
		$dir='D:\\Proyect\\2020tick\\git\\pag\\db.sqlite3';
		//$dir='C:\\Users\\Admin\\Bitnami Django Stack projects\\pag\\db.sqlite3';
		//$dir='D:\\Proyectos\\2021\\pag\\db.sqlite3';
		if($tipo=="punto"){
			$respuesta2 = datapunto::Selecciona_reporte0054($inicio,$final,$area,$plataforma,$punto,$dir);	
		}else{
			$respuesta2 = data::Selecciona_reporte0054($inicio,$final,$area,$plataforma,$punto,$dir);
		
		}		
		    $time = strtotime($inicio);
			$time2 = strtotime($final);
			$inicio = date('d-m-Y', $time); 
			$final = date('d-m-Y', $time2); 
		$respuesta = '<!DOCTYPE html>
		<html lang="en"><head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<link rel="shortcut icon" href="imagenes/sin3.ico" type="image/x-icon">
			<link rel="stylesheet" href="css/style.css">
			<!--<title>Reporte</title>-->
		</head>		
		<body>
			<div class="hoja">
				<div class="margen">
		
					<div id="encabezado">
						<div id="logo-impuestos">
							<img class="imagen" src="imagenes\logos_impuestos.png" />
						</div>
						<div id="detalles-formulario">
							<div id="nombre-codigo-detalle-reporte">
								<p class="texto_8_5_negrita">Código:</p>
							</div>
							<div id="codigo-detalle-reporte">
								<p class="texto_8_5">R-0054-01</p>
							</div>
							<div id="detalles-detalle-reporte">
								<div id="version-formulario-reporte">
									<div id="nombre-version-formulario-reporte">
										<p class="texto_8_5_negrita">Versión:</p>
									</div>
									<div id="codigo-version-formulario-reporte">
										<p class="texto_8_5">3</p>
									</div>
								</div>
								<div id="nro-pagina-formulario-reporte">
									<div id="nombre-nro-pagina-formulario-reporte">
										<p class="texto_8_5_negrita">N° de Página</p>
									</div>
									<div id="codigo-nro-pagina-formulario-reporte">
										<span><span class="texto_8_5_negrita">1</span><span class="texto_8_5"> de </span><span class="texto_8_5_negrita">1</span></span>
									</div>
								</div>
							</div>
						</div>
						<div id="titulo-reporte">
							<h1 class="titulo_principal">REGISTRO DE CONSULTAS ATENDIDAS</h1>
						</div>
					</div>
		
					<div id="cuerpo">
						<div id="totales-fijos">
							<div id="totales-fijos-titulos">
								<div class="totales-fijos-titulos-1">
									<p class="texto_6_5_negrita_blanco">SERVICIO Y/O MEDIO UTILIZADO:&nbsp;&nbsp;</p>
								</div>
								<div class="totales-fijos-titulos-2">
									<p class="texto_6_5_negrita">DEPENDENCIA OPERATIVA:&nbsp;&nbsp;</p>
								</div>
								<div class="totales-fijos-titulos-2">
									<p class="texto_6_5_negrita">RESPONSABLE SAC/SUPERVISOR DE MEDIOS:&nbsp;&nbsp;</p>
								</div>
								<div class="totales-fijos-titulos-2">
									<p class="texto_6_5_negrita">PERIODO DE INFORME:&nbsp;&nbsp;</p>
								</div>
								<div class="totales-fijos-titulos-2">
									<p class="texto_6_5_negrita">Nº DE PERSONAS ATENDIDAS PRESENCIALES/CHATS:&nbsp;&nbsp;</p>
								</div>
								<div class="totales-fijos-titulos-2">
									<p class="texto_6_5_negrita">Nº DE PERSONAS ATENDIDAS LLAMADAS TELEFÓNICAS:&nbsp;&nbsp;</p>
								</div>
								<div class="totales-fijos-titulos-2">
									<p class="texto_6_5_negrita">TOTAL Nº DE PERSONAS ATENDIDAS:&nbsp;&nbsp;</p>
								</div>
							</div>
							';
							$contador = 0;
							$nombre_padre_aux = "";
							$cantidad_sumada = 0;
							$cantidad_total_sumada = 0;
							$cantidad_nombres = 0;
							$cambia_columnas = 1;
							$primera_columna = '<div id="detalle-regigistro-segun-tema-consulta-1">';
							$segunda_columna = '<div id="detalle-regigistro-segun-tema-consulta-2">';

							if($respuesta2){			
								$contenedor["resultado"] = $respuesta2;
								
								$arrayx = json_encode($contenedor);
								$array=json_decode($arrayx);
								$i=0;
								foreach ($array as $obj) {
									$aux = json_encode($obj);
									$array2=json_decode($aux);
									$j=0;
									
									foreach($array2 as $obj2){               
										$j++;
										$aux3 = json_encode($obj2);
										$aux2 = json_decode($aux3);

										$cantidad_sumada_aux = (int) $aux2->cantidad;
										$cantidad_total_sumada = $cantidad_total_sumada + $cantidad_sumada_aux;
										if($cambia_columnas==1){
											if($aux2->nombre_padre == $nombre_padre_aux){//nombre de padre con el anterior nombre de padre
												$primera_columna = $primera_columna . '												
												<div class="caja-simple-detalle-registro-segun-consulta">
													<div class="nombre-caja-simple-detalle-registro-segun-consulta2">
														<p class="texto_4_5">&nbsp;&nbsp;'.$aux2->nombre_tramite.''.'</p>
													</div>
													<div class="cantidad-caja-simple-detalle-registro-segun-consulta2">
														<p class="texto_4_5">'.$aux2->cantidad.'&nbsp;&nbsp;</p>
													</div>
												</div>';
												$cantidad_sumada_aux = 0;
												$cantidad_sumada_aux = (int) $aux2->cantidad;
												$cantidad_sumada = $cantidad_sumada + $cantidad_sumada_aux;
											}else{
												if($contador!=0){
													$primera_columna = $primera_columna . '
													<div class="caja-titulo-detalle-registro-segun-consulta">
														<div class="nombre-caja-simple-detalle-registro-segun-consulta">
															<p class="texto_6_5_blanco">'.$nombre_padre_aux.'&nbsp;&nbsp; </p>
														</div>
														<div class="cantidad-caja-simple-detalle-registro-segun-consulta">
															<p class="texto_6_5_blanco">'.$cantidad_sumada.'&nbsp;&nbsp; </p>
														</div>
													</div>
													';
													$cantidad_sumada = 0;
												}else{
													$respuesta = $respuesta . '<div id="totales-fijos-cantidades">
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">'.$medio.'</p>
																					</div>
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">'.$plataforma.'</p>
																					</div>
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">'.$responsable.''.'</p>
																					</div>
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">'.$inicio.' al '.$final.'</p>
																					</div>
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">'.$aux2->cantidad_total.'</p>
																					</div>
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">0</p>
																					</div>
																					<div class="totales-fijos-titulos-3">
																						<p class="texto_6_5">'.$aux2->cantidad_total.'</p>
																					</div>
																				</div>
																			</div>
																			<div id="subtotales-dinamicos">
																				<div class="titulo-simple-detalle-registro">
																					<p class="texto_6_5_blanco">DETALLE DE REGISTRO SEGÚN TEMA DE CONSULTA:</p>
																				</div>
																				<div id="detalle-regigistro-segun-tema-consulta">';
												}
												if($contador!=0){
													$segunda_columna = $segunda_columna . '
													<div class="caja-simple-detalle-registro-segun-consulta">
														<div class="nombre-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">&nbsp;&nbsp;'.$aux2->nombre_tramite.''.'</p>
														</div>
														<div class="cantidad-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">'.$aux2->cantidad.'&nbsp;&nbsp; </p>
														</div>
													</div>
													';
												}
												if($contador==0){
													$primera_columna = $primera_columna . '
													<div class="caja-simple-detalle-registro-segun-consulta">
														<div class="nombre-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">&nbsp;&nbsp;'.$aux2->nombre_tramite.''.'</p>
														</div>
														<div class="cantidad-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">'.$aux2->cantidad.'&nbsp;&nbsp; </p>
														</div>
													</div>
													';
												}
												$nombre_padre_aux=$aux2->nombre_padre;
												$cantidad_nombres++;
												if($contador!=0){
													$cambia_columnas=2;
												}
												// $i--;
												$cantidad_sumada_aux = 0;
												$cantidad_sumada_aux = (int) $aux2->cantidad;
												$cantidad_sumada = $cantidad_sumada + $cantidad_sumada_aux;
											}
											$contador++;
										}else{
											if($aux2->nombre_padre == $nombre_padre_aux){//nombre de padre con el anterior nombre de padre
												$segunda_columna = $segunda_columna . '
												<div class="caja-simple-detalle-registro-segun-consulta">
													<div class="nombre-caja-simple-detalle-registro-segun-consulta2">
														<p class="texto_4_5">&nbsp;&nbsp;'.$aux2->nombre_tramite.'</p>
													</div>
													<div class="cantidad-caja-simple-detalle-registro-segun-consulta2">
														<p class="texto_4_5">'.$aux2->cantidad.'&nbsp;&nbsp; </p>
													</div>
												</div>
												';
												$cantidad_sumada_aux = 0;
												$cantidad_sumada_aux = (int) $aux2->cantidad;
												$cantidad_sumada = $cantidad_sumada + $cantidad_sumada_aux;
											}else{
												if($contador!=0){
													$segunda_columna = $segunda_columna . '
													<div class="caja-titulo-detalle-registro-segun-consulta">
														<div class="nombre-caja-simple-detalle-registro-segun-consulta">
															<p class="texto_6_5_blanco">'.$nombre_padre_aux.'&nbsp;&nbsp; </p>
														</div>
														<div class="cantidad-caja-simple-detalle-registro-segun-consulta">
															<p class="texto_6_5_blanco">'.$cantidad_sumada.'&nbsp;&nbsp; </p>
														</div>
													</div>
													';
													$cantidad_sumada = 0;
												}
												if($contador!=0){
													$primera_columna = $primera_columna . '
													<div class="caja-simple-detalle-registro-segun-consulta">
														<div class="nombre-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">&nbsp;&nbsp;'.$aux2->nombre_tramite.'</p>
														</div>
														<div class="cantidad-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">'.$aux2->cantidad.'&nbsp;&nbsp; </p>
														</div>
													</div>
													';
												}
												if($contador==0){
													$segunda_columna = $segunda_columna . '
													<div class="caja-simple-detalle-registro-segun-consulta">
														<div class="nombre-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">&nbsp;&nbsp;'.$aux2->nombre_tramite.'</p>
														</div>
														<div class="cantidad-caja-simple-detalle-registro-segun-consulta2">
															<p class="texto_4_5">'.$aux2->cantidad.'&nbsp;&nbsp; </p>
														</div>
													</div>
													';
												}
												$nombre_padre_aux=$aux2->nombre_padre;
												$cambia_columnas=1;

												$cantidad_sumada_aux = 0;
												$cantidad_sumada_aux = (int) $aux2->cantidad;
												$cantidad_sumada = $cantidad_sumada + $cantidad_sumada_aux;
											}
											$contador++;
										}
									}
								}

							}else{            
								$contenedor["resultado"] = 'Ocurrio un Error inesperado'.$respuesta;
								//echo json_encode($contenedor);
							}


							if($cambia_columnas==1){
								$primera_columna = $primera_columna . '
									<div class="caja-titulo-detalle-registro-segun-consulta">
										<div class="nombre-caja-simple-detalle-registro-segun-consulta">
											<p class="texto_6_5_blanco">'.$nombre_padre_aux.'&nbsp;&nbsp; </p>
										</div>
										<div class="cantidad-caja-simple-detalle-registro-segun-consulta">
											<p class="texto_6_5_blanco">'.$cantidad_sumada.'&nbsp;&nbsp; </p>
										</div>
									</div>
									';
							}else{
								$segunda_columna = $segunda_columna . '
									<div class="caja-titulo-detalle-registro-segun-consulta">
										<div class="nombre-caja-simple-detalle-registro-segun-consulta">
											<p class="texto_6_5_blanco">'.$nombre_padre_aux.'&nbsp;&nbsp; </p>
										</div>
										<div class="cantidad-caja-simple-detalle-registro-segun-consulta">
											<p class="texto_6_5_blanco">'.$cantidad_sumada.'&nbsp;&nbsp; </p>
										</div>
									</div>
									';
							}

							$primera_columna = $primera_columna . '</div>';
							$segunda_columna = $segunda_columna . '</div>';

							$respuesta = $respuesta . $primera_columna;
							$respuesta = $respuesta . $segunda_columna;


							$respuesta = $respuesta .  '</div>
							<div class="espacio-5pt">
							</div>
							<div class="titulo-simple-detalle-registro3">
								<p class="texto_6_5_blanco">TOTAL CONSULTAS ATENDIDAS</p>
							</div>
							<div class="titulo-simple-detalle-registro4">
								<p class="texto_6_5_blanco">'.$cantidad_total_sumada.'&nbsp;&nbsp; </p>
							</div>
							<br><br><br><br><br>
							<div class="titulo-simple-detalle-registro5">
								<!--p class="texto_10_5">Firma y Sello RSAC/JAT/SAD</p-->
							</div>
						</div>
					</div>
				</div>				
			</div>
		</body>		
		</html>';
		if($respuesta){			
			$contenedor["resultado"] = $respuesta;
			$respuesta = preg_replace("/[\r\n|\n|\r]+/", " ", $respuesta);
			$respuesta = preg_replace('/[ \t]+/', ' ', $respuesta);
			$json = json_encode($respuesta);
			
			echo '{"response":"si","contenido":'.$json.'}';
	
			return json_encode($contenedor);
		}else{
			$contenedor["resultado"] = 'Ocurrio un Error inesperado'.$respuesta;
			echo '{"response":"si"}';
		}
	}
?>