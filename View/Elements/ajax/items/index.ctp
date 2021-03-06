<div class="box-content">
    <div>
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <?php  if($user['group_id'] == HOMOLOGADOR) { ?>
                        <th></th>
                    <?php } ?>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Classe</th>
                    <th>PNGC</th>
                    <th>Ações</th>
                </tr>
            </thead>	
            <tbody>
                <?php if(empty($items)) {?>
                    <tr>
                        <th colspan="6">Não há itens</th> 
                    </tr>
                <?php }else {?>
                    <?php foreach ($items AS $item): ?>
                        <tr>
                            <?php  if($user['group_id'] == HOMOLOGADOR) { ?>
                            <td>
                                <?php                               
                                    if($item['Item']['status_id'] != PENDENTE) {
                                        echo $this->Form->checkbox('check', array(
                                                'checked'=>$item['Item']['status_id'] == ATIVO,
                                                'class'=>'changeStatus',
                                                'value'=>$item['Item']['id']
                                            )
                                        );    
                                    }
                                    echo $this->Form->input('page', array('id'=>'page', 'type'=>'hidden', 'value'=>$this->Paginator->current()));
                                ?>
                            </td>
                            <?php } ?>
                            <td style="white-space: nowrap"><?php echo $item['Item']['keycode']; ?></td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                    $item['Item']['name'], 
                                    'javascript:void(0)', 
                                    array(
                                        'id'=>'view', 
                                        'data-controller'=>'items',
                                        'data-id'=>$item['Item']['id']
                                    )
                                ); 
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo 
                                $this->Html->link(
                                    $item['ItemClass']['keycode'], 
                                    'javascript:void(0)',
                                    array(
                                        'id'=>'view',
                                        'data-controller'=>'item_classes',
                                        'data-id'=>$item['ItemClass']['id']
                                    )
                                );
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo $this->Html->link(
                                    $item['PngcCode']['keycode'], 
                                    'javascript:void(0);',
                                    array(
                                        'id'=>'view',
                                        'data-controller'=>'pngc_codes',
                                        'data-id'=>$item['PngcCode']['id']
                                    )
                                ); 
                                ?>
                            </td>
                            <td class="acoes">
                                <?php
                                if($item['Item']['status_id'] == PENDENTE) {
                                    if($user['group_id'] == HOMOLOGADOR) {
                                        echo $this->Html->link(
                                            $this->Html->image('check.png'),
                                            'javascript:void(0)',
                                            array(
                                                'escape'=>false, 
                                                'class'=>'approve', 
                                                'title'=>'Homologar item. Depois de homologado o item não pode ser mais editado ou excluído.',
                                                'data-value'=>$item['Item']['id'],
                                            )
                                        );
                                    }
                                    echo $this->Html->link(
                                        $this->Html->image('edit.png'), 
                                            array('controller' => 'items', 'action' => 'edit', 'id'=>$item['Item']['id']), 
                                            array('escape' => false, 'title' => 'Editar item')
                                    );
                                    echo $this->Form->postLink(
                                        $this->Html->image('delete.png'), 
                                            array('controller' => 'items', 'action' => 'delete', $item['Item']['id']), 
                                            array('escape' => false, 'title' => 'Deletar item', 'confirm' => 'Tem certeza que deseja excluir o item?')
                                    );
                                }else if($item['Item']['status_id'] == ATIVO) {
                                    echo 'ATIVO';
                                }else if($item['Item']['status_id'] == INATIVO) {
                                    echo 'INATIVO';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php }?>
            </tbody>	
        </table>
    </div>
</div>	
<?php
echo $this->Paginator->options(
    array(
        'update' => '#items',
        'evalScript' => true
    )
);
?>
<?php echo $this->element('pagination'); ?>