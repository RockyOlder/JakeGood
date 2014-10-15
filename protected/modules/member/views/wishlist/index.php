<table class="table">
    <thead>
        <tr>
            <th width="55">图片</th>
            <th>商品</th>
            <th>单价</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $v): ?>
            <tr>
                <td>
                    <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $v->Item->item_id)); ?>" target="_blank">
                        <img src="<?php echo $v->Item->pic_url; ?>" width="50" height="50"/>
                    </a>
                </td>
                <td>
                    <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $v->Item->item_id)); ?>" target="_blank"><?php echo $v->title; ?></a>
                </td>
                <td><?php echo $v->Item->price; ?></td>
                <td>
                    <?php echo CHtml::link('删除', $this->createUrl('delete', array('id' => $v->id))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>