
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/assets/js/jquery.form.js', CClientScript::POS_END);
?>
<div class="clearfix" style="height: 5px"></div>
<div class="form-group">
    <label class="col-lg-3 control-label">
        <?php echo $model->getAttributeLabel('cid'); ?> : <span class="require">*</span>
    </label>
    <div class="col-lg-9">
        <?php echo CHtml::activeDropDownList($model, 'cid', $cats, array('class' => 'form-control required input-medium')); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12">
        <div style="padding-top:10px; background: #f0f2f5;border: 1px solid #ddd;">
            <div id="item_prop_values"></div>
            <div id="">
                <div class="form-group">
                    <label class="col-lg-3 control-label">
                        分店 : <span class="require">*</span>
                    </label>
                    <div class="col-lg-9">
                        <div id="shops" style="padding:5px;max-height: 130px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">上架时间 :</label>
    <div class="col-lg-9">
        <?php echo CHtml::activeTextField($model, 'list_time', array('class' => 'form-control input-small required datepiker')); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">有限期 :</label>
    <div class="col-lg-9">
        <?php echo CHtml::activeTextField($model, 'expiry_date', array('class' => 'form-control input-small required datepiker')); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#Item_cid').change(function () {
            var cid = $(this).val();
            getProps(cid);
            getShops(cid);
        });
        getProps($('#Item_cid').val());
        getShops($('#Item_cid').val());
        
        $('#Item_shop_id').change(function () {
            var pid = $(this).val();
        });
        
    });
    var getProps = function(cid) {
        $.get('<?php echo Yii::app()->createUrl('/seller/item/itemProps'); ?>',
            {"cid": cid,"item_id": "<?php echo $model->item_id; ?>"}, 
            function(response) {
                $('#item_prop_values').empty();
                if(response != '')
                {
                    $('#item_prop_values').fadeIn(300);
                    $('#item_prop_values').append(response);
                }
                else
                {
                    $('#item_prop_values').hide();
                }
            }
        );
    };
    var getShops = function(cid) {
        $('#sub_shops').empty();
        $.get('<?php echo Yii::app()->createUrl('/seller/item/getShops'); ?>',
                  {cid:cid, item_id:<?php echo (int) $model->item_id; ?>},
                  function (res) {
                      $('#shops').empty();
                      $('#shops').append(res);
                  }
            );
    }
</script>


