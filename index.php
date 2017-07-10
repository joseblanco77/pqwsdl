<?php
include_once(getcwd() . '/general.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Port tester</title>
    <style type="text/css">
        /* Style the tab */
        div.tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }
        
        /* Style the buttons inside the tab */
        div.tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }
        
        /* Change background color of buttons on hover */
        div.tab button:hover {
            background-color: #ddd;
        }
        
        /* Create an active/current tablink class */
        div.tab button.active {
            background-color: #ccc;
        }
        
        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        } 
        
        #ProbarServicioWeb {
            display: block;
        }
    </style>
</head>
<body>

    <a href="/failures.php">Ver envíos fallidos</a>

    <div class="tab">
      <button class="tablinks active" data-tab="ProbarServicioWeb">ProbarServicioWeb</button>
      <button class="tablinks" data-tab="ConsultaInformacion">ConsultaInformacion</button>
      <button class="tablinks" data-tab="ProcesaInformacion">ProcesaInformacion</button>
      <button class="tablinks" data-tab="CambioUbicacion">CambioUbicacion</button>
    </div>
    
    <div id="ProbarServicioWeb" class="tabcontent">
      <h3>ProbarServicioWeb - PruebaSistema</h3>
      <form method="POST" action="/wsresponse.php?q=test">
          <dl>
              <dt>Probar servicio web</dt>
          </dl>
          <input type="submit" value="Submit"/>
      </form>
    </div>
    
    <div id="ConsultaInformacion" class="tabcontent">
      <h3>ConsultaInformacion - GetContieneEnPredio</h3>
      <form method="POST" action="/wsresponse.php?q=get">
          <dl>
              <dt><label for="numero_mic">Número MIC</label></dt>
              <dd><input type="text" name="numero_mic"></dd>
              
              <dt><label for="numero_contenedor">Número contenedor</label></dt>
              <dd><input type="text" name="numero_contenedor"></dd>
              
              <dt><label for="tipo_transaccion">Tipo transacción</label></dt>
              <dd>
                  <select name="tipo_transaccion">
                      <option value="01">01 - Consulta</option>
                      <option value="02">02 - Recepción</option>
                      <option value="03">03 - Despacho</option>
                  </select>
              </dd>
              
              <dt><label for="empresa_transmite">Empresa transmite</label></dt>
              <dd><input type="text" name="empresa_transmite"></dd>
              
              <dt><label for="login_usuario">Login usuario</label></dt>
              <dd><input type="text" name="login_usuario"></dd>
              
              <dt><label for="clave_usuario">Clave usuario</label></dt>
              <dd><input type="password" name="clave_usuario"></dd>
              
              <dt><label for="nombre_usuario">Nombre usuario</label></dt>
              <dd><input type="text" name="nombre_usuario"></dd>
          </dl>
          <input type="submit" value="Submit"/>
      </form>
    </div>
    
    <div id="ProcesaInformacion" class="tabcontent">
      <h3>ProcesaInformacion - Verifica_Datos</h3>
      <form method="POST" action="/wsresponse.php?q=check">
          <dl>
              <dt><label for="numero_mic">Número MIC</label></dt>
              <dd><input type="text" name="numero_mic"></dd>
              
              <dt><label for="numero_contenedor">Número contenedor</label></dt>
              <dd><input type="text" name="numero_contenedor"></dd>
              
              <dt><label for="tipo_transaccion">Tipo transacción</label></dt>
              <dd>
                  <select name="tipo_transaccion">
                      <option value="01">01 - Consulta</option>
                      <option value="02">02 - Recepción</option>
                      <option value="03">03 - Despacho</option>
                  </select>
              </dd>

              <dt><label for="marchamo_aduana">Marchamo aduana</label></dt>
              <dd><input type="text" name="marchamo_aduana"></dd>
              
              <dt><label for="marchamo_1">Marchamo 1</label></dt>
              <dd><input type="text" name="marchamo_1"></dd>
              
              <dt><label for="marchamo_2">Marchamo 2</label></dt>
              <dd><input type="text" name="marchamo_2"></dd>
              
              <dt><label for="marchamo_3">Marchamo 3</label></dt>
              <dd><input type="text" name="marchamo_3"></dd>
              
              <dt><label for="fecha_ciclo">Fecha ciclo</label></dt>
              <dd><input type="text" name="fecha_ciclo" placeholder="dd/mm/aaaa hh:mm:ss"></dd>
              
              <dt><label for="num_ciclo">Número ciclo</label></dt>
              <dd><input type="text" name="num_ciclo"></dd>
              
              <dt><label for="vacio_lleno">Vacío/Lleno</label></dt>
              <dd>
                  <select name="vacio_lleno">
                      <option value="4">4 - Vacío</option>
                      <option value="5">5 - Lleno</option>
                  </select>
              </dd>
              
              <dt><label for="obse_activ2">Observaciones</label></dt>
              <dd><textarea name="obse_activ2"></textarea></dd>
              
              <dt><label for="peso_bruto_bascula">Peso en Kg.</label></dt>
              <dd><input type="number" name="peso_bruto_bascula"></dd>
              
              <dt><label for="danos">Daños</label></dt>
              <dd><textarea name="danos"></textarea></dd>
              
              <dt><label for="empresa_transmite">Empresa transmite</label></dt>
              <dd><input type="text" name="empresa_transmite"></dd>
              
              <dt><label for="login_usuario">Login usuario</label></dt>
              <dd><input type="text" name="login_usuario"></dd>
              
              <dt><label for="clave_usuario">Clave usuario</label></dt>
              <dd><input type="password" name="clave_usuario"></dd>
              
              <dt><label for="nombre_usuario">Nombre usuario</label></dt>
              <dd><input type="text" name="nombre_usuario"></dd>
          </dl>
          <input type="submit" value="Submit"/>
      </form>
    </div> 
        
    <div id="CambioUbicacion" class="tabcontent">
      <h3>CambioUbicacion - CambioUbicacion</h3>
      <form method="POST" action="/wsresponse.php?q=change">
          <dl>
              <dt><label for="numero_contenedor">Número contenedor</label></dt>
              <dd><input type="text" name="numero_contenedor"></dd>
              
              <dt><label for="ubicacion_predio">Ubicación predio</label></dt>
              <dd><input type="text" name="ubicacion_predio"></dd>
              
              <dt><label for="empresa_transmite">Empresa transmite</label></dt>
              <dd><input type="text" name="empresa_transmite"></dd>
              
              <dt><label for="login_usuario">Login usuario</label></dt>
              <dd><input type="text" name="login_usuario"></dd>
              
              <dt><label for="clave_usuario">Clave usuario</label></dt>
              <dd><input type="password" name="clave_usuario"></dd>
              
              <dt><label for="nombre_usuario">Nombre usuario</label></dt>
              <dd><input type="text" name="nombre_usuario"></dd>
          </dl>
          <input type="submit" value="Submit"/>
      </form>
    </div> 

    <script type="text/javascript">
        var port = {
            
            tablinks: document.getElementsByClassName("tablinks"),
            tabcontent: document.getElementsByClassName("tabcontent"),
            
            changeTab() {
                var activeTab = this.getAttribute('data-tab');
                console.log(activeTab)
                for (i = 0; i < port.tabcontent.length; i++) {
                    port.tabcontent[i].style.display = "none";
                }
                for (i = 0; i < port.tablinks.length; i++) {
                    port.tablinks[i].className = port.tablinks[i].className.replace(" active", "");
                }
                document.getElementById(activeTab).style.display = "block";
                this.className += ' ' + " active";

            },
            
            atachEvents() {
                for (var i = 0; i < port.tablinks.length; i++) {
                    port.tablinks[i].addEventListener('click', port.changeTab, false);
                }
            },
            
            start() {
                if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
                    this.atachEvents();
                } else {
                    document.addEventListener('DOMContentLoaded', this.atachEvents);
                }
            }
        };
        
        port.start();
    </script>
</body>
</html>