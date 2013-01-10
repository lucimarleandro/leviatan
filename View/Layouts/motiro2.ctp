<?php
/**
 * Carrega as configurações da aplicação, definidas no bootstrap.
 */
$cfg = Configure::read('Aplicacao');
$cfg['nome'] = isset($cfg['nome']) ? $cfg['nome'] : 'Aplicação CDI - SMSJP';
$title = empty($title_for_layout) ? $cfg['nome'] : "{$title_for_layout} :: {$cfg['nome']}";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
    <head>
        <base href="<?php echo $this->Html->url('/', true);?>" />
        
        <?php
        // Tags Meta
        echo $this->Html->charset(), PHP_EOL;

        // Processa diretivas META na configuração da aplicação.
        if (isset($cfg['meta'])) {
            foreach ($cfg['meta'] as $key => $value)
                if (is_array($value))
                    echo $this->Html->meta($value), PHP_EOL;
                else
                    echo $this->Html->meta($key, $value), PHP_EOL;
        }

        echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')), PHP_EOL;
        ?>
        <title><?php echo $title; ?></title>
        <?php
        // Folhas de Estilo CSS
        echo $this->Html->css(array('motiro2', 'font-awesome','jquery-ui-1.9.2.custom.min', 'chosen', 'bootstrap')), PHP_EOL;
        echo $this->Html->script(array('jquery-1.8.3.min', 'functions', 'jquery.validate.min', 'jquery-ui-1.9.2.custom.min', 'jquery.maskedinput-1.3.min', 'chosen.jquery.min', 'bootstrap.min')), PHP_EOL;
        echo $this->fetch('css'), PHP_EOL; // folhas de estilo adicionadas no runtime.
        echo $this->fetch('script'), PHP_EOL; // arquivos de scripts adicionados no runtime.
        ?>        
        <!--[if IE 7]><?php echo $this->Html->css('font-awesome-ie7'); ?><![endif]-->
    </head>
    <body>
        <div id="cabecalho" class="barratopo">
            <div class="loading">
               Processando sua requisição...
               <br />
               <?php echo $this->Html->image('ajax-loader.gif'); ?>
           </div>
            <div class="aplicacao esquerda">
                <?php 
                echo $this->Html->link(
                    $this->Html->image('motiro-branco-36a.png', array('alt'=>'Motirõ')), 
                    array('controller'=>'items', 'action'=>'home'), 
                    array('escape'=>false)
                ); 
                ?>
            </div>
            <?php if(isset($user)) {?>
                <div class="cracha direita">
                    <div class="usuario">
                        Você está conectado como
                        <span class="block"><?php echo $user['Employee']['name'];?></span>
                    </div>
                    <div class="links">
                        <a href="javascript:;">alterar dados</a>
                        |
                        <a href="javascript:;">alterar senha</a>
                        |
                        <?php echo $this->Html->link('sair', array('controller'=>'users', 'action'=>'logout')); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <!-- Menu -->
        <?php echo $this->element('menu_nav'); ?>
        
        <!-- Área Central -->
        <div id="principal" class="conteudo">
             <div id="alert-message">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
            </div>
            <?php echo $this->fetch('content'); ?>
        </div>
        
        <!-- Rodapé -->
        <div id="rodape" class="rodape">
            <div class="esquerda">
                NÚCLEO DE DESENVOLVIMENTO DE SISTEMAS<br />
                COORDENAÇÃO DE DESENVOLVIMENTO INSTITUCIONAL<br />
                SECRETARIA MUNICIPAL DE SAÚDE DE JOÃO PESSOA
            </div>
            <div class="direita">
                <?php echo $this->Html->image('cdilogo64.png', array('alt'=>'CDI/SMSJP')); ?>
                <?php echo $this->Html->image('smsjplogo64a.png', array('alt'=>'SMS/PMJP')); ?>
            </div>
        </div>
        
        <script>
        $("body").on({		
            // When ajaxStart is fired, add 'loading' to body class
            ajaxStart: function() {
                if(!noLoading) {		    
                    $('.loading').show();
                }else { 
                    noLoading = false;
                }
            },
            // When ajaxStop is fired, rmeove 'loading' from body class
            ajaxStop: function() {
                $('.loading').hide();
            }    		
        });
        </script>
        
        <?php if(class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer(); ?>
    </body>
</html>
