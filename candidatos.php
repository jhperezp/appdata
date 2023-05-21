<?php

header("Content-Type: application/json");
include "config.php";
include "utils.php";


$dbConn =  connect($db);

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
      if (isset($_GET['id']))
      {
        //Mostrar un post
        $sql = $dbConn->prepare("CALL BUSCAR_CANDIDATO(:id)");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        header("HTTP/1.1 200 OK");
        echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
        exit();
          }
      else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("CALL CONSULTAR_CANDIDATOS()");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
      }	
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>