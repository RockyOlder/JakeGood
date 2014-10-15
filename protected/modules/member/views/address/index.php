<style>
    .table-section table th {font-weight: 100;}
</style>
<?php $this->renderPartial("form", array('model' => $model)) ?>

<div class="clear" style="height:14px;"></div>

<div class="table-section">
    <?php if ($addresses) : ?>
        <table cellpadding="0" cellspacing="0" id="data_list" class="record_table table_1">
            <thead>
                <tr>
                    <th>联系人</th>
                    <th>所在地区</th>
                    <th>街道地址</th>
                    <th>邮政编码</th>
                    <th>手机/电话</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($addresses as $v) { ?>
                    <tr>
                        <td><?php echo $v['name'] ?></td>
                        <td><?php echo $v['area'] ?></td>
                        <td><?php echo $v['address'] ?></td>
                        <td><?php echo $v['zipcode'] ?></td>
                        <td><?php echo ! $v['mobile'] ? $v['phone'] : $v['mobile'] ?></td>
                        <td>
                            <?php
                            echo CHtml::link('编辑', $this->createUrl('', array('id' => $v['id'])));
                            echo ' ' . CHtml::link('删除'
                                    , $this->createUrl('delete', array('id' => $v['id']))
                                    , array('class' => 'btn_delete'));
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#data_list a.btn_delete').click(function() {
                    if (confirm('确定要删除这条数据吗?'))
                        return true;
                    return false;
                })
            });
        </script>
<?php endif; ?>
</div>