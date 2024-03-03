<?php
    $JSONData = file_get_contents("php://input");
    $dataObject = json_decode($JSONData);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8');
    /* Call this file 'hello-world.php' */
    require __DIR__ . '/vendor/autoload.php';
    //$imagen= include("archivos/logo.png");
    use Mike42\Escpos\Printer;
    use Mike42\Escpos\EscposImage;
    use Mike42\Escpos\PrintConnectors\FilePrintConnector;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    date_default_timezone_set('America/Mexico_City');
    $hoy = date("Y-m-d H:i:s");   
    if($dataObject){
        $connector = new WindowsPrintConnector("POS-80C");
        $printer = new Printer($connector);
        //$printer -> text("$imagen\n");
        //$img = EscposImage::load("archivos/logo.png");
        //$printer -> graphics($img);
        $printer -> setTextSize(4,3);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Waffleria\n\n\n");
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(1,1);
        $printer -> text("Fecha: $hoy\n\n");
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("Camida                             Precio   Cant\n\n");
        $precio_total=0;
        $cantidad_total=0;
        foreach($dataObject as $item ){
            //$productos=($item->producto);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $printer -> text("$item->producto"."                  "."$item->precio"."     "."$item->cantidad\n");
            $precio_total=$precio_total+$item->precio;
            $cantidad_total=$cantidad_total+$item->cantidad;
            //$printer -> setJustification(Printer::JUSTIFY_CENTER);
           // $printer -> text("$item->precio");
            //$printer -> feed();
            //$printer -> setJustification(Printer::JUSTIFY_RIGHT);
            //$printer -> text("$item->cantidad\n");
            //echo json_encode($item->producto);
        }
        $printer -> text("\n\n");
        $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $printer -> text("Total"."--------------------------------$ "."$precio_total"."  "."$cantidad_total");
        $printer -> text("\n\n");
        $printer -> setTextSize(1,1);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Gracias por su compra, vuelva pronto.\n\n");
        //$printer -> text("Gracias por su compra, vuelva pronto.\n\n");
        $printer -> cut();
        $printer -> close();
    }
    
?>