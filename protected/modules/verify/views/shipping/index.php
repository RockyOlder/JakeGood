
<h3>寄件人地址</h3>
<ul>
<?php foreach ($addresses as $v) { ?>
<li><input type="radio"> <?php echo $v['name'] ?> <?php echo $v['mobile'] ?> <?php echo $v['area'] ?> <?php echo $v['address'] ?>
<?php } ?>
</ul>


<?php $this->renderPartial("form", array('model' => new AddressBook)) ?>
