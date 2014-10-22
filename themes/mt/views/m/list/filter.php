<style>
    #filter .filter-section-wrapper .filter-section ul {max-height: 85px;overflow: hidden;} 
</style>
<div class="filter-sortbar-outer-box filter-main--attrs">
    <?php if ($cat): ?>
    <div class="filter-breadcrumb">
        <span class="breadcrumb__item">
            <a class="filter-tag filter-tag--all" href="/">首页</a>
        </span>
        <span class="breadcrumb__crumb">
        </span>
        <span class="breadcrumb__item">
            <span class="breadcrumb__item__title filter-tag">
                <?php echo $cat->name; ?>
                <i class="tri">
                </i>
            </span>
            <div style="height:7px;">
                <span class="breadcrumb__item__option">
                    <i class="tri"></i>
                    <i class="tri tri--inner"></i>
                    <span class="option-list--wrap inline-block">
                        <span class="option-list--inner inline-block">
                            <?php foreach (ItemCats::model()->findAll('parent_cid=0') as $v): ?>
                            <a href="<?php echo $this->createUrl('item/list', array('cid' => $v->cid)); ?>"><?php echo $v->name; ?></a>
                            <?php endforeach; ?>
                        </span>
                    </span>
                </span>
            </div>
        </span>
    </div>
    <?php endif; ?>
    <div class="filter-section-wrapper">
        <?php foreach ($filters as $filter): ?>
        <div class="filter-label-list filter-section category-filter-wrapper first-filter">
            <div class="label has-icon">
                <?php echo $filter['name']; ?>：
            </div>
            <ul class="inline-block-list">
                <?php foreach ($filter['values'] as $v): ?>
                <li class="item <?php echo ($v['selected'] == true ? 'current' : ''); ?>">
                    <a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="filter-sortbar">
    <div class="button-strip inline-block">
        <a href="<?php echo $sort_url['default']; ?>" title="默认排序" class="button-strip-item inline-block button-strip-item-right <?php echo $sort == '' ? 'button-strip-item-checked' : ''?>">
            <span class="inline-block button-outer-box">
                <span class="inline-block button-content">
                    默认排序
                </span>
            </span>
        </a>
        <a href="<?php echo $sort_url['sale']; ?>" title="销量从高到低" class="button-strip-item inline-block button-strip-item-right button-strip-item-desc <?php echo $sort == 'sale-desc' ? 'button-strip-item-checked' : ''?>">
            <span class="inline-block button-outer-box">
                <span class="inline-block button-content">
                    销量
                </span>
                <span class="inline-block button-img">
                </span>
            </span>
        </a>
        <a href="<?php echo $sort_url['price']; ?>" title="价格从低到高" class="button-strip-item inline-block button-strip-item-right button-strip-item-asc <?php echo $sort == 'price-asc' ? 'button-strip-item-checked' : ''?>">
            <span class="inline-block button-outer-box">
                <span class="inline-block button-content">
                    价格
                </span>
                <span class="inline-block button-img">
                </span>
            </span>
        </a>
        <a href="<?php echo $sort_url['rating']; ?>" title="评分从高到低" class="button-strip-item inline-block button-strip-item-right button-strip-item-desc <?php echo $sort == 'rating-desc' ? 'button-strip-item-checked' : ''?>">
            <span class="inline-block button-outer-box">
                <span class="inline-block button-content">
                    好评
                </span>
                <span class="inline-block button-img">
                </span>
            </span>
        </a>
        <a href="<?php echo $sort_url['time']; ?>" title="发布时间从新到旧" class="button-strip-item inline-block button-strip-item-right button-strip-item-desc large-button <?php echo $sort == 'time-desc' ? 'button-strip-item-checked' : ''?>">
            <span class="inline-block button-outer-box">
                <span class="inline-block button-content">
                    发布时间
                </span>
                <span class="inline-block button-img">
                </span>
            </span>
        </a>
    </div>
</div>