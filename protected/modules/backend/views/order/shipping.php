<script type="text/javascript">

    $().ready(function() {
        $("#active_form").validate({
            rules: {
                'AddressBook[name]': {required: true, minlength: 2, maxlength: 20},
                'AddressBook[zipcode]': {required: true, zipcode: true},
                'AddressBook[address]': {required: true, minlength: 5, maxlength: 200},
                'OrderShip[sn]': {required: true, minlength: 5, maxlength: 25},
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
                'OrderShip[sn]': "请填写正确快递单号",
            }
        });

    });

<?php
    $addr = array();
    foreach ($addresses as $v)
    {
        $addr[$v->id] = $v->getAttributes();
    }
    echo 'var addresses = ' . json_encode($addr) . ';';
?>

    function selectAddress(id) {
        $('#AddressBook_name').val(addresses[id].name);
        $('#AddressBook_address').val(addresses[id].address);
        $('#AddressBook_phone').val(addresses[id].phone);
        $('#AddressBook_mobile').val(addresses[id].mobile);

        $('#AddressBook_state').val(addresses[id].state);
        var area = $('#AddressBook_city');
        $.get($('#AddressBook_state').data('url'), {'parent_id': addresses[id].state}, function(options) {
            var html = '';
            for (var value in options) {
                html += '<option value="' + value + '">' + options[value] + '</option>';
            }
            var childArea = $('#AddressBook_city');
            childArea.html(html);
            while (childArea.data('child-area')) {
                childArea = $('.' + childArea.data('child-area'));
                childArea.html('');
            }

            $('#AddressBook_city').val(addresses[id].city);

            $.get($('#AddressBook_city').data('url'), {'parent_id': addresses[id].city}, function(options) {
                var html = '';
                for (var value in options) {
                    html += '<option value="' + value + '">' + options[value] + '</option>';
                }
                var childArea = $('#AddressBook_district');
                childArea.html(html);
                while (childArea.data('child-area')) {
                    childArea = $('.' + childArea.data('child-area'));
                    childArea.html('');
                }
                $('#AddressBook_district').val(addresses[id].district);
            }, 'json');

        }, 'json');

    }
</script>

<div class="col-lg-12">

    <?php if ($model->hasErrors()) :?>
        <div class="general_info_box error">
            <a href="#" class="close">Close</a>
        <?php echo CHtml::errorSummary($model); ?>
        </div>
    <?php endif; ?>

    <div class="block_form" style="margin:0; width: 750px;">
        <form id="active_form" method="post" class="form-horizontal" action="">
            <input type="hidden" value="<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>" name="YII_CSRF_TOKEN" /> 
            <?php echo CHtml::activeHiddenField($model, $model->primaryKey()); ?>
            <div class="form-body">
                <div class="panel panel-info">
                    <div class="panel-heading">发货地址</div>
                    <div class="panel-body pan">
                        <div class="form-group" style="margin-top:10px;">
                            <?php foreach ($addresses as $v) : ?>
                            <div class="col-md-10" style="margin-left: 10%;">
                                <label onclick="selectAddress($(this).data('value'))" data-value="<?php echo $v->id; ?>">
                                    <input type="radio" name="bookId" value="<?php echo $v->id; ?>"> 
                                    <?php echo $v['name'] ?> &nbsp;&nbsp; <?php echo $v['mobile'] ?> &nbsp;&nbsp; <?php echo $v['area'] ?> <?php echo $v['address'] ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
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
                            <div class="textarea col-lg-8"><?php echo CHtml::activeTextarea($model, 'address', array('class' => 'required form-control')); ?></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('name'); ?>: <span>*</span></div>
                            <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'name', array('class' => 'required form-control')); ?></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label"><?php echo $model->getAttributeLabel('phone'); ?>: </div>
                            <div class="col-md-5"><?php echo CHtml::activeTextField($model, 'phone', array('class' => 'required form-control')); ?></div>
                        </div>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">收货地址</div>
                    <div class="panel-body pan">
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-md-3 control-label">收货人: </div>
                            <div class="col-md-5">
                                <?php echo CHtml::textField('receiver[name]', $order->receiver_name, array('class' => 'required form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-md-3 control-label">联系电话: </div>
                            <div class="col-md-5">
                                <?php echo CHtml::textField('receiver[phone]', $order->receiver_mobile.'/'.$order->receiver_phone, array('class' => 'required form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-md-3 control-label">收货地址: </div>
                            <div class="col-md-8">
                                <?php echo CHtml::textArea('receiver[address]', $order->receiver_address, array('class' => 'required  form-control'))?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-yellow">
                    <div class="panel-heading">快递</div>
                    <div class="panel-body pan">
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-md-3 control-label">快递公司: </div>
                            <div class="col-md-5">
                                <?php
                                echo CHtml::dropDownList('OrderShip[type_code]', '', $shippingTypes
                                        , array('style' => 'width:150px', 'onchange' => '$("#OrderShip_type").val($(this).val())', 'class' => 'form-control'));
                                echo CHtml::TextField('OrderShip[type]', '', array('style' => 'display:none'));
                                ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label">快递单号: </div>
                            <div class="col-md-5"><?php echo CHtml::TextField('OrderShip[sn]', '', array('class' => 'required form-control')); ?></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label"> </div>
                            <div class="col-md-5">
                                <input type="submit" id="btn_submit" value=" 确 定 " class="btn btn-pink"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>