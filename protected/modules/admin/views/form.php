
<script>
    $(function(){ 

        var validator = $("#formValidate").validate({
            rules: {
                <?php foreach($columns as $k=>$v):?>
                <?=$k?>: <?=$v['validate']['rules']?>  ,    
                <?php endforeach;?>         
            },
            messages: {
                <?php foreach($columns as $k=>$v):?>
                <?=$k?>:<?=$v['validate']['message']?>  ,    
                <?php endforeach;?>     
            },
           
        });
    })
  
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
    for(var i=1;i<=4;i++){
      $(".type_"+i).find('input').attr('disabled','disabled');
      $(".type_"+i).hide();
    }
    $(".type_"+id).find('input').removeAttr('disabled');
    $(".type_"+id).show();
  }
  
</script>
<style type="text/css">

</style>

<div class="title"><h5><?=$title?></h5></div>
<form id="formValidate" class="mainForm" method="post" action="<?php echo $this->createUrl('save', $_GET) ?>" enctype="multipart/form-data" >
          <fieldset>
                <div class="widget">
                    <div class="head"><h5 class="iLocked">填写下面表单</h5></div>

                    <?php foreach($columns as $k=>$v):?>
                    <div class="rowElem">
                        <label><?=$v['name']?>:<?=$v['validate']['rules']=='{required:false}'?'':'<span class="req">*</span>'?></label>
                        <div class="formRight"><?=$v['field']?></div><div class="fix"></div>
                    </div>
                     <?php endforeach;?>
                    <div class="submitForm">
					<input type="submit" value="submit" class="redBtn" />
					<input type="button" value="Cancel" onclick="window.location='<?php echo $this->createUrl('list', $_GET); ?>'" />
					</div>
                    <div class="fix"></div>
                </div>
                
            </fieldset>
        </form> 