<?php
header('Access-Control-Allow-Origin: *');
/*echo jsondecode(data::Selecciona_reporte0054());*/
class datapunto{
    function _construct(){
    }   

    static function Selecciona_reporte0054($inicio,$final,$area,$plataforma,$punto){ 
    
    //$db = new SQLite3('C:\\Users\\Admin\\Bitnami Django Stack projects\\pag\\db.sqlite3');
    //$db = new SQLite3('D:\\Proyect\\2020tick\\git\\pag\\db.sqlite3');
    $db = new SQLite3("D:\\Proyectos\\2021\\pag\\db.sqlite3");
	
    $time = strtotime($inicio);
    $time2 = strtotime($final);
    $ini = date('Y-m-d', $time); 
    $fin = date('Y-m-d', $time2); 
    $sql = "SELECT * 
    FROM (SELECT *
    FROM(SELECT 
        (SELECT descripcion FROM ticketera_subtramite st where  st.id=tt.subTramite_id) as nombre_tramite,
		(SELECT orden FROM ticketera_subtramite st where  st.id=tt.subTramite_id) as subtramite_orden,
        (SELECT descripcion FROM ticketera_tramite tr WHERE tr.id=tt.tramite_id) as nombre_padre,
        (SELECT count(DISTINCT atencion_id) as cantidad
         from ticketera_atenciontramite
         where ticketera_atenciontramite.atencion_id in
        (SELECT id 
        FROM ticketera_atencion
        WHERE   ticketera_atencion.inicio >= '".$ini."' AND
            	ticketera_atencion.inicio <= '".$fin."' AND
                ticketera_atencion.punto_id = ".(int)$punto.")		
		) as cantidad_total,
        (select count(id)
        FROM ticketera_atenciontramite
        WHERE ticketera_atenciontramite.tipoTramite_id = 
        (
        SELECT id
        FROM ticketera_tipotramite
        WHERE 		
		ticketera_atenciontramite.inicio >= '".$ini."'"." AND /*inicio de atencion*/
		ticketera_atenciontramite.inicio <= '".$fin."'"." AND /*final de atencion*/
        ticketera_atenciontramite.atencion_id IN (
            select id 
            FROM ticketera_atencion	
            WHERE ticketera_atencion.punto_id=".(int)$punto.") AND
		ticketera_tipotramite.subTramite_id=tt.id
        )) as cantidad,
        (SELECT orden FROM ticketera_tramite tr WHERE tr.id=tt.tramite_id) as orden
        FROM ticketera_tipotramite tt
        WHERE tt.area_id =".(int)$area."
       ) tttt
		
        UNION
        SELECT 
            'FORMULARIO R-058-01' AS nombre_tramite,
			1 as subtramite_orden,
            'LLENADO EXCLUSIVO DEL CALL CENTER (GSCCT - DSC)' AS nombre_padre,
            0 AS cantidad_total,
            0 AS cantidad,
            8 AS orden
        UNION
        SELECT 
            'INSTITUCIONAL (NOMBRE DE AUTORIDADES, DIRECCIONES Y OTROS)' AS nombre_tramite,
			1 as subtramite_orden,
            'LLENADO EXCLUSIVO DEL CALL CENTER (GSCCT - DSC)' AS nombre_padre,
            0 AS cantidad_total,
            0 AS cantidad,
            8 AS orden
        
        ) rsr ORDER BY rsr.orden,rsr.subtramite_orden
		";
    $result = $db->query($sql);
    $rawdata = array();
    $i=0;
    while ($row = $result->fetchArray()) {
        //var_dump($row);
        $rawdata[$i] = $row;
        $i++;
    }
    return $rawdata;    
    }
}


