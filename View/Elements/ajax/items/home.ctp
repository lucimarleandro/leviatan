<div class="box-content">
    <div class="dataTables_wrapper" role="grid">
        <table id="table" class="table table-bordered table-hover" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Classe</th>
                    <th>PNGC</th>
                </tr>
            </thead>	
            <tbody>
                <?php if(empty($items)) { ?>
                    <tr>
                        <td colspan="4">Não há itens</td>
                    </tr>
                <?php                 
                }else {
                    foreach ($items AS $item): 
                ?>
                    <tr>
                        <td class="centralizado nowrap"><?php echo $item['Item']['keycode']; ?></td>
                        <td><?php echo $this->Html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', 'id'=>$item['Item']['id'])); ?></td>
                        <td class="centralizado"><?php echo $this->Html->link($item['ItemClass']['keycode'], array('controller' => 'item_classes', 'action' => 'view', $item['Item']['item_class_id'])); ?></td>
                        <td class="centralizado"><?php echo $this->Html->link($item['PngcCode']['keycode'], array('controller' => 'pngc_codes', 'action' => 'view', $item['Item']['pngc_code_id'])); ?></td>
                    </tr>
                <?php 
                    endforeach; 
                }
                ?>
            </tbody>	
            <tfoot>
                <tr>
                    <td colspan="4">
                        <?php
                        echo $this->Paginator->options(array(
                                'update' => '#items',
                                'evalScript' => true
                            )
                        );
                        echo $this->element('pagination'); 
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>	
