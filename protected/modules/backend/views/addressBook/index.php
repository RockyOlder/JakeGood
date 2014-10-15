
<?php $this->renderPartial("form", array('model' => $model)) ?>

<div class="col-md-10">
    <?php if ($addresses) : ?>
        <table cellpadding="0" cellspacing="0" id="data_list" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>联系人</th>
                    <th>所在地区</th>
                    <th>街道地址</th>
                    <th>邮政编码</th>
                    <th>电话号码</th>
                    <th>手机号码</th>
                    <th>公司名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($addresses as $v) : ?>
                    <tr>
                        <td><?php echo $v['name'] ?></td>
                        <td><?php echo $v['area'] ?></td>
                        <td><?php echo $v['address'] ?></td>
                        <td><?php echo $v['zipcode'] ?></td>
                        <td><?php echo $v['phone'] ?></td>
                        <td><?php echo $v['mobile'] ?></td>
                        <td><?php echo $v['company'] ?></td>
                        <td>
                            <?php
                            echo CHtml::link('编辑', $this->createUrl('index', array('id' => $v['id'])));
                            echo ' ' . CHtml::link('删除'
                                    , $this->createUrl('delete', array('id' => $v['id']))
                                    , array('class' => 'delete btn_delete'));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#data_list a.delete').click(function() {
                    if (confirm('确定要删除这条数据吗?'))
                        return true;
                    return false;
                })
            });
        </script>
    <?php endif; ?>
</div>