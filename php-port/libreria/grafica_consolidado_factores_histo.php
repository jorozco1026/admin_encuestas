<?php                                
require_once(toba_dir() . '/php/3ros/libchart/libchart/classes/libchart.php');
class grafica_consolidado_factores_histo  {	
    static function construir_grafica() 	{    
	    $fp_imagen = toba::proyecto()->get_www_temp('demo5.png');  
	    $chart = new PieChart();

	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("Mozilla Firefox (80)", 80));
	$dataSet->addPoint(new Point("Konqueror (75)", 75));
	$dataSet->addPoint(new Point("Opera (50)", 50));
	$dataSet->addPoint(new Point("Safari (37)", 37));
	$dataSet->addPoint(new Point("Dillo (37)", 37));
	$dataSet->addPoint(new Point("Other (72)", 70));
	$chart->setDataSet($dataSet);

	$chart->setTitle("User agents for www.example.com");
	    
	         
		$path = toba::proyecto()->get_www_temp('demo5.png');
		$url = $path['url']; 
		$chart->render($url);  
	           
      	  
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libchart line demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
	<img alt="Line chart" src="C:\proyectos\toba_1_4/proyectos/sisalertas/www/temp/demo5.png" style="border: 1px solid gray;"/>
</body>
</html>

