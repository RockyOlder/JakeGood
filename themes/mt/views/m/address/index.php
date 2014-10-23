
<style>
    #update{
        background: blue;
        font-size: 16px;
        float: right;
        color: white;
        height: 40px;
        width: 70px;
        text-align: center;
        line-height: 40px;
        margin-top: -30px;
    }  
    .label{ color:#000000}
    .order_head.oh_btn toPay{ margin-left: 20px;width: 70px;}
</style>
<body>
<!--    <script src="/themes/mt/js/jquery-1.11.1.min.js"></script>-->
    <script type="text/javascript">
       
    </script>
    <div class="wx_wrap">
        <div class="my_nav">
            <ul id="nav">
                <li class="cur" no="1"><a href="javascript:;">收货地址</a></li>
            </ul>
        </div>
        <?php $id = Yii::app()->user->getId(); ?>
        <div class="my_order_wrap">
            <div id="cont" class="my_order_inner" style="height: 703px;">
                <div class="my_order">
                    <div id="cont1">
                        <form id="active_form" method="post" class="" action="<?php echo $this->createUrl('save'); ?>">
                            <div class="order">
                                <div class="order_head">
                                    <input type="hidden" value="<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>" name="YII_CSRF_TOKEN" /> 
                                    <?php echo CHtml::activeHiddenField($model, $model->primaryKey()); ?>
                                    <div style="font-size:12px;margin-left: 50px;">电话号码、手机号选填一项,其余均为必填项</div>
                                </div>
                                <div class="order_item">
                                    <?php
                                    $url = Yii::app()->createUrl('member/address/getAreas');
                                    list($stateAreas, $cityAreas, $districtAreas) = $model->getAreas();
                                    ?>
                                    <label class="label">所在地区：<span>*</span></label>
                                    <div class="field">
                                        <?php
                                        echo CHtml::activeDropDownList($model, 'state', $stateAreas, array('class' => 'area area-state fl',
                                            'style' => 'width:100px',
                                            'data-child-area' => 'area-city',
                                            'data-url' => $url));

                                        echo CHtml::activeDropDownList($model, 'city', $cityAreas, array('class' => 'area area-city fl',
                                            'style' => 'width:100px',
                                            'data-child-area' => 'area-district',
                                            'data-url' => $url));

                                        echo CHtml::activeDropDownList($model, 'district', $districtAreas, array('class' => 'area area-district fl',
                                            'style' => 'width:100px'));
                                        ?>
                                        <div class="label"><?php echo $model->getAttributeLabel('zipcode'); ?>: <span>*</span></div>
                                        <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'zipcode', array('class' => 'form-control')); ?></div>
                                        <div class="clear"></div>

                                        <div class="label"><?php echo $model->getAttributeLabel('address'); ?>: <span>*</span></div>
                                        <div class="textarea" style="font-size:14px"><?php echo CHtml::activeTextarea($model, 'address', array('rows' => 3, 'cols' => 35, 'class' => 'form-control', 'placeholder' => "不需要重复填写省市区，必须大于5个字符，小于120个字符")); ?></div>
                                        <div class="clear"></div>


                                        <div class="label require"><?php echo $model->getAttributeLabel('name'); ?>: <span>*</span></div>
                                        <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'name', array('class' => 'form-control')); ?></div>
                                        <div class="clear"></div>

                                        <div class="label"><?php echo $model->getAttributeLabel('mobile'); ?>: <span>&nbsp;&nbsp;</span></div>
                                        <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'mobile', array('class' => 'form-control')); ?></div>
                                        <div class="clear"></div>

                                        <div class="label"><?php echo $model->getAttributeLabel('phone'); ?>: <span>&nbsp;&nbsp;</span></div>
                                        <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'phone', array('class' => 'form-control')); ?></div>
                                        <div class="clear"></div>

                                        <div class="label"></div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> 设为默认收货地址
                                            </label>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="label"></div>
                                        <div class="fl">
                                            <input type="submit" id="btn_submit" value="保存" class="btn btn-default" />
                                            &nbsp;&nbsp;
                                            <input type="submit" id="btn_submit" value="保存为新地址" class="btn btn-default" onclick="$('#AddressBook_id').val(0)" />
                                        </div>
                                        <?php foreach ($addresses as $v) { ?>
                                            <div class="order">
                                                <div class="order_head">
                                                    <?php echo ' ' . CHtml::link('删除', $this->createUrl('delete', array('id' => $v['id'])), array('class' => 'btn btn-danger')); ?>
                                                    <p><span>联系人：</span><em class="co_red"><?php echo $v['name'] ?></em></p>
                                                    <p><span>所在地区：</span><em class="co_red"><?php echo $v['area'] ?></em></p>
                                                    <p><span>街道地址：</span><em class="co_red"><?php echo $v['address'] ?></em></p>
                                                    <?php echo CHtml::link('编辑', $this->createUrl('', array('id' => $v['id'])), array('class' => 'btn btn-primary')); ?>
                                                    <p><span>邮政编码：</span><em class="co_red"><?php echo $v['zipcode'] ?></em></p>          
                                                    <p><span>手机/电话：</span><em class="co_red"><?php echo!$v['mobile'] ? $v['phone'] : $v['mobile'] ?></em></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <script type="text/javascript">

                                    </script>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="wx_nav">
                    <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/m/obj/index'); ?>">购物</a>
                    <a class="nav_search" href="<?php echo Yii::app()->createUrl('/m/item/list', array('p' => 1)); ?>">搜索</a>
                    <a class="nav_shopcart" href="<?php
                                        if (!empty($id)) {
                                            echo Yii::app()->createUrl('/m/cart');
                                        } else {
                                            echo Yii::app()->createUrl('/m/login');
                                        }
                                        ?>">购物车</a>
                    <a class="nav_me" href="<?php
                    if (!empty($id)) {
                        echo Yii::app()->createUrl('/m/order/personal');
                    } else {
                        echo Yii::app()->createUrl('/m/login');
                    }
                                        ?>">个人中心</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>