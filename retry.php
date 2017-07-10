<?php
include_once(getcwd() . '/general.php');
if(!isset($_POST['failures']) || count($_POST['failures'])===0) {
    header('Location: /');
} 
$failures = $db->query("SELECT * FROM pqwsdl WHERE STATUS = 'error' AND id_wsdl IN (" . implode(",", $_POST['failures']) . ");");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WS Response Retry</title>
        <style type="text/css">
            pre {
                padding: 15px;
                background-color: #ccc;
                font-family: 'Courier New', monospace;
                border: dashed 2px #000;
            }
            textarea {
                width: 100%;
                height: auto;
                min-height: 50px;
            }
        </style>
    </head>
    <body>

        <a href="/">Inicio</a> - <a href="/failures.php">Ver envíos fallidos</a>

        <h3>Results</h3>
        <?php while($row = $db->fetchNextObject($failures)): ?>
        <pre>
            <?php 
                $oldParams = (array)json_decode($row->params);
                print_r(Portmanager::retryWsdl($oldParams,$row->id_wsdl,$row->id_stock,$db));
            ?>
        </pre>
        <?php endwhile ?>
    </body>
</html>
    
    
</body>
