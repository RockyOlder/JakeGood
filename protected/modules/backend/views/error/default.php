<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			错误提示
		</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Loading bootstrap css-->
                <link type="text/css" href="/assets/skin/fourteen/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.css">
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/font-awesome/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/bootstrap/css/bootstrap.min.css">
		<!--Loading style vendors-->
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/animate.css/animate.css">
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/iCheck/skins/all.css">
		<!--Loading style-->
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/css/themes/style1/pink-violet.css"
		id="theme-change" class="style-change color-change">
		<link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/css/style-responsive.css">
		<link rel="shortcut icon" href="/assets/skin/fourteen/images/favicon.ico">
	</head>
	<body id="error-page" class="animated bounceInLeft">
		<div id="error-page-content">
			<h1>Fail</h1>
			<h4><?php echo $message; ?></h4>
			<p>                      
                            <?php echo CHtml::link('登出', '/seller/login/logout'); ?>
			</p>
		</div>
		<script src="/assets/skin/fourteen/js/jquery-1.9.1.js"></script>
		<script src="/assets/skin/fourteen/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="/assets/skin/fourteen/js/jquery-ui.js"></script>
		<!--loading bootstrap js-->
		<script src="/assets/skin/fourteen/vendors/bootstrap/js/bootstrap.min.js"></script>
		<script src="/assets/skin/fourteen/vendors/bootstrap-hover-dropdown.js"></script>
		<script src="/assets/skin/fourteen/js/html5shiv.js"></script>
		<script src="/assets/skin/fourteen/js/respond.min.js"></script>
		<script src="/assets/skin/fourteen/vendors/iCheck/icheck.min.js"></script>
		<script src="/assets/skin/fourteen/vendors/iCheck/custom.min.js"></script>
		<script>
			//BEGIN CHECKBOX & RADIO
			$('input[type="checkbox"]').iCheck({
				checkboxClass: 'icheckbox_minimal-grey',
				increaseArea: '20%' // optional
			});
			$('input[type="radio"]').iCheck({
				radioClass: 'iradio_minimal-grey',
				increaseArea: '20%' // optional
			});
			//END CHECKBOX & RADIO
			</script>
	</body>

</html>
<!-- Localized -->