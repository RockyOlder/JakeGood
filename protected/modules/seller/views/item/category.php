
<style type="text/css">
    .item_cats_box {min-width: 760px; height:310px; padding:5px 0; overflow-x: auto; overflow-y: hidden;}
    #item_cats {}
    #item_cats .sublist {display: inline-block; margin: 0 5px; border: 1px solid #ddd; min-width: 180px; width: 20%; height:300px; overflow-x:hidden; overflow-y: auto;}
    #item_cats .sublist ul {padding: 5px; width: 100%; height:100%; }
    #item_cats ul li{border-bottom: 1px dotted #ddd; width: 100%; height: 25px; line-height: 25px; overflow: hidden; cursor: pointer;}
    #item_cats ul li.active{color:#f24024;}
    #item_cats ul li:hover{color:#EC975E;}
</style>
<div class="row">
    <div class="col-lg-10">
        <h3>选择类目</h3>
        <div class="separator" style="height:8px;"></div>
        <div>
            <form method="get">
            <div class="fl col-lg-11" >
                <?php echo CHtml::HiddenField('cid', 0, array('id' => 'cid')); ?>
                <div class="item_cats_box">
                    <div id="item_cats"></div>
                </div>
                <div style="padding:10px;">
                   类目： <span id="my_item_cat"></span>
                </div>
                <div style="padding-bottom:10px;text-align:center;">
                    <input type="submit" class="general_button standart" value="确定类目, 去发布宝贝">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var getItemCats = function (cid, level, is_parent) {

            for(i = level; i < 10; i++)
            {
                $('#cats'+i).remove();
            }
            var my_item_cat = '';
            $('#item_cats .active').each(function () {
                my_item_cat += $(this).attr('title')+' >> ';
            });
            $('#my_item_cat').html(my_item_cat);

            if (is_parent == 0) return '';
            var url = "<?php echo $this->createAbsoluteUrl('//api/itemCats/get'); ?>";
            $.get(url, {'parent_cid': cid}, function (data) {

                if (data.ret == 0)
                {
                    var html = '<div class="sublist" id="cats'+level+'" ><ul>';
                    for (var i in data.v) 
                    {
                        next = '';
                        if (data.v[i].is_parent == 1) next = '&nbsp;&nbsp;<b>></b>';
                        html += '<li is_parent="'+data.v[i].is_parent+'" title="'+data.v[i].name+'" value="' + data.v[i].cid + '">' + data.v[i].name + next + '</li>';
                    }
                    html += '</ul></div>';
                    if (cid == 0)
                    {
                       $('#item_cats').html(html);
                    }
                    else
                    {
                        //$('#item_cats').css('width', 210*(level+1)+'px');
                        $('#item_cats').append(html);
                    }
                    $('#cats'+level+' li').click(function () {
                        $('#cid').val($(this).attr('value'));
                        $('#cats'+level+' li').removeClass('active');
                        $(this).addClass('active');
                        getItemCats($(this).attr('value'), level+1, $(this).attr('is_parent'));
                    });
                }
            }, 'json');
        };
        getItemCats(0, 0, 1);
    });
</script>


