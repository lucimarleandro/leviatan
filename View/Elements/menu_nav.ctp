<?php if (isset($menus)) : ?>
    <div id="menuprincipal" class="navmenu">
        <ul>
            <?php
            /**
             * Motirõ DEZ2012:
             *  O menu é construído no AppController e passado para a view
             *  na estrutura que segue.
             * $menus[<rotulo>] = <url,icon>;
             */
            foreach ($menus as $chave => $attr) {
                $icone = (isset($attr['icon']) && !empty($attr['icon'])) ? $attr['icon'] : 'sign-blank';
                $bola = isset($attr['ball']) ? $attr['ball'] : false;
                $rotulo = isset($attr['text']) ? $attr['text'] : $chave;
                $ativo = isset($attr['active']) ? $attr['active'] : false;
                
                // Se não foi especificado o índice URL, assume-se que a URL está
                // embutida no array, então remove os índices que sobram.
                if (!isset($attr['url']))
                    unset($attr['icon'], $attr['ball'], $attr['text']);
                $url = isset($attr['url']) ? $attr['url'] : $attr;
                
                $html = "<i class='font-{$icone}'></i>"
                        . "<span class='rotulo'>{$rotulo}"
                        . ($bola ? "<span class='circulo'>{$bola}</span>" : '')
                        . "</span>";
                        
                ?>
                <li><?php echo $this->Html->link($html, $url, array(
                    'escape' => false,
                    'class' => ($ativo ? 'linkAtivo' : false)
                )); ?></li>
                <?php
            }
            ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (isset($submenu)) : ?>
    <div id="menuadicional" class="submenu">
        <ul>
            <?php foreach ($submenu as $chave => $item) : ?>
                <?php
                $icone = isset($item['icon']) ? $item['icon'] : false;
                $ativo = (isset($item['active']) && $item['active']);
                $rotulo = isset($item['text']) ? $item['text'] : $chave;
                $opcoes = array('escape' => false, 'class' => ($ativo ? 'linkAtivo' : false));
                ?>
                <li><?php echo $this->Html->link(
                    ($icone ? "<i class='font-{$icone}'></i> {$rotulo}" : $rotulo),
                    $item['url'], $opcoes);
                ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
