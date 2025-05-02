<?php

use App\Controllers\EquipamentoCalibracaoController;
use App\Helpers\MensagemHelper;

include_once '../../app/config/config.php';

    $tituloPaginaHead = 'Home | Sysnix';
    $tituloPagina = 'Home';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($tituloPagina) == '' ? '-' : $tituloPagina ?> | SysNix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet" integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/global/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/cor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/sidebar/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/navbar/navbar-top.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/tabela.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/modal.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/pre-loader.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.bootstrap5.css">

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

    <style>
    .container-msg {
        margin: 15px 0;
        padding: 0px 40px;
        margin-top: 90px;
    }

    .breadcrumb {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 15px 0;
        margin-top: 0px;
        padding: 0px 40px;
        grid-area: breadcrumb;
    }
    .breadcrumb a {
        color: #007BFF;
        text-decoration: none;
        margin-right: 5px;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    .breadcrumb span {
        color: #555;
        font-size: 1.375rem;
        font-weight: 500;
    }

    .cards-equipamentos-calibracao {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        box-sizing: border-box;
        box-shadow:0px 0px 10px 1px rgba(0, 0, 0, 5%);
    }

    .card-dash {
        border: 1px solid var(--color-a3);
        border-radius: .3rem;
        padding: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .card-dash span::before {
        /* content: '';
        position: absolute;
        right: 20px;
        top: 20px;
        width: 15px;
        height: 15px;
        background-color: #D9D9D9; */
    }

    .container-conteudo-dash {
        display: flex;
        gap: 10px;
        
    }

    .div-conteudo-dash {
        padding: 10px 20px;
        /* background-color: tomato; */
        /* border-left: 10px solid; */
        border-radius: .3rem;
        position: relative;
    }

    .card-dash h1,
    .div-conteudo-dash span,
    .div-conteudo-dash p {
        color: var(--color-a8);
    }

    .marcador-dash {
        content: '';
        position: absolute;
        left: 0px;
        top: 0;
        width: 10px;
        height: 100%;
        border-radius: .3rem;
        background-color: #555;
    }

    .marcador-dash.operacional {
        background-color: var(--color-a-green4);
    }

    .marcador-dash.defeito {
        background-color: var(--color-a-red3);
    }

    .marcador-dash.vencendo {
        background-color: var(--color-a-yellow3);
    }

    .marcador-dash.env-calibracao {
        background-color: var(--color-a-blue3);
    }

    .marcador-dash.vencido {
        background-color: var(--color-a-green4);
    }

    .font-1-s {
        color:var(--color-a8)
    }

    </style>
<body>

<?php
    include BASE_PATH . '/include/preLoad/preLoad.php';
    include BASE_PATH . '/include/sidebar/sidebar.php';
    
?>

<div id="container-msg" class="container-msg">
    <?php
        MensagemHelper::mensagemAlertaGet();
    ?>
</div>

<div class="breadcrumb">
    <span>Home</span>
    <!-- <a href="usuarios.php">Usuários</a> &gt;
    <a href="usuarios.php">Usuários</a> &gt; -->
</div>

<div class="conteudo">
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr;" class="cards-equipamentos-calibracao column-gap-4 row-gap-4 ">
        
        <div class="card-dash col">
            <h1 class="font-1-s peso-medio">Geral</h1>
            <div class="container-conteudo-dash">
                <div class="div-conteudo-dash">
                    <span class="marcador-dash geral"></span>
                    <p class="font-xl peso-medio">65</p>
                    <span class="font-1-s">Total de Equipamentos</span>
                </div>
            </div>
            <span></span>
        </div>

        <div class="card-dash col">
            <h1 class="font-1-s peso-medio">Status Funcional</h1>
            <div class="container-conteudo-dash">
                <div class="div-conteudo-dash">
                    <span class="marcador-dash operacional"></span>
                    <p class="font-xl peso-medio">65</p>
                    <span class="font-1-s">Operacional</span>
                </div>
                <div class="div-conteudo-dash">
                    <span class="marcador-dash defeito"></span>
                    <p class="font-xl peso-medio">65</p>
                    <span class="font-1-s">Defeito</span>
                </div>
            </div>
            <span></span>
        </div>

        <div class="card-dash col">
            <h1 class="font-1-s peso-medio">Acompanhamento cabibração</h1>
            <div class="container-conteudo-dash">
                <div class="div-conteudo-dash">
                    <span class="marcador-dash vencendo"></span>
                    <p class="font-xl peso-medio">8</p>
                    <span class="font-1-s">Vencendo</span>
                </div>
                <div class="div-conteudo-dash">
                    <span class="marcador-dash env-calibracao"></span>
                    <p class="font-xl peso-medio">0</p>
                    <span class="font-1-s">Env. calib.</span>
                </div>
                <div class="div-conteudo-dash">
                    <span class="marcador-dash vencido"></span>
                    <p class="font-xl peso-medio">0</p>
                    <span class="font-1-s">Vencido</span>
                </div>
            </div>
            <span></span>
        </div>
       
    </div>

    <div class="container-principal">
        <div class="container-tabela">
            <table class="myTable table nowrap order-column table-hover text-left">
                <thead class="">
                    <tr>
                        <th class="all">Equipamento</th>
                        <th class="all">Descrição</th>
                        <th class="none">Modelo</th>
                        <th class="none">Fabricante</th>
                        <th class="none">Nº série</th>
                        <th class="none">Resolução</th>
                        <th class="none">Faixa Uso</th>
                        <th class="all">Última calibração</th>
                        <th class="all">Nº Certificado</th>
                        <th class="all">Calibração prevista</th>
                        <th class="none">Eri. -15 a -25</th>
                        <th class="none">Eri. 2 a 8</th>
                        <th class="none">Eri. 15 a 25</th>
                        <th class="all">Status Funcional</th>
                        <th class="all">Status Uso</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php

                        $allEquipamentoCalibracao = EquipamentoCalibracaoController::selecionar();

                        if(count($allEquipamentoCalibracao) > 0) {

                            foreach ($allEquipamentoCalibracao as $chave => $valor) {

                                $nomeIdentificador     = $valor['nome_identificador'] ?? null;
                                $descricao = $valor['descricao'] ?? null;
                                $modelo = $valor['modelo'] ?? null;
                                $fabricante = $valor['fabricante'] ?? null;
                                $serie = $valor['serie'] ?? null;
                                $resolucao = $valor['resolucao'] ?? null;
                                $faixaUso = $valor['faixa_uso'] ?? null;
                                $dtUltimaCalibracao = $valor['dt_ultima_calibracao'] ?? null;
                                $numeroCertificado = $valor['numero_certificado'] ?? null;
                                $dtCalibracaoPrevisao = $valor['dt_calibracao_previsao'] ?? null;
                                $ei15a25n = $valor['ei_15a25_n'] ?? null;
                                $ei2a8 = $valor['ei_2a8'] ?? null;
                                $ei15a25 = $valor['ei_15a25'] ?? null;
                                $statusFuncional = $valor['nome_status_funcional'] ?? null;
                                $statusUso = $valor['nome_status_uso'] ?? null;

                                $corStatusFuncional = $valor['cor_status_funcional'] ?? null;
                                $corStatusUso = $valor['cor_status_uso'] ?? null;
    
                                echo <<<HTML
                                        <tr>
                                            <td>$nomeIdentificador</td>
                                            <td>$descricao</td>
                                            <td>$modelo</td>
                                            <td>$fabricante</td>
                                            <td>$serie</td>
                                            <td>$resolucao</td>
                                            <td>$faixaUso</td>
                                            <td>$dtUltimaCalibracao</td>
                                            <td>$numeroCertificado</td>
                                            <td>$dtCalibracaoPrevisao</td>
                                            <td>$ei15a25n</td>
                                            <td>$ei2a8</td>
                                            <td>$ei15a25</td>
                                            <td>$statusFuncional</td>
                                            <td>$statusUso</td>
                                        </tr>
                                    HTML
                                ;
                            }

                        } else {

                            echo <<<HTML
                                <tr>
                                    <td style="text-align: center;">Nenhum equipamento encontrado.</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            HTML;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="container-copyright">
    <p class="font-1-s">© <?= $anoAtual ?> · Sysnix · Todos os direitos reservados </p>
    <p class="font-1-s">Desenvolvido por <a href="https://devmodesto.com.br" target="_blank" rel="noopener noreferrer" class="font-1-s peso-medio">devModesto</a></p>
</div>

<!-- importação scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js" integrity="sha384-2Ul6oqy3mEjM7dBJzKOck1Qb/mzlO+k/0BQv3D3C7u+Ri9+7OBINGa24AeOv5rgu" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.dataTables.js"></script>

<script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.bootstrap5.js"></script>

<!-- botoes funcoes -->
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.colVis.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>


<script src="<?= BASE_URL ?>/js/preLoader.js"></script>
<script src="<?= BASE_URL ?>/vendor/igorescobar/jquery-mask-plugin/src/jquery.mask.js"></script>
<script src="<?= BASE_URL ?>/js/menu.js"></script>
<script src="<?= BASE_URL ?>/js/modalLoader.js"></script>

</body>

<script>

    $(document).ready( function () {
        // abrirModal('mCadastrarEquipamentoCalibracao', 'include/mCadastrarEquipamentoCalibracao.php');

        new DataTable('.myTable', {
            pagingType: 'simple_numbers',
            language: {
                url: '<?= BASE_URL ?>/js/pt_br.json'
            },
            order: [],
            columns: [
                { data: 'Equipamento' },
                { data: 'Descricao' },
                { data: 'Modelo' },
                { data: 'Fabricante' },
                { data: 'Nº série' },
                { data: 'Resolução' },
                { data: 'Faixa Uso' },
                { data: 'Última calibração' },
                { data: 'Nº Certificado' },
                { data: 'Calibração prevista' },
                { data: 'Eri. -15 a -25' },
                { data: 'Eri. 2 a 8' },
                { data: 'Eri. 15 a 25' },
                { data: 'Status Funcional' },
                { data: 'Status Uso' },
            ],
        responsive: true,

        layout: {
            topEnd: {
                    pageLength: {
                    menu: [10, 25, 50, 100],
                    text: 'Linhas por página: _MENU_'
                },
            },
            
            topStart: {
                search: {
                    text: '<span class="material-symbols-rounded">search</span>',
                    placeholder: 'Buscar na tabela',
                    className: 'barra-pesquisa',
                    processing: true
                }
            },
            top2Start: {
                buttons: [
                    {
                        extend: 'colvis',
                        text: 'Colunas visíveis',
                        className: 'btn-personalizado-tabela btn-dropdown',
                    }
                ]
            },
            top2End: {
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        messageTop:
                        'The information in this table is copyright to Sirius Cybernetics Corp.',
                        className: 'btn-personalizado-tabela btn-impressao',
                    },
                    {
                        extend: 'collection',
                        text: '<span class="material-symbols-rounded icone">upload</span>Exportar',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                exportOptions: {
                                    columns: ':visible'
                                },
                            }
                        ],
                        className: 'btn-personalizado-tabela btn-exportar',
                    },
                    {
                        text: '<span class="material-symbols-rounded icone">add</span>Cadastrar',
                        className: 'btn btn-personalizado-tabela btn-cadastro',
                        action: function (e, dt, node, config, cb) {
                            abrirModal('mCadastrarEquipamentoCalibracao', 'include/mCadastrarEquipamentoCalibracao.php');
                        }
                    },
                ],
            },
            bottomStart: 'info',
            bottomEnd: {
                paging: {
                    type: 'first_last_numbers',
                }
            },
        },
        columnDefs: [
            {
                targets: -1,
                visible: false,
            }
        ]

        });
    } );

</script>