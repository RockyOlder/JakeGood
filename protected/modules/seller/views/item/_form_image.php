<style type="text/css">
    #img-area {
        min-height: 70px;
    }

    .img-plus {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        box-sizing: border-box;
        border: 2px dashed #000;
        font-size: 60px;
        font-weight: 500;
        cursor: pointer;
        line-height: 50px;
        text-align: center;
        display: inline-block;
    }

    .img-item,
    .img-item img {
        width: 60px;
        height: 60px;
        display: inline-block;
    }

    .img-item {
        position: relative;
        vertical-align: top;
        margin-right: 20px;
    }

    .img-item img {
        border: 0;
    }

    .img-item .overlay {
        position: absolute;
        width: 60px;
        height: 60px;
        opacity: 0.5;
        filter: alpha(opacity=50);
        background-color: #000;
        z-index: 5;
        top: 0;
        display: none;
    }

    .img-item .operater {
        position: absolute;
        z-index: 10;
        height: 10px;
        display: block;
        top: 35px;
        width: 60px;
        display: none;
    }

    .img-item .prev,
    .img-item .next {
        display: inline-block;
        content: '';
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        cursor: pointer;
    }

    .img-item .prev {
        border-right: 8px solid #ccc;
        margin-left: 7px;
    }

    .img-item .next {
        border-left: 8px solid #ccc;
        margin-right: 7px;
    }

    .img-item .del {
        display: inline-block;
        width: 16px;
        margin: 0 7px;
        color: #ccc;
        font-size: 20px;
        text-align: center;
        font-weight: normal;
        cursor: pointer;
    }

    /* forbid double click*/
    .img-item .prev,
    .img-item .next,
    .img-item .del {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* elfinder popup */
    .elfinder-popup {
        display: none;
        width: 100%;
        height: 400px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0 4px 2px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        position: relative;
    }

    .elfinder-popup .close {
        display: block;
        position: absolute;
        right: 5px;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        background: #F7F7F7;
        color: #272629;
        font-weight: bold;
        cursor: pointer;
        border-radius: 2px;
        border: 1px solid #bbb;
        top: 6px;
        font-family: Arial,Helvetica;
    }
    .elfinder-popup .close:hover {color: #000;}

    .elfinder-popup iframe {
        width: 100%;
        height: 380px;
        border: 0;
    }

</style>

<div id="elfinder" class="elfinder-popup"><a class="close">x</a></div>

<div class="separator" style="height:8px;"></div>

<div id="img-area">
    <?php
    foreach ($model->ItemImgs as $itemImg) {
        echo "<div class='img-item'>";
        echo CHtml::image($itemImg['url']);
        echo "<div class='overlay'></div><div class='operater'><span class='prev'></span><b class='del'>X</b><span class='next'></span>";
        echo CHtml::hiddenField('ItemImg[item_img_id][]', $itemImg['item_img_id']);
        echo CHtml::hiddenField('ItemImg[url][]', $itemImg['url']);
        echo "</div></div>";
    }
    // echo CHtml::openTag('div');
    // echo '<hr>';
    // echo CHtml::button('Browse', array('class' => 'browse-image-btn btn'));
    // echo CHtml::closeTag('div');
    ?>
    <a id="browse-image-btn" class="img-plus img-item" href="javascript:;">&#43;</a>
</div>
<script type="text/javascript">
    var $imgList = $('#img-area'), $elpopups;
    // open elfinder popup
    $('#browse-image-btn').click(function () {
        var html;
        // if elfinder has not been initiated, create it
        if (!$elpopups) {
            html = '<iframe scrolling="no" src="<?php echo Yii::app()->createUrl('seller/elfinder/view') . '?browse=addImage'; ?>"></iframe>';
            $elpopups = $('#elfinder').append(html);
            $('.close').on('click',function () {
                $elpopups.hide();
            }).end();
        }
        $elpopups.show();
        // window.open('',
        // "_blank",
        // "toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=1552, height=822");
    });



    $imgList.on('click', '.del',function () {
        $(this).closest('.img-item').remove();
    }).on('click', '.prev',function () {
            exchangePos(this, 'prev');
        }).on('click', '.next',function () {
            exchangePos(this, 'next');
        }).on('mouseenter', '.img-item',function () {
            $(this).children(':gt(0)').show();
        }).on('mouseleave', '.img-item', function () {
            $(this).children(':gt(0)').hide();
        });

    function exchangePos(elem, ori) {
        var $item = $(elem).closest('.img-item'),
            $items = $imgList.children('.img-item'),
            index = $item.index();
        if ($items.length === 1) {
            return;
        }
        if (ori === 'prev') {
            if (index !== 0) {
                $item.children(':gt(0)').hide().end().prev().before($item);
            }
        } else if (ori === 'next') {
            if (index !== $items.length - 1) {
                $item.children(':gt(0)').hide().end().next().after($item);
            }
        }
    }

    var browse = {};
    browse.callFunction = function (funcNum, url) {
        if (funcNum == 'addImage') {
            var html = "<div class='img-item'><img src='" + url + "'><div class='overlay'></div><div class='operater'>" +
                "<span class='prev'></span><b class='del'>X</b><span class='next'></span>" +
                '<input name="ItemImg[item_img_id][]" id="ItemImg_item_img_id" type="hidden" value="0">' +
                '<input name="ItemImg[url][]" id="ItemImg_url" type="hidden" value="' + url + '">' +
                "</div></div>";
            $('#browse-image-btn').before(html);
        }
    }
</script>