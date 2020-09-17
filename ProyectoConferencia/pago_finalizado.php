<?php include_once 'includes/templates/header.php'; 
error_reporting(E_ALL ^ E_NOTICE);
use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payment;
require 'includes/paypal.php';
?>  


<section class="seccion contenedor">
    <h2>Resumen Registro</h2>
    
    <?php
        $paymentId = $_GET['paymentId'];
        $id_pago = (int) $_GET['id_pago'];

        //Peticion a rest Api
        $pago = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId( $_GET['PayerID'] );
        
        //resultado tiene la informacion de la trasacciion
        $resultado = $pago->execute($execution, $apiContext);

        $respuesta = $resultado->transactions[0]->related_resources[0]->sale->state;



        if($respuesta == "completed"){
              echo "<div class='resultado correcto'>";
              echo "El pago se realizó correctamente <br/>";
              echo "el ID es {$paymentId}";
              echo "</div>";
              
              require_once('includes/funciones/db_conexion.php');
              $stmt = $conn->prepare("UPDATE registrados SET pagado = ? WHERE ID_Registrado =  ? ");
              $pagado = 1;
              $stmt->bind_param("ii", $pagado, $id_pago);
              $stmt->execute();
              $stmt->close();
              $conn->close();
              
        } else {
              echo "<div class='resultado error'>";
              echo "El pago no se realizo";
              echo "</div>";
        }
    
    ?>
    
  
    
</section>


<?php include_once 'includes/templates/footer.php'; ?>  

