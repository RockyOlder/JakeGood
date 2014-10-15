<style>
    .items li {margin-bottom: 20px;}
</style>
<form action="<?php echo $this->createUrl('save'); ?>" method="POST">
    <input type="hidden" name="sn" value="<?php echo $order->sn; ?>" />
    <ul class="items">
        <?php foreach ($order['OrderItem'] as $k => $item): ?>
            <li>
                <div style="height:80px;">
                    <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>" target="_blank">
                        <img src="<?php echo $item->pic; ?>" width="80" align="left"/>
                        <b><?php echo $item->title; ?></b>
                        <p><?php echo $item->props_name; ?></p>
                    </a>
                </div>
                <div style="margin-left:10px;">
                    <div style="width:100px;float:left;">
                        <label>
                            <input type="radio" name="data[<?php echo $item->order_item_id ?>][star]" value="1"/>
                            <div class="common-rating rating-16x16">
                                <span class="rate-stars" style="width:20%"></span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="data[<?php echo $item->order_item_id ?>][star]" value="2"/>
                            <div class="common-rating rating-16x16">
                                <span class="rate-stars" style="width:40%"></span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="data[<?php echo $item->order_item_id ?>][star]" value="3"/>
                            <div class="common-rating rating-16x16">
                                <span class="rate-stars" style="width:60%"></span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="data[<?php echo $item->order_item_id ?>][star]" value="4"/>
                            <div class="common-rating rating-16x16">
                                <span class="rate-stars" style="width:80%"></span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="data[<?php echo $item->order_item_id ?>][star]" value="5" checked="checked"/>
                            <div class="common-rating rating-16x16">
                                <span class="rate-stars" style="width:100%"></span>
                            </div>
                        </label>
                    </div>
                    <div style="float:left;margin-left:20px;">
                        <textarea name="data[<?php echo $item->order_item_id ?>][content]" maxlength="500" style="width: 400px;height: 100px;"></textarea>
                    </div>
                </div>
                <div class="clear"></div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="text-align:center">
        <button class="btn-hot">提交</button>            
    </div>
</form>