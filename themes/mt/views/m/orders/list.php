        <?php
        $id = Yii::app()->user->getId(); 
        $host=substr(Yii::app()->request->getUrl(),-1);
        $fOrderStatus = $statusOptions;
        $fOrderKey = array_keys($statusOptions);
        $fOrderStatus[0] = '全部';
        $fCommStatus = array('' => '全部', 0 => '未评', 1 => '已评');
        ?>
        <div class="wx_wrap">

            <div class="my_nav">
                <ul id="nav">
                    <li class="<?php if($host==0){echo 'cur';} ?>" no="1" >
                        <?php echo CHtml::link($fOrderStatus[0], $this->createUrl('/m/order', array('filter[orderStatus]' => $fOrderKey[0])), array('class' => 'oh')); ?>

                    <li no="2" class="<?php if($host==1){echo 'cur';} ?>"><a href="<?php echo Yii::app()->createUrl('/m/order', array('filter[orderStatus]' => $fOrderKey[1])); ?>"><?php echo $fOrderStatus[1]; ?></a></li>
                    <li no="3" class="<?php if($host==3){echo 'cur';} ?>"><a href="<?php echo Yii::app()->createUrl('/m/order', array('filter[orderStatus]' => $fOrderKey[3])); ?>"><?php echo $fOrderStatus[3]; ?></a></li>
                </ul>
            </div>
            <div class="my_order_wrap">
                <!--  height:100%;width:240px;overflow:scroll  -->
                <div id="cont" class="my_order_inner" style=" height:100%;">

                    <!-- S 所有订单 -->
                    <div class="my_order">
                        <div id="cont1">
                            <?php foreach ($orders as $k => $order) : ?>
                                <?php $countItems = count($order->OrderItem); ?>

                                <div class="order">
                                    <div class="order_head">
                                        <p><span>订单编号：</span><em class="co_red"> <?php echo $order->sn; ?></em></p>
                                        <p><span>成交时间：</span><em class="co_red"> <?php echo date('Y-m-d H:i:s', $order->created); ?></em></p>
                                        <p><span>商<i></i>品：</span><em class="co_red"> <?php echo $countItems; ?>件</em></p>
                                        <p><span>状<i></i>态：</span><em class="co_red"><?php echo $statusOptions[$order->status]; ?></em></p>
                                        <p><span>总<i></i>价：</span><em class="co_red"><?php echo $order->amount; ?></em></p> 
                                        <?php
                                        if ($order->status == 2) {
                                            // echo 2;exit;
                                            echo CHtml::link('确认收货', $this->createUrl('/m/order/confirm', array('sn' => $order->sn)), array('class' => 'oh_btn toPay'));
                                            echo CHtml::link('申请退款', $this->createUrl('refund/order', array('sn' => $order->sn)), array('class' => 'btn-hot btn-mini'));
                                        } elseif ($order->status == 3) {
                                            //   echo 3;exit;
                                            echo CHtml::link('确认收货', $this->createUrl('/m/order/confirm', array('sn' => $order->sn)), array('class' => 'oh_btn toPay'));
                                        } else if ($order->is_pay == 0) {
                                            //  echo 1;exit;
                                            echo CHtml::link('去支付', $this->createUrl('/m/order/pay', array('sn' => $order->sn)), array('class' => 'oh_btn toPay'));
                                        }
                                        ?>
                                        <a id="update" href="<?php echo $this->createUrl('/m/order/detail', array('sn' => $order->sn)); ?>">查看详情</a>
                                    </div>
                                    <?php foreach ($order->OrderItem as $itemk => $item) : ?>	
                                        <div class="order_item">

                                            <a href="<?php echo $this->createUrl('/m/item/detail', array('item_id' => $item->item_id)); ?>" class="oi_content" page="1">
                                                <img width="50" height="50" src="<?php echo $item->pic; ?>" class="image">
                                                <p><?php echo $item->title; ?></p>
                                                <p><span class="count"><?php echo $item->quantity; ?>件</span><span class="price"></span></p>
                                            </a> 
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <?php
                            if (!$orders) {
                                echo "<br />&nbsp;&nbsp;暂无数据";
                            }
                            ?>
                        </div>
                        <div class="wx_ending">已经没有更多订单了！</div>
                    </div>
                                <div class="wx_nav">
                <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/m/obj/index'); ?>">购物</a>
                <a class="nav_search" href="<?php echo Yii::app()->createUrl('/m/item/list',array('p' => 1)); ?>">搜索</a>
                <a class="nav_shopcart" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/cart');}else{echo Yii::app()->createUrl('/m/login');} ?>">购物车</a>
                <a class="nav_me" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/order/personal');}else{echo Yii::app()->createUrl('/m/login');} ?>">个人中心</a>
            </div>
                </div>
            </div>
        </div>
