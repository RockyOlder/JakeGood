
<div class="widget box">
    <div class="widget-title">
       <h4><i class="icon-edit"></i><?php echo $title; ?></h4>

        <div class="actions">
           <a href="<?php echo $this->createUrl('add', $_GET) ?>" class="btn green"><i class="icon-plus"></i> 新增</a>
           <a href="<?php echo $this->createUrl('list', $_GET) ?>" class="btn yellow"><i class="icon-list"></i> 列表</a>
        </div>
    </div>
    <div class="widget-body">
        <!-- BEGIN FORM-->
           <form action="<?php echo $this->createUrl('save') ?>" class="form-horizontal" method="POST">
              <?php foreach($columns as $k => $v) { ?>
              <div class="control-group">
                 <label class="control-label"><?php echo $v['name'] ?>:</label>
                 <div class="controls">
                    <?php echo $v['field'] ?>
                    <span class="help-inline"><?php echo $v['desc'] ?></span>
                 </div>
              </div>
              <?php }; ?>
              <div class="form-actions">
                 <button type="submit" class="btn btn-primary">Submit</button>
                 <button type="button" class="btn" onclick="window.location='<?php echo $this->createUrl('list', $_GET); ?>'">Cancel</button>
              </div>
           </form>
           <!-- END FORM-->
        <div class="clearfix"></div>
    </div>
</div>
