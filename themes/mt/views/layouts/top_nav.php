<div class="site-mast__site-nav-w">
    <div class="site-mast__site-nav">
        <div class="site-mast__site-nav-inner">
            <div class="component-cate-nav" >
                <span class="mt-cates J-nav__trigger "><?php if ($this->getId() . '/' . $this->getAction()->getId() != 'site/index') echo '<i></i>'; ?>全部分类</span>
                <div class="cate-nav J-nav__list J-nav__list--present" <?php if ($this->getId() . '/' . $this->getAction()->getId() != 'site/index') echo 'style="display:none;"'; ?>>

                    <?php foreach (ItemCats::model()->findAll('parent_cid=0 AND status=1') as $cat): ?>
                    <?php   $url = ($cat->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $cat->cid)) : $cat->url); ?>
                    <div class="J-nav-item">
                        <div class="cate-nav__item J-cate-nav__item--122 cate-nav__item--122 cate-nav__item--has-l2">
                            <div class="nav-level1">
                                <dl>
                                    <dt><a class="nav-level1__label" href="<?php echo $url; ?>"><?php echo $cat->name; ?></a></dt>
                                    <?php foreach (ItemCats::model()->findAll('parent_cid='.$cat->cid) as $k => $subCat): ?>
									<?php if ($k > 2) break; ?>
                                    <?php   $url = ($subCat->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $subCat->cid)) : $subCat->url); ?>
                                    <dd class="nav-level1__item"><a href="<?php echo $url; ?>"><?php echo $subCat->name; ?></a></dd>
                                    <?php endforeach; ?>
                                </dl>
                                <i class="nav-level2-indication"></i>
                            </div>

                            <!--二级菜单-->
                            
                            <div class="nav-level2 J-nav-level2" style="visibility: visible; top: 0px; display:none;">
                                <?php foreach (ItemCats::model()->findAll('parent_cid='.$cat->cid) as $subCat): ?>
                                <?php   $url = ($subCat->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $subCat->cid)) : $subCat->url); ?>
                                <a class="nav-level2__item" href="<?php echo $url; ?>"><?php echo $subCat->name; ?></a>
                                <?php endforeach; ?>
                            </div>
                            
                            <!--二级菜单结束-->
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <nav>
                <ul class="navbar cf">
                    <li class="navbar__item-w"><a class="navbar__item" href="/"><span class="nav-label">首页</span></a></li>
                    <li class="navbar__item-w"><a class="navbar__item" href="/item/list?cid=50019780"><span class="nav-label">数码之家</span></a></li>
                    <li class="navbar__item-w"><a class="navbar__item" href="item/list?q=秋装"><span class="nav-label">秋装新品</span></a></li>
                </ul>
            </nav>
            <?php if ($this->getId() . '/' . $this->getAction()->getId() == 'site/index'): ?>
                <a target="_blank" href="#" class="nav-inner__side"></a>
            <?php endif; ?>
        </div>
    </div>
</div>