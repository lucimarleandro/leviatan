<?php if (empty($items)) { ?>
    <h3><?php echo __('Não há Itens'); ?></h3>
<?php } else { ?>
    <div class="box-content">
        <div class="dataTables_wrapper" role="grid">
            <table id="table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Classe</th>
                        <th>PNGC</th>
                    </tr>
                </thead>	
                <tbody>
                    <?php foreach ($items AS $item): ?>
                        <tr>
                            <td style="white-space: nowrap"><?php echo $item['Item']['keycode']; ?></td>
                            <td><?php echo $this->Html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', $item['Item']['id'])); ?></td>
                            <td><?php echo $this->Html->link($item['ItemClass']['keycode'], array('controller' => 'item_classes', 'action' => 'view', $item['Item']['item_class_id'])); ?></td>
                            <td><?php echo $this->Html->link($item['PngcCode']['keycode'], array('controller' => 'pngc_codes', 'action' => 'view', $item['Item']['pngc_code_id'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>	
            </table>
        </div>
    </div>	
    <?php
    echo $this->Paginator->options(array(
        'update' => '#items',
        'evalScript' => true
            )
    );
    ?>
    <?php echo $this->element('pagination'); ?>
<?php
}?>