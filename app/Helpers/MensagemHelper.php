<?php
namespace App\Helpers;

class MensagemHelper
{
    public static function mensagemAlertaGet() {

        if(isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            $alert = $_GET['alert'];
    
            switch ($alert) {
                case '0':
                    $alert = 'alert-success';
                break;
    
                case '1':
                    $alert = 'alert-danger';
                break;
            }
    
            echo '
                <div id="alertMensagem" class="alert ' . $alert .' alert-dismissible fade show" role="alert">
                    ' . $msg .'                        
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    
                <script>
                    setTimeout(() => {
                        const alerta = document.getElementById("alertMensagem");
                        if (alerta) {
                            alerta.style.display = "none";
                        }
                    }, 7000);
                </script>
            ';
        } 
    }
    
    public static function mensagemAlertaSet($msg, $alert) {
    
        if(!empty($msg) && !empty($alert)) {
    
            switch ($alert) {
                case '0':
                    $alert = 'alert-success';
                break;
    
                case '1':
                    $alert = 'alert-danger';
                break;
            }
    
            echo '
                <div id="alertMensagem" class="alert ' . $alert .' alert-dismissible fade show" role="alert">
                    ' . $msg .'                        
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    
                <script>
                    setTimeout(() => {
                        const alerta = document.getElementById("alertMensagem");
                        if (alerta) {
                            alerta.style.display = "none";
                        }
                    }, 7000);
                </script>
            ';
        }
    }

    public static function mensagemAlertaHtml(string $msg, int $alert) {

        if ($msg !== '' && $alert !== '') {

            switch ($alert) {
                case '0':
                    $alert = 'alert-success';
                break;
    
                case '1':
                    $alert = 'alert-danger';
                break;
            }
    
            return '
                <div id="alertMensagem" class="alert ' . $alert .' alert-dismissible fade show" role="alert">
                    ' . $msg .'                        
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    
                <script>
                    setTimeout(() => {
                        const alerta = document.getElementById("alertMensagem");
                        if (alerta) {
                            alerta.style.display = "none";
                        }
                    }, 7000);
                </script>
            ';
        }

    }
}


