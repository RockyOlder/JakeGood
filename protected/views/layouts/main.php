<!DOCTYPE html>
<html>

<head>
<?php
    //-------------------jquery插件--------------------------- 
    Yii::app()->getClientScript()->registerCoreScript('jquery');
    Yii::app()->getClientScript()->registerScriptFile('/assets/plugins/jquery-validation/jquery.validate.min.js');
?>
<title><?php echo CHtml::encode($pageTitle); ?></title>

<meta name="keywords" content="" />
<meta name="description" content="" />

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo $this->skinUrl; ?>/layout/plugins/html5.js"></script>
<![endif]-->

<link rel="stylesheet" href="<?php echo $this->skinUrl; ?>/layout/style.css" type="text/css" />

<script type="text/javascript" src="<?php echo $this->baseUrl; ?>/assets/plugins/jquery.migrate.js"></script>


<!-- PrettyPhoto start -->
<link rel="stylesheet" href="<?php echo $this->skinUrl; ?>/layout/plugins/prettyphoto/css/prettyPhoto.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->skinUrl; ?>/layout/plugins/prettyphoto/jquery.prettyPhoto.js"></script>
<!-- PrettyPhoto end -->


<!-- Calendar start -->
<link rel="stylesheet" href="<?php echo $this->skinUrl; ?>/layout/plugins/calendar/calendar.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->skinUrl; ?>/layout/plugins/calendar/calendar.js"></script>
<!-- Calendar end -->

<!-- ScrollTo start -->
<script type="text/javascript" src="<?php echo $this->skinUrl; ?>/layout/plugins/scrollto/jquery.scroll.to.min.js"></script>
<!-- ScrollTo end -->

<!-- jQuery Form Plugin start -->
<script type="text/javascript" src="<?php echo $this->skinUrl; ?>/layout/plugins/ajaxform/jquery.form.js"></script>
<!-- jQuery Form Plugin end -->

<script type="text/javascript" src="<?php echo $this->skinUrl; ?>/layout/js/main.js"></script>

<script type="text/javascript">
    jQuery(function () {
    });
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
    <div class="wrapper sticky_footer">
        <!-- HEADER BEGIN -->
        <header>
            <div id="header">
                <section class="top">
                    <div class="inner">
                        <div class="fl">
                            <div class="block_top_menu">
                                <ul>
                                    <li class="current"><a href="index.html">Home</a></li>
                                    <li><a href="#">直控商城</a></li>
                                    <li><a href="#">联盟电商</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="fr">
                            <div class="block_top_menu">
                                <ul>
                                    <?php if (isset($this->User)) : ?>
                                    <li class="current"><a>你好, <?php echo $this->User['username']; ?></a></li>
                                    <li class=""><a href="<?php echo $this->createUrl('//member/logout'); ?>">退出</a></li>
                                    <?php endif; ?>
                                    <li><a href="#">帮助中心</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="clearboth"></div>
                    </div>
                </section>
                
                <section class="bottom">
                    <div class="inner">
                        <div id="logo_top"><a href="/web"><img src="<?php echo $this->skinUrl; ?>/images/logo_top.png" alt="BusinessNews" title="BusinessNews" /></a></div>
                        
                        <div class="clearboth"></div>
                    </div>
                </section>
                
                <section class="section_secondary_menu">
            <div class="inner">
                <nav class="secondary_menu">
                    <section class="section_secondary_menu">
                      <div class="inner">
                          <nav class="secondary_menu">
                              <ul>
                                  <li><a href="/">首页</a></li>
                                  <li><a href="/seller">卖家中心</a></li>
                              </ul>
                          </nav>
                      </div>
                  </section>
                </nav>
            </div>
        </section>
            </div>
        </header>
        <!-- HEADER END -->
        
        <!-- CONTENT BEGIN -->
        <div id="content" class="left_sidebar">
            <div class="inner">
                <div class="general_content">
                  <?php echo $content; ?>
                  <div class="separator" style="height:5px;"></div>
                </div>
                <div class="separator" style="height:1px;"></div>
            </div>
        </div>
        <!-- CONTENT END -->
        
        <!-- FOOTER BEGIN -->
        <footer>
            <div id="footer">
                <section class="top">
                    <div class="inner">
                        <div id="logo_bottom"><a href="index.html"><img src="<?php echo $this->skinUrl; ?>/images/logo_bottom.png" alt="" /></a></div>
                        
                        <div class="block_to_top">
                            <a href="#">BACK TO TOP</a>
                        </div>
                    </div>
                </section>
            </div>
        </footer>
        <!-- FOOTER END -->
    </div>
</body>

</html>