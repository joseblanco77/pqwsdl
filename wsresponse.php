<?php
include_once(getcwd() . '/general.php');

$action = isset($_GET['q']) ? $_GET['q'] : false;

if(!$action || !in_array($action,array('test','get','check','change'))) {
    header('Location: /');
}

$portManager = PortManager::getInstance($action, $_POST);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WS Response</title>
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
        <h3>Params</h3>
        <pre>
            <?php 
                $xml = false;
                $params = $portManager->getParams(); 
                if(isset($params['xml'])) {
                    $xml = $params['xml'];
                    unset($params['xml']);
                }
                print_r($params);
            ?>
        </pre>
        <?php
            if($xml) {
                echo '<textarea id="xmlbox">' . $xml . '</textarea>';
            }
        ?>
        <h3>Response</h3>
        <pre><?php print_r($portManager->getResponse()); ?></pre>
        <script type="text/javascript">
            var xmlbox = document.getElementById('xmlbox');
            xmlbox.style.height = (25+xmlbox.scrollHeight)+"px";
        </script>
    </body>
</html>