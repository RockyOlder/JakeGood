<style>
	.ilogin{z-index:999;width:280px;height:300px;position:background:rgba(255,255,255,.8);}
</style>

<div id="login" class="block_popup">
    <div class="content">
		<div class="ilogin">
			<?php $goto = urlencode(Yii::app()->createAbsoluteUrl('user/login'));?>
			<iframe src="<?php echo 'http://i.anarry.com/login/fast?goto='.$goto.(isset($_GET['logout']) ? '&logout=true' : ''); ?>" style="width:100%;height:100%;" scrolling="no"></iframe>
		</div>
    </div>
</div>
