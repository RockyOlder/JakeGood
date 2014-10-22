
<link rel="stylesheet" type="text/css" href="/themes/mt/css/cart.v9a94b40a.css">
<link rel="stylesheet" type="text/css" href="/themes/mt/css/table-section.vfa4da119.css">

<style>
    .table-section table {border:0;}
    .table-section table th, .table-section table td {border:0;}
    
    .table-section table tr.bottom_line th {height:2px; padding: 0; border-bottom:2px solid #E64346}
    .table-section table tr.bottom_line td {height:2px; padding: 0; border-bottom:1px dotted #E64346}
    .props {font-size: 12px; color: #aaa;}
    .memo {width: 350px;padding:3px; font-size: 14px; border:1px solid #8AB6DD}
    select.ship{padding: 3px;width:100%;}
    
    .address-section table tr th{padding-left: 16px}
    .address-section table tr td{padding: 5px 0; border-bottom:1px dotted #ddd}
    .address-section table tr.bottom_line th {height:2px; padding: 0; border-bottom:2px solid #E64346;}
</style>
<script>
    var ship_data = <?php echo json_encode($ships)?>;
    $(document).ready(function () {
        $('select.ship').change(function () {
            store_id = $(this).attr('data-store-id');
            type = $(this).val();
            $(this).parent().parent().find('.sub_total').html(ship_data[store_id]['data'][type]);
            
            //all total
            var total = 0;
            $('.sub_total').each(function () {
                total += parseFloat($(this).html());
            });
            $('#J-cart-total').html(total.toFixed(2));
            
            //item total
            var total = 0;
            $('#itemlist'+store_id+' .sub_total').each(function () {
                total += parseFloat($(this).html());
            });
            total += parseFloat(ship_data[store_id]['data'][type]);
            $('#store_total_'+store_id).html(total.toFixed(2));
        });
    });
    
</script>
<div class="pg-buy pg-cart">
    <div id="bdw" class="bdw pg-buy pg-cart">
        <div id="bd" class="cf">
            <div id="content">
                <form action="<?php echo $this->createUrl('order/save'); ?>" method="post" id="J-cart-form" class="common-form" enctype="multipart/form-data">
                    <div class="mainbox">
                        <div class="cart-head cf">

                            <div class="cart-status extra-offset"><i class="cart-head-icon"></i>
                                <span class="cart-title">我的购物车</span>
                            </div>
                            <div class="buy-process-info">
                                <ol class="buy-process-bar steps-bar">
                                    <li class="step step--first" style="z-index:2">
                                        <span class="step__num">1.</span>
                                        查看购物车
                                        <span class="arrow__background"></span>
                                        <span class="arrow__foreground"></span>
                                    </li>
                                    <li class="step step--current" style="z-index:1">
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
                            <table style="border:0;">
                                <col width="auto" />
                                <col width="150" />
                                <col width="150" />
                                <col width="100" />
                                <thead>
                                    <tr>
                                        <th class="desc">商品信息</th>
                                        <th class="price">单价</th>
                                        <th>数量</th>
                                        <th class="total">小计</th>
                                    </tr>
                                    <tr class="bottom_line">
                                        <th colspan="4"></th>
                                    </tr>
                                </thead>
                            </table>
                            <?php foreach ($items as $store_id => $v): ?>
                                <table style="margin-top: 20px;border:0">
                                    <col width="auto" />
                                    <col width="150" />
                                    <col width="150" />
                                    <col width="120" />
                                    <thead>
                                        <tr>
                                            <td width="auto" colspan="4" align="left">商家：<?php echo Store::model()->findByPk($store_id)->name; ?></td>
                                        </tr>
                                        <tr class="bottom_line">
                                            <td colspan="4"></td>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlist<?php echo $store_id; ?>">
                                        <?php foreach ($v as $sku_id => $item): ?>
                                            <tr class="buy_checked <?php echo 'item' . $sku_id; ?>">
                                                <td class="desc">
                                                    <input type="hidden" name="items[<?php echo $store_id; ?>][<?php echo $sku_id; ?>]" value="<?php echo $item->quantity; ?>" class="J-choose" checked="checked" />
                                                    <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" target="_blank">
                                                        <img src="<?php echo $item->pic; ?>" width="60" height="60" />
                                                    </a>
                                                    <span style="height: 40px;">
                                                        <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" target="_blank">
                                                            <?php echo $item->title; ?>
                                                        </a>
                                                    </span>
                                                    <br />
                                                    <br />
                                                    <p class="props"><?php echo str_replace(';', ', ', $item->props); ?></p>
                                                </td>
                                                <td class="price"><span class="J-price"><?php echo $item->price; ?></span></td>
                                                <td class="deal-component-quantity">
                                                    <?php echo $item->quantity; ?>
                                                </td>
                                                <td class="money total">
                                                    <b class="sub_total" id="<?php echo 'item_' . $store_id . '_' . $sku_id . '_total'; ?>"><?php echo $item->total; ?></b>
                                                </td>
                                            </tr>
                                            <tr class="bottom_line">
                                                <td colspan="4"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td align="left">
                                                <label>给商家留言: </label>
                                                <span><input type="text" name="memo[<?php echo $store_id; ?>]" class="memo" maxlength="100"/></span>
                                            </td>
                                            <td align="right"></td>
                                            <td><?php echo CHtml::hiddenField("ship[{$store_id}]", 'express'); ?></td>
                                            <td class="money total"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td align="right"><b>店铺合计: </b></td>
                                            <td colspan="2" class="money total">
                                                ¥<b class="store_total" id="store_total_<?php echo $store_id?>" ><?php echo $sub_total[$store_id]; ?></b>
                                            </td>
                                        </tr>
                                        <tr class="bottom_line">
                                            <td colspan="4"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php endforeach; ?>
                            <table style="margin-top: 15px;">
                                <tr>
                                    <td class="extra-fee total-fee" colspan="2">
                                        <strong>实付款</strong>：<span class="inline-block money">¥<strong id="J-cart-total"><?php echo $amount; ?></strong></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="100">
                                        <input type="submit" class="btn btn-large btn-buy" name="buy" value="提交订单" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>