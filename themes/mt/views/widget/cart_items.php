<?php foreach ($items as $k => $item): ?>
<li class="dropdown-menu__item">
    <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" title="<?php echo $item->title; ?>" target="_blank" class="deal-link">
        <img class="deal-cover" src="<?php echo $item->pic; ?>" width="50" height="50">
    </a>
    <h5 class="deal-title"><a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" title="<?php echo $item->title; ?>" target="_blank" class="deal-link"><?php echo $item->title; ?></a></h5>
    <p class="deal-price-w"><?php echo $item->props; ?></p>
    <p class="deal-price-w"><a href="javascript:void(0);" class="delete link--black__green" onclick="deleteItem(<?php echo $item->store_id; ?>, <?php echo $k; ?>)">删除</a>
        <em class="deal-price">¥<?php echo $item->price; ?></em>
    </p>
    
</li>
<?php endforeach; ?>