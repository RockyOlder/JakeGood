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

<?php if ($model->hasErrors()) : ?>
    <div class="general_info_box error">
        <a href="#" class="close">Close</a>
    <?php echo CHtml::errorSummary($model); ?>
    </div>
<?php endif; ?>

<div class="col-md-10" style="margin:0;max-width: 750px;">
    <form id="active_form" method="post" class="form-horizontal" action="<?php echo $this->createUrl('save'); ?>">
        <input type="hidden" value="<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>" name="YII_CSRF_TOKEN" /> 
        <?php echo CHtml::activeHiddenField($model, $model->primaryKey()); ?>
        <div class="form-body">
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo ($model->getIsNewRecord() ? '添加新地址' : '更改地址'); ?></div>
                <div class="panel-body">
                    <?php
                    $url = Yii::app()->createUrl('seller/item/getChildAreas');
                    list($stateAreas, $cityAreas, $districtAreas) = $model->getAreas();
                    ?>

                    <div class="form-group">
                        <div class="col-md-3 control-label">所在地区: <span>*</span></div>
                        <div class="col-md-8" style="padding: 0">
                            <div class="col-md-4" style="padding:0 0 0 15px;">
                                <?php
                                echo CHtml::activeDropDownList($model, 'state', $stateAreas, array('class' => 'area area-state form-control',
                                    'data-child-area' => 'area-city',
                                    'data-url' => $url));
                                ?>
                            </div>
                            <div class="col-md-4" style="padding:1px;">
                                <?php
                                echo CHtml::activeDropDownList($model, 'city', $cityAreas, array('class' => 'area area-city form-control',
                                    'data-child-area' => 'area-district',
                                    'data-url' => $url));
                                ?>
                            </div>
                            <div class="col-md-4" style="padding:1px;">
                                <?php
                                echo CHtml::activeDropDownList($model, 'district', $districtAreas, array('class' => 'area area-district form-control'));
                                ?>
                            </div>
                        </div>
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

                    <div class="form-group">
                        <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('address'); ?>: <span class="require">*</span></div>
                        <div class="col-md-7"><?php echo CHtml::activeTextarea($model, 'address', array('class' => 'required form-control')); ?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('zipcode'); ?>: <span>*</span></div>
                        <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'zipcode', array('class' => 'required form-control')); ?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('name'); ?>: <span>*</span></div>
                        <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'name', array('class' => 'required form-control')); ?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('phone'); ?>: </div>
                        <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'phone', array('class' => 'required form-control')); ?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('mobile'); ?>: </div>
                        <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'mobile', array('class' => 'required form-control')); ?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('company'); ?>: </div>
                        <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'company', array('class' => 'required form-control')); ?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"> &nbsp;</div>
                        <div class="col-md-5"><?php echo CHtml::activeCheckBox($model, 'default'); ?>设为默认地址</div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"> </div>
                        <div class="col-md-5">
                            <input type="submit" id="btn_submit" value=" 确 定 " class="btn btn-blue"/>
                            <input type="button" id="btn_submit" value=" 取 消 " class="btn" onclick="window.location = '<?php echo $this->createUrl('index') ?>'"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
