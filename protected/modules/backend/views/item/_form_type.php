
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
        <?php echo CHtml::activeDropDownList($model, 'cid', $cats, array('class' => 'form-control input-medium')); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12">
        <div style="padding-top:10px; background: #f0f2f5;border: 1px solid #ddd;">
            <div id="item_prop_values"></div>
            <div id="">
                <div class="form-group">
                    <label class="col-lg-3 control-label">
                        商家 : <span class="require">*</span>
                    </label>
                    <div class="col-lg-9">
                        <div id="shops">
                            <?php echo CHtml::activeDropDownList($model, 'shop_id', $shops, array('class' => 'form-control input-medium')); ?>
                        </div>
                        <div id="sub_shops" style="width:450px;padding:5px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    $dateline = 0;
    $expValue = array('', '');
    if (is_numeric($model->expiry_date))
    {
        $dateline = 3;
        $expValue[0] = $model->expiry_date;
    }
    elseif ( !empty ($model->expiry_date))
    {
        $d = explode('-', $model->expiry_date);
        if (count($d) == 3)
        {
            $dateline = 2;
            $expValue[0] = $model->expiry_date;
        }
        else
        {
            $dateline = 1;
            $expValue = $d;             
        }
    }
?>
<div class="form-group">
    <label class="col-md-3 control-label">有限期 : <br />只能选一种</label>
    <div class="col-lg-9">
        <div id="expirydatepanel">
            <div>
                <div id="expirydate_1" class="form-group">
                    <label class="col-md-8" data-disabled="1">
                        <span class="col-lg-1 control-label">
                        <?php echo CHtml::radioButton('expirytype', ($dateline==1 ? TRUE : FALSE), array('value' => '1')); ?>
                        </span>
                        <span class="col-lg-3 control-label">起止日期</span>
                        <div class="col-lg-3 ">
                            <input type="text" name="expirydate_start" value="<?php echo $dateline==1 ? $expValue[0] : '' ; ?>" class="form-control  input-small"/>
                        </div>
                        <div class="col-lg-3 ">
                            <input type="text" name="expirydate_end" value="<?php echo $dateline==1 ? $expValue[1] : '' ; ?>" class="form-control input-small" />
                        </div>
                    </label>
                </div>
                <div id="expirydate_2" class="form-group">
                    <label class="col-lg-8" data-disabled="1">
                        <span class="col-lg-1 control-label">
                            <?php echo CHtml::radioButton('expirytype', ($dateline==2 ? TRUE : FALSE), array('value' => '2')) ?>
                        </span>
                        <span class="col-lg-3 control-label">
                        购买日至
                        </span>
                        <div class="col-lg-3 " data-disabled="1">
                            <input type="text" name="expirydate" value="<?php echo $dateline==2 ? $expValue[0] : '' ; ?>" class="form-control input-small"/>
                        </div>
                    </label>
                </div>
                <div id="expirydate_3" class="form-group">
                    <label class="col-lg-8">
                        <span class="col-lg-1 control-label">
                            <?php echo CHtml::radioButton('expirytype', ($dateline==3 ? TRUE : FALSE), array('value' => '3')) ?>
                        </span>
                        <span class="col-lg-3 control-label">
                        有效天数
                        </span>
                        <div class="col-lg-3 ">
                            <input type="text" name="expiryday" value="<?php echo $dateline==3 ? $expValue[0] : '' ; ?>" class="form-control input-small" />
                        </div>
                    </label>                    
                </div>
            </div>
        </div>

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
            getSubShops(pid);
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
                      var pid = $('#Item_shop_id').val();
                      if (pid > 0) {
                          getSubShops(pid);
                      }
                      
                      $('#Item_shop_id').change(function () {
                            var pid = $(this).val();
                            getSubShops(pid);
                        });
                  }
            );
    }
    var getSubShops = function(pid) {
        $.get('<?php echo Yii::app()->createUrl('/seller/item/getShops'); ?>',
                {parent_id:pid, item_id:<?php echo (int) $model->item_id; ?>},
                function (res) {
                    $('#sub_shops').empty();
                    $('#sub_shops').append(res);
                }
          );
    }
</script>


