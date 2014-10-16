<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <title>订单列表</title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/themes/mt/mobile/css/order_list.css" />
        <script type="text/javascript" src="/themes/mt/js/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/index.css" />
    </head>
    <style>
        #update{
            background: #e4393c;
            font-size: 16px;
            float: right;
            color: white;
            height: 40px;
            width: 80px;
            text-align: center;
            line-height: 40px;
            margin-top: -30px;
        }  
        .oh_btn toPay{ margin-left: 20px;}
    </style>
    <body>
        <script type="text/javascript">

            jQuery.validator.addMethod("zipcode", function(value, element) {
                var tel = /^[0-9]{6}$/;
                return this.optional(element) || (tel.test(value));
            }, "请正确填写邮政编码");

            jQuery.validator.addMethod("area", function(value, element) {
                return value != 0;
            }, "");


            $().ready(function() {
 
                $("#active_form").validate({
                    rules: {
                        'AddressBook[name]': {required: true, minlength: 2, maxlength: 20},
                        'AddressBook[zipcode]': {required: true, zipcode: true},
                        'AddressBook[address]': {required: true, minlength: 5, maxlength: 200},
                    },
                    messages: {
                        'AddressBook[name]': {
                            required: "请输入联系人姓名",
                            minlength: "请输入正确的姓名"
                        },
                        'AddressBook[zipcode]': "请正确填写邮政编码",
                        'AddressBook[address]': {
                            required: "请输入详细地址",
                            minlength: "最少5字",
                            maxlength: "最长200字"
                        },
                    }
                });
            });
        </script>
        <div class="wx_wrap">
            <div class="my_nav">
                <ul id="nav">
                    <li class="cur" no="1"><a href="javascript:;">收货地址</a></li>
                </ul>
            </div>
<?php  $id = Yii::app()->user->getId(); ?>
            <div class="my_order_wrap">
                <div id="cont" class="my_order_inner" style="height: 703px;">

                    <!-- S 所有订单 -->
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
                                                'style' => 'width:110px',
                                                'data-child-area' => 'area-city',
                                                'data-url' => $url));

                                            echo CHtml::activeDropDownList($model, 'city', $cityAreas, array('class' => 'area area-city fl',
                                                'style' => 'width:110px',
                                                'data-child-area' => 'area-district',
                                                'data-url' => $url));

                                            echo CHtml::activeDropDownList($model, 'district', $districtAreas, array('class' => 'area area-district fl',
                                                'style' => 'width:110px'));
                                            ?>
                                            <div class="label"><?php echo $model->getAttributeLabel('zipcode'); ?>: <span>*</span></div>
                                            <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'zipcode'); ?></div>
                                            <div class="clear"></div>

                                            <div class="label"><?php echo $model->getAttributeLabel('address'); ?>: <span>*</span></div>
                                            <div class="textarea" style="font-size:14px"><?php echo CHtml::activeTextarea($model, 'address', array('rows' => 3, 'cols' => 40, 'placeholder' => "不需要重复填写省市区，必须大于5个字符，小于120个字符")); ?></div>
                                            <div class="clear"></div>


                                            <div class="label require"><?php echo $model->getAttributeLabel('name'); ?>: <span>*</span></div>
                                            <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'name', array('class' => 'required')); ?></div>
                                            <div class="clear"></div>

                                            <div class="label"><?php echo $model->getAttributeLabel('mobile'); ?>: <span>&nbsp;&nbsp;</span></div>
                                            <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'mobile'); ?></div>
                                            <div class="clear"></div>

                                            <div class="label"><?php echo $model->getAttributeLabel('phone'); ?>: <span>&nbsp;&nbsp;</span></div>
                                            <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'phone'); ?></div>
                                            <div class="clear"></div>

                                            <div class="label"></div>
                                            <div class=""><?php echo CHtml::activeCheckBox($model, 'default'); ?>设为默认收货地址</div>
                                            <div class="clear"></div>

                                            <div class="label"></div>
                                            <div class="fl">
                                                <input type="submit" id="btn_submit" value="保存" class="general_button standart type_1" />
                                                &nbsp;&nbsp;
                                                <input type="submit" id="btn_submit" value="保存为新地址" class="general_button standart type_1" onclick="$('#AddressBook_id').val(0)" />
                                            </div>
                                            <?php foreach ($addresses as $v) { ?>
                                                <div class="order">
                                                    <div class="order_head">
                                                        <p><span>联系人：</span><em class="co_red"><?php echo $v['name'] ?></em></p>
                                                        <p><span>所在地区：</span><em class="co_red"><?php echo $v['area'] ?></em></p>
                                                        <p><span>街道地址：</span><em class="co_red"><?php echo $v['address'] ?></em></p>
                                                        <p><span>邮政编码：</span><em class="co_red"><?php echo $v['zipcode'] ?></em></p>
                                                        <p><span>手机/电话：</span><em class="co_red"><?php echo!$v['mobile'] ? $v['phone'] : $v['mobile'] ?></em></p>
                                                        <?php
                                                        echo CHtml::link('编辑', $this->createUrl('', array('id' => $v['id'])), array('id' => 'update'));
                                                        echo ' ' . CHtml::link('删除', $this->createUrl('delete', array('id' => $v['id'])), array('class' => 'oh_btn toPay'));
                                                        ?>

                                                    </div>

                                                </div>
                                            <?php } ?>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('.area').change(function() {
                                                    var area = $(this);
                                                    $.get($(this).data('url'), {'parent_id': $(this).val()}, function(options) {
                                                        var html = '';
                                                        for (var value in options) {
                                                            html += '<option value="' + value + '">' + options[value] + '</option>';
                                                        }
                                                        var childArea = $('.' + area.data('child-area'));
                                                        childArea.html(html);
                                                        while (childArea.data('child-area')) {
                                                            childArea = $('.' + childArea.data('child-area'));
                                                            childArea.html('');
                                                        }
                                                    }, 'json');
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="wx_nav">
                        <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/mobile/obj/ceshi'); ?>">购物</a>
                        <a class="nav_search" href="<?php echo Yii::app()->createUrl('/mobile/item/list',array('p' => 1)); ?>">搜索</a>
                        <a class="nav_shopcart" href="<?php
                                            if (!empty($id)) {
                                                echo Yii::app()->createUrl('/mobile/cart');
                                            } else {
                                                echo Yii::app()->createUrl('/mobile/login');
                                            }
                                            ?>">购物车</a>
                        <a class="nav_me" href="<?php
                           if (!empty($id)) {
                               echo Yii::app()->createUrl('/mobile/order/personal');
                           } else {
                               echo Yii::app()->createUrl('/mobile/login');
                           }
                                            ?>">个人中心</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>