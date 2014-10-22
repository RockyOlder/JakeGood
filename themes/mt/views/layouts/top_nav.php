<div class="site-mast__site-nav-w">
    <div class="site-mast__site-nav">
        <div class="site-mast__site-nav-inner">
            <div class="component-cate-nav" >
                <span class="mt-cates J-nav__trigger "><?php if ($this->getId() . '/' . $this->getAction()->getId() != 'site/index') echo '<i></i>'; ?>全部分类</span>
                <div class="cate-nav J-nav__list J-nav__list--present" <?php if ($this->getId() . '/' . $this->getAction()->getId() != 'site/index') echo 'style="display:none;"'; ?>>

                    <?php foreach (ANLMarket::getCats($this->market->market_id, 0, 2) as $cat): ?>
                    <?php   $url = ($cat->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $cat->cid)) : $cat->url); ?>
                    <div class="J-nav-item">
                        <div class="cate-nav__item J-cate-nav__item--122 cate-nav__item--122 cate-nav__item--has-l2">
                            <div class="nav-level1">
                                <dl>
                                    <dt><a class="nav-level1__label" href="<?php echo $url; ?>"><?php echo $cat->name; ?></a></dt>
                                    <?php foreach ($cat->recommends as $k => $sub): ?>
                                    <?php   $url = ($sub->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $sub->cid)) : $sub->url); ?>
                                    <dd class="nav-level1__item"><a href="<?php echo $url; ?>" class=" <?php echo $sub->css; ?>"><?php echo $sub->name; ?></a></dd>
                                    <?php endforeach; ?>
                                </dl>
                                <i class="nav-level2-indication"></i>
                            </div>

                            <!--二级菜单-->
                            <?php if ($cat->subs): ?>
                            <div class="nav-level2 J-nav-level2" style="visibility: visible; top: 0px; display:none;">
                                <?php foreach ($cat->subs as $sub): ?>
                                <?php   $url = ($sub->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $sub->cid)) : $sub->url); ?>
                                <a class="nav-level2__item <?php echo $sub->css; ?>" href="<?php echo $url; ?>"><?php echo $sub->name; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <!--二级菜单结束-->
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <nav>
                <ul class="navbar cf">
                    <li class="navbar__item-w"><a class="navbar__item" href="/"><span class="nav-label">首页</span></a></li>
                    <li class="navbar__item-w"><a class="navbar__item" href="/item/list?cid=4"><span class="nav-label">休闲娱乐</span></a></li>
                    <li class="navbar__item-w"><a class="navbar__item" href="/item/list?cid=153"><span class="nav-label">火锅</span></a></li>
                    <li class="navbar__item-w"><a class="navbar__item" href="http://jf.anarry.com"><span class="nav-label">积分商城</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>