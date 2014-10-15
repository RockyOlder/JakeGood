<style> .table th {text-align:right;}</style>
<form action="<?=$link = $this->url->link('taoapi/download', 'token=' . $this->session->data['token'], 'SSL'); ?>" method="POST" name="form1" id="form1">
<table width="100%" class="table">
    <tr>
      <th width="100">店铺地址：</th>
      <td width="250">
		<input type="text" name="domain" id="domain" value="<?=$domain ?>" size="40">
	  </td>
      <th width="100">店铺名：</th>
      <td>
		<input type="text" name="nickname" id="nickname" value="<?=$nickname ?>" size="40">
		<input type="submit" value="搜索" style="padding:2px 10px 1px 10px;font-size:12px;">
	  </td>
    </tr>
	
	<tr>
      <th>排序方式：</th>
      <td>
      <select id="orderType" name="orderType" style="width:220px; ">
      <option value="">默认排序</option>
      <option value="newOn_desc">新品</option>
      <option value="hotsell_desc">销量</option>
      </select>
      </td>
	  <th><b style="color:red;">本站分类：*</b></th>
	  <td>
		<select id="category_id" name="category_id">
            <option value="0" selected>请选择本站商品分类...</option>
			<?php foreach ($categories as $category): ?>
			<option value="<?=$category['category_id'] ?>"><?=$category['name'] ?></option>
			<?php endforeach; ?>
		</select>
	  </td>
    </tr>
	<script>
		document.getElementById('category_id').value = '<?=$category_id ?>';
		document.getElementById('orderType').value = '<?=$orderType ?>';
	</script>
</table>
</form>
