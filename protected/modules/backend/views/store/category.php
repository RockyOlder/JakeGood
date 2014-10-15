<form enctype="multipart/form-data" method="post">
<?php echo CHtml::hiddenField('YII_CSRF_TOKEN', Yii::app()->getRequest()->getCsrfToken()); ?>
<style type="text/css">
	.categories {width: 100%; }
	.categories thead th {text-align:left;padding:8px 0; background: #eee;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc}
	.categories tbody td {padding:3px 0;border-bottom: 1px solid #ddd}
</style>
<h3 style="background:#eee;padding:5px;">分类管理</h3>
<div class="">
	<?php
		if ($model->hasErrors()) 
		{
		    echo CHtml::errorSummary($model);
		}
	?>
	<div class="">
		<div><button type="button" onclick="addCat()">+添加分类</button></div>
		<table class="categories">
			<thead>
				<tr>
					<th>分类名</th>
					<th>排序</th>
					<th>默认展开</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($categories as $i => $v) : ?>
				<tr>
					<td>
						<?php echo CHtml::hiddenField("cat[{$i}][id]", $v->id); ?>
						<?php echo CHtml::textField("cat[{$i}][name]", $v->name); ?>
					</td>
					<td>
						<?php echo CHtml::textField("cat[{$i}][sort_order]", $v->sort_order); ?>
					</td>
					<td>
						<?php echo CHtml::checkBox("cat[{$i}][is_show]", $v->is_show); ?>
					</td>
					<td>
						<a href="javascript:;" onclick="delCat($(this), <?php echo $i; ?>)">删除</a>
					</td>
				</tr>
				<?php
					$subModel = StoreCategory::model()->findAllByAttributes(array('store_id' => Yii::app()->user->getId(), 'parent_id' => $v->id));
					$countSub = count($subModel);
					echo "<script> var countSub_{$i}  = {$countSub}</script>";
					foreach ($subModel as $ii => $sub) :
				?>
				<tr class="sub_<?php echo $i?>">
					<td>
						<?php echo CHtml::hiddenField("cat[{$i}][sub][$ii][id]", $sub->id); ?>
						&nbsp;&nbsp;|_<?php echo CHtml::textField("cat[{$i}][sub][$ii][name]", $sub->name); ?>
					</td>
					<td>
						<?php echo CHtml::textField("cat[{$i}][sub][$ii][sort_order]", $sub->sort_order); ?>
					</td>
					<td>
						
					</td>
					<td>
						<a href="javascript:;" onclick="delCat($(this), -1)">删除</a>
					</td>
				</tr>
				<?php endforeach; ?>
				<tr class="add_sub sub_<?php echo $i?>" id="add_sub_<?php echo $i; ?>">
					<td colspan="4">
						&nbsp;&nbsp;|_<button type="button" onclick="addSubCat(<?php echo $i?>)">添加子分类</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						&nbsp;&nbsp;<button class="enter">保存</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="separator" style="height:14px;"></div>
</div>
</form>

<script type="text/javascript">
	var countCats = <?php echo count($categories) ?>

	var addSubCat = function (id)
	{
		var ii = eval("countSub_"+id+" += 1");
		
		var html = '<tr class="sub_'+id+'">'
				  +'<td>'
				  +'	&nbsp;&nbsp;|_<input type="text" name="cat['+id+'][sub]['+ii+'][name]" />'
				  +'</td>'
				  +'<td>'
				  +'	<input type="text" name="cat['+id+'][sub]['+ii+'][sort_order]" />'
				  +'</td>'
				  +'<td></td>'
				  +'<td><a href="javascript:;" onclick="delCat($(this), -1)">删除</a></td>'
				  +'</tr>';

		$('#add_sub_'+id).before(html);
	}
	var arrSub = new Array;
	var addCat = function ()
	{
		countCats += 1;
		arrSub['sub_'+countCats] = 0;

		var html = '<tr>'
				  +'<td>'
				  +'	<input type="text" name="cat['+countCats+'][name]" />'
				  +'</td>'
				  +'<td>'
				  +'	<input type="text" name="cat['+countCats+'][sort_order]" />'
				  +'</td>'
				  +'<td><input type="checkbox" name="cat['+countCats+'][is_show]" value=1 checked /></td>'
				  +'<td><a href="javascript:;" onclick="delCat($(this), -1)">删除</a></td>'
				  +'</tr>';

		$('.categories tbody').append(html);
	}
	var delCat = function (obj, id)
	{
		$(obj).parent().parent().remove();
		$('.sub_'+id).remove();
	}
</script>