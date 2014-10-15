<form enctype="multipart/form-data" method="post">
    <?php echo CHtml::hiddenField('YII_CSRF_TOKEN', Yii::app()->getRequest()->getCsrfToken()); ?>
    <style type="text/css">
        .promotions {width: 100%; }
        .promotions tbody th {padding:3px 0;width:100px;}
        .promotions tbody td {padding:5px 0;}
    </style>
    <div class="">
        <?php
        if ($model->hasErrors())
        {
            echo CHtml::errorSummary($model);
        }
        elseif (!empty($_POST))
        {
            echo '<script>$(document).ready(function(){alert("设置成功");})</script>';
        }
        ?>
        <div class="">

            <table class="promotions">
                <tbody>
                    <tr>
                        <th height=60>优惠条件：</th>
                        <td>
                            买家消费者满<?php echo CHtml::activeTextField($model, 'money', array('size' => 10)); ?>元
                        </td>
                    </tr>
                    <tr>
                        <th>优惠内容：</th>
                        <td>
                            减<?php echo CHtml::activeTextField($model, 'discount', array('size' => 10)); ?>元
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo CHtml::activeCheckBox($model, 'free_shipping'); ?> 免邮
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo CHtml::activeCheckBox($model, 'coupon'); ?> 送优惠券
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo CHtml::activeCheckBox($model, 'gift'); ?> 送礼品
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            &nbsp;&nbsp;<button class="enter">保存</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="separator" style="height:14px;"></div>
    </div>
</form>