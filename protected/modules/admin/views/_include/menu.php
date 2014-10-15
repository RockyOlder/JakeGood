
<!-- BEGIN SIDEBAR -->
<div id="sidebar" class="nav-collapse collapse">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="sidebar-toggler hidden-phone"></div>
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
    <div class="navbar-inverse">
        <form class="navbar-search visible-phone">
            <input type="text" class="search-query" placeholder="Search" />
        </form>
    </div>
    <!-- END RESPONSIVE QUICK SEARCH FORM -->
    <!-- BEGIN SIDEBAR MENU -->         
    <ul>
        <li class="start  <?php echo get_class($this) == 'DefaultController' ? 'active' : ''; ?>">
            <a href="<?php echo $this->createUrl('./') ?>">
            <i class="icon-home"></i> 
            <span class="title">Dashboard</span>
            </a>
        </li>
        <li <?php echo get_class($this) == 'ItemCatsController' ? 'class="active"' : ''; ?>>
            <a href="<?php echo $this->createUrl('/admin/itemCats') ?>">
                <i class="icon-sitemap"></i> 
                <span class="title">类目管理</span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->