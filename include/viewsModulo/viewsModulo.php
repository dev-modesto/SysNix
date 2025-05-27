<?php

?>

<style>
    .container-cards-telas {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .card-tela {
        border: 1px solid var(--color-a1);
        background-color: #fff;
        padding: 20px;
        height: 250px;
        border-radius: .3rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow:0px 0px 10px 1px rgba(0, 0, 0, 5%);
    }

    .container-icone-card {
        /* background-color: tomato; */
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container-icone-card span{
        font-size: 5rem;
    }

</style>

<div class="container-cards-telas">
    <?php   


        if (isset($arrayDadosViewsPermissoes['status']) == 1) {
            echo $arrayDadosViewsPermissoes['msg'];
        
        } else {
                foreach ($arrayDadosViewsPermissoes as $chave => $valor) {
                $nomeView = $valor['nome_view'];
                $icone = $valor['icone_view'];
                $caminho = $valor['caminho_view'];
                $status = $valor['status'];
                $caminhoModulo = $valor['caminho_modulo'];

                $caminhoCompleto = BASE_URL . '/apps/' . "$caminhoModulo/$caminho";

                echo <<<PHP
                    <a href="$caminhoCompleto">
                        <div class="card-tela">
                            <h1 class="font-xl peso-medio">$nomeView</h1>
                            <div class="container-icone-card">
                                <span class="material-symbols-rounded">$icone</span>
                            </div>
                        </div>
                    </a>
                PHP;

            }   
        }  
            
    ?>
</div>