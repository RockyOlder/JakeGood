<form enctype="multipart/form-data" method="post" class="form-horizontal">
    <?php echo CHtml::hiddenField('YII_CSRF_TOKEN', Yii::app()->getRequest()->getCsrfToken()); ?>

    <div style="width:750px;" class="">
        <?php
        if ($model->hasErrors())
        {
            echo CHtml::errorSummary($model);
        }
        ?>
        <div class="form-body col-md-12">

            <div class="form-group">
                <div class="col-md-3 control-label"><p>店铺设置</p></div>
                <div class="title"><p class="help-block">带 <span class="required">*</span> 的字段为必填项.</p></div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('name'); ?>：<span>*</span></label>
                <div class="col-md-7"><?php echo Chtml::activeTextField($model, 'name', array('class' => 'required form-control')); ?></div>
                <span class="col-md-2 control-label">最多10个汉字</span>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('logo'); ?>：<span>*</span></label>
                <div class="col-md-5">
                    <?php echo CHtml::image($model->logo, $model->getAttributeLabel('logo'), array('style' => 'width:80px;height:80px;float:left')) ?>
                    <?php echo CHtml::fileField('Store[logo]', '', array('class' => 'form-control', 'style' => 'margin:45px 0 0 85px;')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('cid'); ?>：<span>*</span></label>
                <div class="col-md-5">
                    <?php echo Chtml::activeDropDownList($model, 'cid', ItemCats::model()->queryOptions('cid', 'name', 'is_parent=1 and parent_cid=0'), array('class' => 'form-control', 'style' => 'width:300px')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('introduction'); ?>：</label>
                <div class="col-md-5">
                    <?php echo Chtml::ActiveTextArea($model, 'introduction', array('style' => 'width:450px;height:150px', 'class' => 'form-control')); ?>
                    <label class="">最多500字</label>
                </div>

            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">地区：</label>
                <div class="col-md-7">
                    <?php
                    $url = Yii::app()->createUrl('seller/area/getChild');
                    list($states, $cites, $districts) = $model->getAreas();
                    ?>
                    <div class="col-lg-3" style="width:120px">
                        <?php echo CHtml::activeDropDownList($model, 'state', $states, array('class' => 'area area-state form-control', 'style' => 'width:120px', 'data-child-area' => 'area-city', 'data-url' => $url)); ?>
                    </div>
                    <div class="col-lg-3" style="width:120px">
                        <?php echo CHtml::activeDropDownList($model, 'city', $cites, array('class' => 'area area-city form-control', 'style' => 'width:120px', 'data-child-area' => 'area-district', 'data-url' => $url)); ?>
                    </div>
                    <div class="col-lg-3">
                        <?php echo CHtml::activeDropDownList($model, 'district', $districts, array('class' => 'area-district form-control', 'style' => 'width:120px')); ?>
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

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('address'); ?>：</label>
                <div class="col-md-5"><?php echo Chtml::activeTextField($model, 'address', array('class' => 'form-control')); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('zipcode'); ?>：</label>
                <div class="col-md-5"><?php echo Chtml::activeTextField($model, 'zipcode', array('class' => 'form-control')); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('phone'); ?>：</label>
                <div class="col-md-5"><?php echo Chtml::activeTextField($model, 'phone', array('class' => 'form-control')); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('have_store'); ?>：</label>
                <div class="col-md-5"><?php echo Chtml::activeRadioButtonList($model, 'have_store', array(0 => '否', 1 => '是'), array('separator' => '&nbsp;')); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo $model->getAttributeLabel('have_factory'); ?>：</label>
                <div class="col-md-5"><?php echo Chtml::activeRadioButtonList($model, 'have_factory', array(0 => '否', 1 => '是'), array('separator' => '&nbsp;')); ?></div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-5">
                    <?php
                    echo CHtml::submitButton(' 确 定 ', array('class' => 'btn btn-primary'));
                    echo " ";
                    echo CHtml::resetButton(' 取 消 ', array('class' => 'btn'));
                    ?>
                </div>

            </div>
        </div>
    </div>