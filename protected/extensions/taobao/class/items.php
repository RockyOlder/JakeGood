<style>

	a:link {
	 font-size: 9pt; COLOR: #333333; TEXT-DECORATION: none;
	}
	a:hover {
	 font-size: 9pt; COLOR: #FF5400; TEXT-DECORATION:underline;
	}
	.items_table {
		border-top:1px solid #ccc;
	}
	.items_table td {
		border-bottom:1px solid #ccc;
		padding:10px;
	}
	
	/**
	 *---------------分页样式-----------------
	 */

	.pages {
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		float:right;
	}
	.pages li {
		display:inline;
		float: left;
		padding:0px 5px;
		height:21px;
		color:#666;
		line-height:21px;
		border: 1px solid #E0E0E0;
		background:#FFF;
	}
	.pages li span {
		color:#0044DD;
		background:#FFF;
	}
	.pages li.page_a {
		padding:0;
		border:0;
	}
	.pages li.page_a a {
		FLOAT: left;
		display: block;
		padding:0px 5px;
		color:#0044DD;
		border: 1px solid #E0E0E0;
	}
	.pages li.page_a a:hover {
		display: block;
		color:red;
		border: 1px solid #A0A0A0;
	}
	.pages li.pages_input {
		padding:0;
		border: 1px solid #A0A0A0;
	}
	.pages li.pages_input input {
		width:18px;
		font-size:14px;
		border:0px;
		padding:0px 3px;
		margin:0px 3px;
		text-align:center;
	}
	.pages .on {
		padding:0px 5px;
		color: red;
		font-weight:bold;
	}
	.pages .page_clear {
		clear:both;
	}
	/**
	 *------------------分页样式---------------------
	 */	
</style>
<script>
	function item_checked(checked)
	{
		$('#items_table input[type=checkbox]').attr('checked', checked);
	}
	
	function down_checked()
	{
		$('#items_table input[type=checkbox]').each(function (){
			if ($(this).attr('checked') == 'checked') alert($(this).val());
		});
	}
</script>
<table id="items_table" border="0" width="100%" class="items_table" cellpadding="0" cellspacing="0">
	<thead>
		<td colspan="5">
			<input type="checkbox" onclick="item_checked(this.checked)"/> 全选
			&nbsp;&nbsp;
			<input type="button" value="下载选中" onclick="down_checked()" />
		</td>
	</thead>
	<?php
	if (!empty($TaobaoItems))
	{
		foreach ($TaobaoItems as $key => $val)
		{ 
	?>
	<tr>
		<td><input type="checkbox" name="items[]" value="<?=$val['num_iid'];?>" /></td>
		<td>
			<a href="http://item.taobao.com/item.htm?id=<?=$val['num_iid'];?>" target="_blank"><img src="<?=$val['img'];?>" border=0 width=80></a>
		</td>
		<td valign="top">
			<div style="height:50px;padding:5px;">
				<input type="text" name="title[<?=$val['num_iid'];?>]" size="70" value="<?=htmlspecialchars(iconv('gbk', 'utf-8', $val['title'])); ?>"/>
			</div>
		</td>
		<td>
			<span>￥</span>
			<input type="text" name="price[<?=$val['num_iid'];?>]" value="<?=$val['price'];?>" style="font-size:14px;font-weight:bold;color:#ff2900" />
		</td>
 		<td id="download_<?=$val['num_iid'] ?>">
           <?php if($this->checkItemIsDownload($val['num_iid'])): ?>
		   已经下载
		   <?php else: ?>
		   <iframe id="download_frame_<?=$val['num_iid'] ?>" src='' style="display:none;"></iframe>
           <input type="button" value="下载" id="download_button_<?=$val['num_iid'] ?>" onclick="document.getElementById('download_frame_<?=$val['num_iid'] ?>').src= '/taoapi/search_product/item.php?num_iid=<?=$val['num_iid'] ?>&category_id=<?=$category_id ?>'; this.disabled=true; this.value='下载中...'" />
		   <?php endif; ?>
		</td>  
	</tr>
	<?php
		}
	?>
	 <tr>
      <td colspan="7">
		<?php
			// 分页 new PageClass(数据总数,每页数量,页码,URL组成);
			//http://ocart3.com/admin/index.php?route=taoapi/download&token=967ac4b9429cdc31acffeee7d7b2979e
			$url = 'domain='.$domain.'&nickname='.urlencode($nickname).'&orderType='.$orderType.'&category_id='.$category_id;
			$link = $this->url->link('taoapi/download', $url.'&page={page}'.'&token=' . $this->session->data['token'], 'SSL');			
			$pages = new PageClass($Total_results, $page_size, $page, $link);
			echo $pages -> myde_write();
		?>
      </td>
    </tr>
	<?php
	}
	else
	{
		echo '<tr><td colspan=15 class="sub_msg">搜索不到商品，请重试！</td></tr>';
	}
	?>
   
</table>