<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieID = $_GET["RID"]; 
     $ID = $_GET["upd"]; 
     $rolID = $_GET["Rol"]; 
     
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Ultima Casa Beheer</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
               <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
          </head>
          <body>
               <div class="container">
                    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                         <h3>Rol wijzigen</h3>';
     
     $sql = "UPDATE relaties 
                SET FKrollenID = $rolID
              WHERE ID = $ID";
     if ($db->query($sql) == true) 
     {    echo          '<p>De rol is gewijzigd.</p>';
     }
     else
     {    echo          '<p>Fout bij het wijzigen van deze rol.</p>
                         <p>' . $sql . '</p>';
     }
     echo               '<br><br>
                         <button class="action-button"><a href="beheer.php?RID=' . $relatieID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>