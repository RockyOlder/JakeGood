<script>
  function showImport()
  {
    $('#target_box').show();
  }
</script>
<div class="widget box">
    <div class="widget-title">
       <h4><i class="icon-edit"></i><?php echo $title; ?>Datalist</h4>
    </div>
    <div id="target_box" style="padding:5px;display:none;">
      <button class="btn" onclick="$(this).parent().hide()"><i class="icon-remove icon-white"></i> Close</button>
      <iframe name="target_frame" id="target_frame" style="border:1px solid #ccc;width:100%;"></iframe>
    </div>
    <form id="list_form" action="<?php echo $this->createUrl('spider/itemCats/Import'); ?>" method="post" target="target_frame">
    <div class="widget-body">
        <div class="clearfix margin-bottom-10">
           <div class="btn-group">
              <?php
                if (isset($_GET['parent_cid']))
                  echo CHtml::button(' ◄ 向上', array('onclick' => 'history.back()', 'class' => 'btn btn-success'));
              ?>
              <button type="submit" id="btn_improt" class="btn btn-inverse" onclick="showImport()">
              下载入库 <i class="icon-refresh icon-white"></i>
              </button>
           </div>
        </div>

        <table class="table table-striped table-bordered table-hover" id="data_list">
           <thead>
              <tr>
                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#data_list .checkboxes" /></th>
                <th>cid</th>
                <th>name</th>
                <th>sort_order</th>
              </tr>
           </thead>
           <tbody>
            <?php foreach ($item_cats as $v) { ?>
            <?php if ($v->status == 'normal') { ?>
              <tr class="odd gradeX">
                <td><input type="checkbox" class="checkboxes" name="cids[]" value="<?php echo $v->cid; ?>" /></td>
                <td><?php echo $v->cid; ?></td>
                <td>
                  <?php 
                    if ($v->is_parent)
                      echo CHtml::link($v->name.'+', $this->createUrl('spider/itemCats/index', array('parent_cid' => $v->cid)));
                    else
                      echo $v->name;
                  ?>
                </td>
                <td><?php echo $v->sort_order; ?></td>
              </tr>
              <?php     } ?>
              <?php } ?>
           </tbody>
        </table>

        <div class="clearfix"></div>
    </div>
    </form>
</div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/data-tables/DT_bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo Yii::app()->baseUrl ?>/assets/scripts/app.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/assets/scripts/table-managed.js"></script>     
<script>
  jQuery(document).ready(function() {  
     TableManaged.init();
  });
</script>
