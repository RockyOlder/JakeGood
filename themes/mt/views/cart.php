
<link rel="stylesheet" type="text/css" href="/themes/mt/css/cart.v9a94b40a.css">
<link rel="stylesheet" type="text/css" href="/themes/mt/css/table-section.vfa4da119.css">
<link rel="stylesheet" type="text/css" href="/themes/mt/css/deal.v80160138.css">

<div class="pg-buy pg-cart">
    <div id="bdw" class="bdw pg-buy pg-cart">
        <div id="bd" class="cf">
            <div id="content">
                <form action="/order/confirm" method="post" id="J-cart-form" class="common-form" enctype="multipart/form-data">
                    <div class="mainbox">
                        <div class="cart-head cf">

                            <div class="cart-status extra-offset"><i class="cart-head-icon"></i>
                                <span class="cart-title">我的购物车</span>
                            </div>
                            <div class="buy-process-info">
                                <ol class="buy-process-bar steps-bar">
                                    <li class="step step--first step--current" style="z-index:2">
                                        <span class="step__num">1.</span>
                                        查看购物车
                                        <span class="arrow__background"></span>
                                        <span class="arrow__foreground"></span>
                                    </li>
                                    <li class="step " style="z-index:1">
                                        <span class="step__num">2.</span>
                                        确认订单
                                        <span class="arrow__background"></span>
                                        <span class="arrow__foreground"></span>
                                    </li>
                                    <li class="step step--last ">
                                        <span class="step__num">3.</span>
                                        支付
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="table-section summary-table">
                            <table cellspacing="0">
                                <col width="100" />
                                <col width="auto" />
                                <col width="100" />
                                <col width="150" />
                                <col width="100" />
                                <col width="80" />
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="cart-selectall" class="J-choose-all" onclick="chooseAll('all', this.checked)" />
                                            <label for="cart-selectall" class="cart-select-all">全选</label>
                                        </th>
                                        <th class="desc">商品信息</th>
                                        <th class="price">单价</th>
                                        <th>数量</th>
                                        <th class="total">金额</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            </table>
                            <?php foreach ($items as $store_id => $v): ?>
                            <table cellspacing="0" style="margin-top: 15px;border:1px solid #ccc">
                                <col width="40" />
                                <col width="auto" />
                                <col width="100" />
                                <col width="150" />
                                <col width="100" />
                                <col width="80" />
                                    <thead>
                                        <tr>
                                            <td width="30">
                                                <input type="checkbox" id="cart-selectall" class="J-choose" onclick="chooseAll('<?php echo $store_id; ?>', this.checked)" />
                                            </td>
                                            <td width="auto" colspan="5" align="left">商家：<?php echo Store::model()->findByPk($store_id)->name; ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($v as $sku_id => $item): ?>
                                        <tr class="R-items R-items-<?php echo $store_id; ?> <?php echo 'item'.$sku_id; ?>">
                                            <td><input type="checkbox" name="items[<?php echo $store_id; ?>][<?php echo $sku_id; ?>]" value="1" class="J-cart-item J-choose J-choose<?php echo $store_id; ?>" /></td>
                                            <td class="desc">
                                                <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" target="_blank">
                                                    <img src="<?php echo $item->pic; ?>" width="80" height="80" />
                                                </a>
                                                <span style="height: 40px;">
                                                    <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" target="_blank">
                                                        <?php echo $item->title; ?>
                                                    </a>
                                                </span>
                                                <br />
                                                <br />
                                                <p class="calendar-des"><?php echo $item->props; ?></p>
                                            </td>
                                            <td class="price">¥<span class="J-price"><?php echo $item->price; ?></span></td>
                                            <td class="deal-component-quantity">
                                                <button class="minus" type="button" data-store-id="<?php echo $store_id; ?>" data-sku-id="<?php echo $sku_id; ?>">-</button><input type="text" id="<?php echo 'item_'.$store_id.'_'.$sku_id.'_quantity'; ?>" name="quantity[]" value="<?php echo $item->quantity; ?>" class="f-text J-quantity J-cart-quantity" maxlength="4"><button for="J-cart-add" class="item plus" type="button" data-store-id="<?php echo $store_id; ?>" data-sku-id="<?php echo $sku_id; ?>">+</button>
                                            </td>
                                            <td class="money total">
                                                ¥<span class="J-total" id="<?php echo 'item_'.$store_id.'_'.$sku_id.'_total'; ?>"><?php echo sprintf("%.2f", $item->price*$item->quantity); ?></span>
                                            </td>
                                            <td class="op">
                                                <a class="" href="javascript:void(0);" onclick="deleteItem(<?php echo $store_id; ?>, <?php echo $sku_id; ?>)">删除</a>
                                            </td>
                                        </tr> 
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endforeach; ?>
                                <table style="margin-top: 15px;">
                                    <tr>
                                        <td class="extra-fee total-fee">
                                            <span class="amount">已选<strong class="amount__num" id="J-cart-amount">1</strong>件商品</span>
                                            <strong>应付总额</strong>：<span class="inline-block money">¥<strong id="J-cart-total">89.99</strong></span>
                                            
                                        </td>
                                        <td width="100">
                                            <input type="submit" class="btn btn-large btn-buy" name="buy" value="结算" />
                                        </td>
                                    </tr>
                                </table>
                        </div>

                        <div id="big-deal-tips" class="blk-item big-deal">
                            <h3>购买提示</h3>
                            <p class="text tip">* 随意购买</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
