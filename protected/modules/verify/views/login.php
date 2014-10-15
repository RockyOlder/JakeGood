
<?php 
    if (isset($errors)) echo '<em for="username" class="col-lg-12  text-red">'.$errors.'</em>';
?>
<div style="min-height:200px;margin-top:20px;">
        <form method="POST" class="form-horizontal form-validate">
            <div class="form-group"><div class="input-icon right"><i class="fa fa-user"></i><input type="text" placeholder="username" name="username" class="form-control required"></div></div>
            <div class="form-group"><div class="input-icon right"><i class="fa fa-key"></i><input type="password" placeholder="password" name="password" class="form-control required"></div></div>
            <div class="form-group pull-right"><button type="submit" class="btn btn-success">登 入&nbsp;<i class="fa fa-chevron-circle-right"></i></button></div>
        </form>
</div>