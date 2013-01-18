<table class="table table-bordered">
    <tr>
        <td><?php echo __('Classe'); ?></td>
        <td><?php echo $item['ItemClass']['keycode'].' - '.$item['ItemClass']['name']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('PNGC');  ?></td>
        <td><?php echo $item['PngcCode']['keycode'].' - '.$item['InputCategory']['name'].($item['InputSubcategory']['name'] == null ? ' ' : ' - '.$item['InputSubcategory']['name']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Código'); ?></td>
        <td><?php echo $item['Item']['keycode'];?></td>
    </tr>
    <tr>
        <td><?php echo __('Nome');?></td>
        <td><?php echo $item['Item']['name']?></td>
    </tr>
    <tr>
        <td><?php echo __('Descrição');?></td>
        <td><?php echo $item['Item']['description'];?></td>
    </tr>
    <tr>
        <td><?php echo __('Especifição');?></td>
        <td><?php echo $item['Item']['specification'];?></td>
    </tr>
    <tr>
        <td><?php echo __('Imagem')?></td>
        <td><?php echo $item['Item']['image_path'] == null ? $this->Html->image('no-image.png') : $this->Html->image('items'.DS.$item['Item']['image_path']);?></td>
    </tr>
</table>
    