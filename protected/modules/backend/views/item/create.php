
<style type="text/css">
    .item_prop_values div div {width:430px;float: left;max-height: 300px; overflow-y: auto}
    .item_prop_values div div span {display: block;}
    .item_prop_values div div span span {width:125px;float: left;}
    .item_prop_values .sku-map {width:100%}
    .label {padding-left:10px;}
    .form-group .control-label {max-width: 160px;}

    table.table-bordered>thead>tr>th {text-align: center;}
</style>
<form enctype="multipart/form-data" class="form-horizontal form-validate" id="item-form" action="" method="post">
    <?php echo CHtml::hiddenField('YII_CSRF_TOKEN', Yii::app()->getRequest()->getCsrfToken()); ?>

    <div class="form-body pal"  style="width:850px;">

        <div class="panel panel-white">
            <div class="panel-heading">
                类型与属性
            </div>
            <div class="panel-body pan">
                <?php $this->renderPartial("_form_type", array('model' => $model, 'cats' => $cats, 'shops' => $shops)) ?>
            </div>        
        </div>

        <div class="panel panel-white">
            <div class="panel-heading">
                基本信息
            </div>
            <div class="panel-body pan">
                <?php $this->renderPartial("_form_base", array('model' => $model)) ?>
            </div>        
        </div>
        
        <div class="panel panel-white">
            <div class="panel-heading">
                其他信息
            </div>
            <div class="panel-body pan">
                <?php $this->renderPartial("_form_other", array('model' => $model)) ?>
            </div>        
        </div>

        <div class="panel panel-white">
            <div class="panel-heading">
                商品图片<a name="itemImg"></a>
            </div>
            <div class="panel-body pan">
                <?php $this->renderPartial("_form_image", array('model' => $model)) ?>
            </div>        
        </div>

        <div class="panel panel-white">
            <div class="panel-heading">
                详细描述
            </div>
            <div class="panel-body pan">
                <?php $this->renderPartial("_form_desc", array('model' => $model)) ?>
            </div>        
        </div>


        <div class="row alert-danger" style="position: fixed;bottom: 0;z-index: 9999;width:760px;text-align: center;padding: 5px 0;margin:0;">
            <?php
            echo CHtml::submitButton(' 发  布 ', array('class' => 'btn btn-success btn-square'));
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo CHtml::resetButton(' 取  消 ', array('class' => 'btn btn-default btn-square', 'onclick' => 'history.back()'));
            ?>
        </div>
    </div>
