
<div class="clearfix" style="height: 5px"></div>

<?php if ($model->name): ?>
<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('name'); ?>：<span class="require" class="require">*</span></label>
    <div class="col-lg-7">
        <?php echo $model->name; ?>
    </div>
</div>
<?php endif; ?>
<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('title'); ?>：<span class="require" class="require">*</span></label>
    <div class="col-lg-7">
        <?php echo CHtml::activetextField($model, 'title', array('class' => 'form-control required')); ?>
        <em for="<?php echo CHtml::activeId($model, 'title'); ?>" class="invalid"><?php echo $model->getError('title'); ?></em>
    </div>
    <div class="col-lg-2">
    <label class="form-control-static">最多100个汉字</label>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('price'); ?>：<span class="require">*</span></label>
    <div class="col-lg-5">
        <?php echo CHtml::activetextField($model, 'price', array('class' => 'form-control input-small required number')); ?>
        <em for="<?php echo CHtml::activeId($model, 'price'); ?>" class="invalid"><?php echo $model->getError('price'); ?></em>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('orig_price'); ?>：</label>
    <div class="col-lg-5">
        <?php echo CHtml::activetextField($model, 'orig_price', array('class' => 'form-control input-small number')); ?>
        <em for="<?php echo CHtml::activeId($model, 'orig_price'); ?>" class="invalid"><?php echo $model->getError('orig_price'); ?></em>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('commission'); ?>：</label>
    <div class="col-lg-5">
        <?php echo CHtml::activetextField($model, 'commission', array('class' => 'form-control input-mini required number col-lg-3', 'min' => 8)); ?>
        <label class="form-control-static"><b>%</b></label>
        <label class="form-control-static" id="comm_calculat">=<?php echo $model->price*$model->commission/100; ?></label>
        <em for="<?php echo CHtml::activeId($model, 'commission'); ?>" class="invalid"><?php echo $model->getError('num'); ?></em>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label"><?php echo $model->getAttributeLabel('num'); ?>：</label>
    <div class="col-lg-5">
        <?php echo CHtml::activetextField($model, 'num', array('class' => 'form-control input-small required number')); ?>
        <em for="<?php echo CHtml::activeId($model, 'num'); ?>" class="invalid"><?php echo $model->getError('num'); ?></em>
    </div>
</div>

<script>
    $('#Item_commission').keyup(function () {
        var price = $('#Item_price').val();
        var ratio = $(this).val();
        var comm = Math.round(price*ratio)/100;
        $('#comm_calculat').html('='+(comm));
    });
</script>