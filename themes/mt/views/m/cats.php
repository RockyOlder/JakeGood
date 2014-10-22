
<div class="navbar list-group">
    <?php foreach (ItemCats::model()->findAll('parent_cid=0 AND status=1') as $cat): ?>
    <div>
        <a href="#" class="list-group-item " data-toggle="collapse" data-target=".navbar-collapse<?php echo $cat->cid; ?>">
            <?php echo $cat->name; ?>
        </a>
        <ul class="navbar-collapse<?php echo $cat->cid; ?> collapse">
            <?php $subs = ItemCats::model()->findAll("parent_cid={$cat->cid} AND status=1"); ?>
            <?php foreach ($subs as $sub): ?>
                <li class="list-group-item">
                    <?php $url = ($sub->cid > 0 ? $this->createUrl('item/list', array('cid' => $sub->cid)) : $sub->url); ?>
                    <a href="<?php echo $url; ?>">
                        <?php echo $sub->name; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php if (! $subs) : ?>
                <?php $url = ($cat->cid > 0 ? $this->createUrl('item/list', array('cid' => $cat->cid)) : $cat->url); ?>
                <a href="<?php echo $url; ?>" class="list-group-item " data-toggle="collapse" data-target=".navbar-collapse<?php echo $cat->cid; ?>">
                    <?php echo $cat->name; ?>
                </a>
            <?php endif; ?>
        </ul>
    </div>
    <?php endforeach; ?>
</div>