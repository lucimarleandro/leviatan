<table class="table table-bordered">
    <tr>
        <td><?php echo __('Código');  ?></td>
        <td><?php echo $pngcCode['PngcCode']['keycode'];?></td>
    </tr>
    <tr>
        <td><?php echo __('Grupo de Gastos');?></td>
        <td><?php echo $pngcCode['ExpenseGroup']['name'];?></td>
    </tr>
    <tr>
        <td><?php echo __('Unidade de Medida');?></td>
        <td><?php echo $pngcCode['MeasureType']['name']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Categoria');?></td>
        <td><?php echo $pngcCode['InputCategory']['name']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Subcategora'); ?></td>
        <td><?php echo $pngcCode['InputSubcategory']['name']?></td>
    </tr>
</table>