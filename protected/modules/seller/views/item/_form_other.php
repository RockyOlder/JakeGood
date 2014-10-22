

<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('notice'); ?>：</label>
    <div class="col-lg-5">
        <?php echo CHtml::activeTextArea($model, 'notice', array('style' => 'width: 533px; height: 110px;')); ?>
        <em for="<?php echo CHtml::activeId($model, 'notice'); ?>" class="invalid"><?php echo $model->getError('notice'); ?></em>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('tips'); ?>：</label>
    <div class="col-lg-5">
        <?php echo CHtml::activeTextArea($model, 'tips', array('style' => 'width: 533px; height: 220px;')); ?>
        <em for="<?php echo CHtml::activeId($model, 'tips'); ?>" class="invalid"><?php echo $model->getError('tips'); ?></em>
    </div>
</div>