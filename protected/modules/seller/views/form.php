
<script>
    $(function(){

    var validator = $("#formValidate").validate({
    rules: {
<?php foreach ($columns as $k => $v): ?>
    <?= $k ?>: <?= $v['validate']['rules'] ?>,
<?php endforeach; ?>
    },
            messages: {
<?php foreach ($columns as $k => $v): ?>
    <?= $k ?>:<?= $v['validate']['message'] ?>,
<?php endforeach; ?>
            },
    });
    });
            $(document).ready(function(e) {
    $(".type_box").each(function(index, element) {
    $(element).find("input").click(function(e) {
    change_type($(this).val());
    });
    });
            $(".spancolor").each(function(index, element) {
    $(element).find("label").click(function(e) {
    $(element).find("label").removeClass("label_color");
            $(this).addClass("label_color");
    });
    });
            $(".check_spancolor").click(function(e) {
    $(".check_spancolor").find("label").removeClass("label_color");
            $(".check_spancolor input:checked").parent().parent().parent().addClass("label_color");
    });
    });
            function change_type(id){
            for (var i = 1; i <= 4; i++){
            $(".type_" + i).find('input').attr('disabled', 'disabled');
                    $(".type_" + i).hide();
            }
            $(".type_" + id).find('input').removeAttr('disabled');
                    $(".type_" + id).show();
            }

</script>
<style type="text/css">

</style>

<div class="title"><h5><?= $title ?></h5></div>
<form id="formValidate" class="form-horizontal form-validate" method="post" action="<?php echo $this->createUrl('save', $_GET) ?>" enctype="multipart/form-data" >
    <fieldset>
        <div class="widget">
            <div class="head"><h5 class="iLocked">填写下面表单</h5></div>

            <?php foreach ($columns as $k => $v): ?>
                <div class="form-group">
                    <label class="col-lg-3 control-label"><?= $v['name'] ?>:<?= $v['validate']['rules'] == '{required:false}' ? '' : '<span class="require">*</span>' ?></label>
                    <div class="col-lg-5"><?= $v['field'] ?></div><div class="fix"></div>
                </div>
            <?php endforeach; ?>
            <div class="row alert-danger" style="text-align: center;padding: 5px 0;margin:0;">
                <input type="submit" value="submit" class="btn btn-success btn-square" />
                <input type="button" value="Cancel" class="btn btn-default btn-square" onclick="window.location = '<?php echo $this->createUrl('list', $_GET); ?>'" />
            </div>
            <div class="fix"></div>
        </div>

    </fieldset>
</form> 

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