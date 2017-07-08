<?php
include_once(getcwd() . '/general.php');
$failures = $db->query("SELECT * FROM pqwsdl WHERE STATUS = 'error';");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WS Failures</title>
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
        <a href="/">Inicio</a>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>id_stock</th>
                    <th>Mensaje</th>
                    <th>Datos</th>
                    <th>Fecha </th>
                    <th>Marcar</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $db->fetchNextObject($failures)): ?>
                <tr>
                    <td><?php echo $row->id_wsdl ?></td>
                    <td><?php echo $row->id_stock ?></td>
                    <td><?php $resp = (array)json_decode($row->response); echo $resp['message'] ?></td>
                    <td><?php $params = (array)json_decode($row->params); print_r($params) ?></td>
                    <td><?php $date = strtotime($row->ts); echo date('d/m/Y H:i:s',$date) ?></td>
                    <td><input type="checkbox" id="pqwsdl_<?php echo $row->id_wsdl ?>1" value="<?php echo $row->id_wsdl ?>"></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>
</html>