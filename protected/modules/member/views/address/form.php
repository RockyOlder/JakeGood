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


<h3>收货地址</h3>
<div class="line_2"></div>
<div class="clear" style="height:14px;"></div>

<?php if ($model->hasErrors() && 1==2) : ?>
    <div class="general_info_box error">
        <a href="#" class="close">x</a>
        <?php echo CHtml::errorSummary($model); ?>
    </div>
    <div class="clear" style="height:1px;"></div>
<?php endif; ?>

<div class="block_form" style="margin:0;">
    <form id="active_form" method="post" class="" action="<?php echo $this->createUrl('save'); ?>">
        <input type="hidden" value="<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>" name="YII_CSRF_TOKEN" /> 
        <?php echo CHtml::activeHiddenField($model, $model->primaryKey()); ?>
        
        <div style="font-size:12px;margin-left: 130px;">电话号码、手机号选填一项,其余均为必填项</div>
        <div class="clear"></div>
        
        <div class="">
            <?php
            $url = Yii::app()->createUrl('member/address/getAreas');
            list($stateAreas, $cityAreas, $districtAreas) = $model->getAreas();
            ?>
            <div>
                <label class="label">所在地区：<span>*</span></label>
                <div class="field">
                    <?php
                    echo CHtml::activeDropDownList($model, 'state', $stateAreas, array('class' => 'area area-state fl',
                        'style' => 'width:150px',
                        'data-child-area' => 'area-city',
                        'data-url' => $url));

                    echo CHtml::activeDropDownList($model, 'city', $cityAreas, array('class' => 'area area-city fl',
                        'style' => 'width:150px',
                        'data-child-area' => 'area-district',
                        'data-url' => $url));

                    echo CHtml::activeDropDownList($model, 'district', $districtAreas, array('class' => 'area area-district fl',
                        'style' => 'width:150px'));
                    ?>
                </div>
            </div>
            <div class="clear"></div>

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

            <div class="label"><?php echo $model->getAttributeLabel('zipcode'); ?>: <span>*</span></div>
            <div class="field" style="font-size:14px"><?php echo CHtml::activeTextField($model, 'zipcode'); ?></div>
            <div class="clear"></div>

            <div class="label"><?php echo $model->getAttributeLabel('address'); ?>: <span>*</span></div>
            <div class="textarea" style="font-size:14px"><?php echo CHtml::activeTextarea($model, 'address', array('rows' => 3, 'cols' => 60, 'placeholder' => "不需要重复填写省市区，必须大于5个字符，小于120个字符")); ?></div>
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
        </div>

    </form>
</div>
