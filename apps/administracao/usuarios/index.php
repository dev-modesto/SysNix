<?php

use App\Controllers\EquipamentoCalibracaoController;
use App\Helpers\DataHelper;
use App\Helpers\EquipamentoCalibracao\StatusEquipamentoCalibracaoHelper;
use App\Helpers\MensagemHelper;

include_once '../../../app/config/config.php';
include SEGURANCA;
include ARQUIVO_CONEXAO;

$totalStatusEquipamento = StatusEquipamentoCalibracaoHelper::totalStatusEquipamentoCalibracao();
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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/componentes.css">
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

    .container-icone-acao {
        display: flex !important;
        gap: 2px;
    }

    .container-icone-acao span{
        display: flex;
        align-items: center;
    }

      .td-icons span{
        padding: 3px;
        display: inline-flex;
        margin: 0px 2px;
        border: 1px solid var(--color-c4);
        border-radius: .2rem;
        transition: all .3s;
        cursor: pointer;
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
    <span>Usuários</span>
    <!-- <a href="usuarios.php">Usuários</a> &gt;
    <a href="usuarios.php">Usuários</a> &gt; -->
</div>

<div class="conteudo">

    <div class="container-principal">
        <div class="container-tabela">
            <table class="myTable table nowrap order-column table-hover text-left">
                <thead class="">
                    <tr>
                        <th class="all">Nome</th>
                        <th class="all">Email</th>
                        <th class="all">Empresa</th>
                        <th class="all">Primeiro acesso</th>
                        <th class="all">Status</th>
                        <th class="all">Ação</th>
                        <th class="all"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php

                        // $allEquipamentoCalibracao = EquipamentoCalibracaoController::selecionar();

                        $quey = "SELECT
                                    u.id,
                                    u.uuid,
                                    u.email,
                                    u.nome,
                                    u.sobrenome,
                                    u.senha,
                                    u.foto,
                                    u.primeiro_acesso,
                                    u.tentativas_login,
                                    u.status,
                                    GROUP_CONCAT(e.nome_fantasia SEPARATOR ' | ') AS empresas,
                                    GROUP_CONCAT(e.status SEPARATOR ', ') AS status_empresas
                                FROM tbl_usuario u
                                INNER JOIN tbl_usuario_empresa ue ON ue.id_usuario = u.id
                                INNER JOIN tbl_empresa e ON ue.id_empresa = e.id
                                GROUP BY
                                    u.id, u.uuid, u.email, u.nome, u.sobrenome, u.senha,
                                    u.foto, u.primeiro_acesso, u.tentativas_login, u.status
                                ;";
                        $dados = mysqli_query($con, $quey);
                        $allUsuarios = mysqli_fetch_all($dados, MYSQLI_ASSOC);

                        if(count($allUsuarios) > 0) {

                            foreach ($allUsuarios as $chave => $valor) {
                                $uuidUsuario = $valor['uuid'];
                                $nome = $valor['nome'];
                                $sobrenome = $valor['sobrenome'];
                                $nomeCompleto = "$nome $sobrenome";
                                $email = $valor['email'];
                                $empresas = $valor['empresas'];
                                $foto = $valor['foto'];
                                $primeiroAcesso = $valor['primeiro_acesso'];
                                $status = $valor['status'];
    
                                echo <<<HTML
                                        <tr data-key-public="$uuidUsuario">
                                            <td>$nomeCompleto</td>
                                            <td>$email</td>
                                            <td>$empresas</td>
                                            <td>$primeiroAcesso</td>
                                            <td>$status</td>
                                            <td class="container-icone-acao td-icons">
                                                <span class="material-symbols-rounded icone-acao-editar">edit</span>
                                                <span class="material-symbols-rounded icone-acao-excluir">delete</span>
                                            </td>
                                            <td></td>
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
                                </tr>
                            HTML;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="carregar-modal">
    </div>

</div>

<div class="container-copyright">
    <p class="font-1-s">© <?= $anoAtual ?> · Sysnix · Todos os direitos reservados </p>
    <p class="font-1-s">Desenvolvido por <a href="https://devmodesto.com.br" target="_blank" rel="noopener noreferrer" class="font-1-s peso-medio">devModesto</a></p>
</div>

<!-- importação scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<script src="<?= BASE_URL ?>/js/spinners.js"></script>
<script src="<?= BASE_URL ?>/vendor/igorescobar/jquery-mask-plugin/src/jquery.mask.js"></script>
<script src="<?= BASE_URL ?>/js/menu.js"></script>
<script src="<?= BASE_URL ?>/js/modalLoader.js"></script>

</body>

<script>
    var baseUrl = <?= json_encode(BASE_URL)?>;

    $(document).ready( function () {
        new DataTable('.myTable', {
            pagingType: 'simple_numbers',
            language: {
                url: '<?= BASE_URL ?>/js/pt_br.json'
            },
            order: [],
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
                            text: '<span class="material-symbols-rounded icone">download</span>Exportar',
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
                            className: 'btn btn-personalizado-tabela btn-cadastro btn-cadastro-usuario',
                            action: function (e, dt, node, config, cb) {
                                abrirModalCadastrar('include/mCadastrarUsuario.php', '.modal-body-cadastrar', '#modal-cadastrar', 'modal-md','Cadastrar usuário');
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