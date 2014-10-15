<!DOCTYPE html>
<!--  
Template Name: Conquer Responsive Admin Dashboard Template build with Twitter Bootstrap 2.3.1
Version: 1.4
Author: KeenThemes
Website: http://www.keenthemes.com
Purchase: http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838
-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>   
    <title><?php echo $this->pageTitle ?> | 阿那里</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
   <link href="#" rel="stylesheet" id="style_metro" />
   <!-- END GLOBAL MANDATORY STYLES -->
   <!-- BEGIN PAGE LEVEL STYLES -->
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/select2/select2.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery-tags-input/jquery.tagsinput.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/assets/plugins/data-tables/DT_bootstrap.css" />

   <!-- END PAGE LEVEL STYLES --> 

   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   <!-- BEGIN CORE PLUGINS -->
   <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->  
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <!--[if lt IE 9]>
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/excanvas.js"></script>
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/respond.js"></script>  
   <![endif]-->   
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/breakpoints/breakpoints.js" type="text/javascript"></script>  
   <!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js --> 
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery.blockui.js" type="text/javascript"></script>  
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery.cookie.js" type="text/javascript"></script>
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script> 
   <!-- END CORE PLUGINS -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/ckeditor/ckeditor.js"></script>  
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/select2/select2.min.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>   
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/scripts/app.js"></script>
   <script src="<?php echo Yii::app()->baseUrl ?>/assets/scripts/form-components.js"></script>     
   <!-- END PAGE LEVEL SCRIPTS -->

   <script src="<?php echo Yii::app()->baseUrl ?>/assets/admin/js/custom.js"></script>  
   <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
         FormComponents.init();
      });
   </script> 
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    <div id="header" class="navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="navbar-inner">
            <div class="container-fluid">
                <!-- BEGIN LOGO -->
                <a class="brand" href="<?php echo $this->createUrl('/'.$this->module->id); ?>">
                <img src="<?php echo Yii::app()->baseUrl ?>/assets/img/logo.png" alt="Conquer" />
                </a>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="arrow"></span>
                </a>          
                <!-- END RESPONSIVE MENU TOGGLER -->                
                <div class="top-nav">
                    <!-- BEGIN TOP NAVIGATION MENU -->                  
                    <ul class="nav pull-right" id="top_menu">
                        <!-- END INBOX DROPDOWN -->
                        <li class="divider-vertical hidden-phone hidden-tablet"></li>
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-wrench"></i>
                            <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="icon-cogs"></i> System Settings</a></li>
                                <li><a href="#"><i class="icon-pushpin"></i> Shortcuts</a></li>
                                <li><a href="#"><i class="icon-trash"></i> Trash</a></li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <li class="divider-vertical hidden-phone hidden-tablet"></li>
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i>
                            <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="icon-user"></i> Admin</a></li>
                                <li><a href="/admin/logout"><i class="icon-key"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                    <!-- END TOP NAVIGATION MENU -->    
                </div>
            </div>
        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div id="container" class="row-fluid">
        <?php $this->renderPartial('/_include/menu');?>
        <!-- BEGIN PAGE -->
        <div id="body">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div id="widget-config" class="modal hide">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>Widget Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here will be a configuration form</p>
                </div>
            </div>
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">    
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="<?php echo $this->createUrl('/'.$this->module->id); ?>">Home</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a href="#"><?php echo  $this->data['title']; ?></a></li>
                        </ul>
                        <!-- 
                        <h3 class="page-title">
                            <?php echo  $this->data['title']; ?> <small>statistics and more</small>
                        </h3>
                        END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <?php echo $content; ?>
            </div>
            <!-- END PAGE CONTAINER-->      
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div id="footer">
      2013 &copy; Conquer. Admin Dashboard Template.
      <div class="span pull-right">
         <a href="#"><span class="go-top"><i class="icon-arrow-up"></i></span></a>
      </div>
    </div>
    <!-- END FOOTER -->
    
</body>
<!-- END BODY -->
</html>