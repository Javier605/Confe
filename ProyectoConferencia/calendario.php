<?php include_once 'includes/templates/header.php'; ?>

 


    <section class="seccion contenedor">
        <h2>Calendario de Eventos</h2>

        <?php
        try{
            // Se crea la conexion
           require_once('includes/funciones/db_conexion.php');
           //escribimos la consulta
           $sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ";
           $sql .= " FROM eventos ";
           $sql .= " INNER JOIN categoria_evento ";
           $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categria ";
           $sql .= " INNER JOIN invitados ";
           $sql .= " ON eventos.id_inv = invitados.invitado_id ";
           $sql .= " ORDER BY evento_id ";
          //consultamos la base
           $resultado = $conn->query($sql) or die($conn->error);
        } catch (\Exception $e) {
         echo $e->getMessage();
        }

        ?>

        <div class="calendario">
            <?php

            //arreglo 1
            $calendario = array();
            // se imprime lo resultados
              while( $eventos = $resultado->fetch_assoc() )  { 
                  
                
                  //obtiene la fecha del evento
                  $fecha = $eventos['fecha_evento'];

                  //arreglo 2
                  $evento = array(
                      'titulo' => $eventos['nombre_evento'],
                      'fecha' => $eventos['fecha_evento'],
                      'hora' => $eventos['hora_evento'],
                      'categoria' => $eventos['cat_evento'],
                      'icono' => $eventos['icono'],
                      'invitado' => $eventos['nombre_invitado'] . " " . $eventos['apellido_invitado']
                  );
                  
                  $calendario[$fecha] [] = $evento;

                  ?>
    
            <?php  } //while de fecht_assco()  ?>


            <?php 
            //imprime todos los eventos
            foreach($calendario as $dia => $lista_eventos) { ?> 
            <h3>
                <i class="fa fa-calendar"></i>
                <?php 
                //winwdows
                setlocale(LC_TIME, 'spanish');
                echo strftime( "%d de %B del %Y", strtotime($dia) ); ?>
            </h3>
            <?php foreach($lista_eventos as $evento) { ?>
                <div class="dia">
                    <p class="titulo"><?php echo $evento ['titulo']; ?></p>
                    <p class="hora">
                       <i class="fa fa-clock-o" aria-hidden="true"></i>
                       <?php echo $evento ['fecha'] . " " . $evento['hora']; ?>
                    </p>
                    <p>
                        <i class="fa <?php echo $evento['icono']; ?>" aria-hidden="true"></i>
                        <?php echo $evento ['categoria']; ?></p>
                    <p>
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <?php echo $evento ['invitado']; ?></p>
                    </p>

                </div>
              
            <?php } //fin foreach eventos ?>
           <?php } // fin foreach de dias ?>
        </div>

        <?php  
        // cerra la conexion
           $conn->close();
        ?>
  
    </section>


<?php include_once 'includes/templates/footer.php'; ?>
  