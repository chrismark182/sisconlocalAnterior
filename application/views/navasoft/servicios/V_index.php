<?php 
    $fechaDesde = new DateTime();
    //$fechaDesde->modify('-1 month');
    $fechaDesde->modify('first day of this month');    
    $fechaHasta = new DateTime();
?>
<nav class="blue-grey lighten-1" style="padding: 0 1em;">
    <div class="nav-wrapper">
        <div class="col s4" style="display: inline-block">
            <a href="#!" class="breadcrumb">Traslado a Navasoft - Servicios</a>
        </div>
        <ul id="nav-mobile" class="right">
            <div class="input-field col s6 left-align" style="margin: 0px; font-size: 12px;">
                <div>
                    <b>
                        Total Registros: 
                        &nbsp;&nbsp;&nbsp;
                        <span id="total" class="btn blue-grey darken-2">0</span>
                    </b>
                </div>
            </div>
        </ul>
    </div>
</nav>
<!-- Buscador -->
<div class="section container center">
    <div class="row" style="margin-bottom: 0px">
        <form action="<?= base_url() ?>tarifas" method="post">
            
            <div class="input-field col s12 m6 l6">
                <input id="desde" type="text" value="<?= $fechaDesde->format('m/d/Y') ?>" class="datepicker">
                <label class="active" for="desde">Desde</label> 
            </div>
            <div class="input-field col s12 m6 l6">
                <input id="hasta" type="text" value="<?= $fechaHasta->format('m/d/Y') ?>" class="datepicker">
                <label class="active" for="hasta">Hasta</label> 
            </div>
            <div class="input-field col s12 m6 l6">
                <select id="cliente" name="cliente">
                    <option value="0" selected>Todos los Clientes</option>
                    <?php if($clientes): ?>
                        <?php foreach($clientes as $cliente): ?> 
                            <option value="<?= $cliente->CLIENT_N_ID ?>"><?= $cliente->CLIENT_C_RAZON_SOCIAL ?></option>
                        <?php endforeach; ?> 
                    <?php endif; ?>
                </select>
                <label>Clientes</label>
            </div>

            <div class="input-field col s12 m6 l6">
                <select id="sede" name="sede">
                    <option value="0" selected>Todas las Sedes</option>
                    <?php if($sedes): ?>
                        <?php foreach($sedes as $sede): ?> 
                            <option value="<?= $sede->SEDE_N_ID ?>"><?= $sede->SEDE_C_DESCRIPCION ?></option>
                        <?php endforeach; ?> 
                    <?php endif; ?>
                </select>
                <label>Sedes</label>
            </div>

            <div class="input-field col l12">
                <div id="btnBuscar" class="btn">Buscar</div>
            </div>
        </form>
    </div>    
</div>

<div class="container">
    <table class="striped" style="font-size: 12px;">
        <thead class="blue-grey darken-1" style="color: white">
            <tr>          
                <th class="center-align">LIQ</th>
                <th class="left-align">CLIENTE</th>
                <th class="left-align">SEDE</th>
                <th class="center-align">FECHA</th>
                <th class="center-align">SITUACION</th>
                <th class="center-align">ORDENES</th>
                <th class="center-align">MON</th>
                <th class="right-align">IMPORTE TOTAL</th>
                <th class="center-align">REPORTE</th>
                <th class="center-align">NAVASOFT</th>
            </tr>
        </thead>
        <tbody id="resultados">
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnBuscar = document.getElementById("btnBuscar"); 
        btnBuscar.addEventListener("click", buscar, false);
        buscar();
    });
    function buscar()
    {
        console.log('Estoy buscando.. ')
        M.toast({html: 'Buscando resultado...', classes: 'rounded'});
        $('.preloader-background').css({'display': 'block'});

        var url = 'navasoft_servicios/buscar';
        $fecha_desde = $('#desde').val();
        $fecha_desde = $fecha_desde.split('/');
        
        $fecha_hasta = $('#hasta').val();
        $fecha_hasta = $fecha_hasta.split('/');
        var cliente = $('#cliente').val();
        var sede = $('#sede').val();

        var data = {
                    empresa: <?= $empresa->EMPRES_N_ID ?>, 
                    desde: $fecha_desde[2] + $fecha_desde[1] + $fecha_desde[0],
                    hasta: $fecha_hasta[2] + $fecha_hasta[1] + $fecha_hasta[0],
                    cliente: cliente,
                    sede: sede,
                    tipo: 'S'
                    };
        
        $('#resultados').html('');
        fetch(url, {
                    method: 'POST', // or 'PUT'
                    body: JSON.stringify(data), // data can be `string` or {object}!
                    headers:{
                        'Content-Type': 'application/json'
                        }
                    })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) 
        {
            $('#total').html(data.length);
            if(data.length > 0)
            {
                M.toast({html: 'Cargando liquidaciones', classes: 'rounded'});
            }

            for (let index = 0; index < data.length; index++) {
                const element = data[index];
               
                $situacion = '';
                if(element.LIQCAB_C_SITUACION == 0)
                {
                    $situacion = 'Pendiente O/C';
                }else
                if(element.LIQCAB_C_SITUACION == 1)
                {
                    $situacion = 'Liquidado';
                }else
                if(element.LIQCAB_C_SITUACION == 2)
                {
                    $situacion = 'En Navasoft';
                }

                $traslado = `<i class="material-icons" style="cursor: pointer" onclick="generar_dbf(${element.EMPRES_N_ID},${element.LIQCAB_N_ID})">cloud_download</i>`

                $('#resultados').append(`   
                    <tr>
                        <td class="center-align">${element.LIQCAB_N_ID}</td>
                        <td class="left-align">${element.CLIENT_C_RAZON_SOCIAL}</td>
                        <td class="left-align">${element.SEDE_C_DESCRIPCION}</td>
                        <td class="center-align">${element.LIQCAB_C_FECHA}</td>
                        <td class="center-align">${$situacion}</td>
                        <td class="center-align">${element.SERVIC_N_CANTIDAD}</td>
                        <td class="center-align">${element.SERVIC_C_MONEDA}</td>
                        <td class="right-align">${element.SERVIC_N_IMPORTE}</td>
                        <td class="center-align"><i class="material-icons tooltipped" data-position="bottom" data-tooltip="Estamos trabajando...">description</i></td>                        
                        <td class="center-align">${$traslado}</td>
                    </tr>
                                    `);
            }
            $('.preloader-background').css({'display': 'none'});                            
            $('.tooltipped').tooltip();
        });
    }

    function generar_dbf($empresa,$liquidacion){
            M.toast({html: 'Generando...'});

    }
</script>