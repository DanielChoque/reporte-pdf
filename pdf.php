<?php
	/*require_once('/vendor/autoload.php');*/
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    require_once __DIR__ . '/vendor/autoload.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
		//echo "ini1";
		$datos = json_decode(file_get_contents("php://input"),true);
		//echo $datos;
		$contenido=$datos["contenido"];
		echo "contenido:".$contenido;
		/*file_put_contents('reporte.html', $contenido);
	
		$css = file_get_contents('css/style.css');

		$textohtml= file_get_contents("reporte.html");
		$textohtmlfoot= file_get_contents("reporte2.html");
		$mpdf = new \Mpdf\Mpdf([
			"format" =>  "Letter"
		]);	
		$mpdf->SetHTMLFooter($textohtmlfoot);
		$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
		$mpdf->writeHtml($textohtml, \Mpdf\HTMLParserMode::HTML_BODY);

		$mpdf->Output("reporte.pdf","I");*/
	}

?>