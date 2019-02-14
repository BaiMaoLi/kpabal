<!DOCTYPE html>
<html lang="en">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>Admin Panel - <?=SITE_TITLE?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
        WebFont.load({
        google: {
        "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
        },
        active: function() {
        sessionStorage.fonts = true;
        }
        });
        </script>
        <!--end::Web font -->
        <!--begin::Page Vendors Styles -->
        <?php
        if(isset($additional_css)):
        foreach($additional_css as $css) {
        ?>
        <link href="<?=ADMIN_ASSETS_DIR?><?=$css?>" rel="stylesheet" type="text/css" />
        <?php } endif ?>
        <!--end::Page Vendors Styles -->
        <!--begin::Base Styles -->
        <link href="<?=ADMIN_ASSETS_DIR?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?=ADMIN_ASSETS_DIR?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="<?=ADMIN_ASSETS_DIR?>assets/demo/default/media/img/logo/favicon.ico" />
    </head>
    <!-- end::Head -->
    <!-- begin::Body -->
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
                <div class="m-container m-container--fluid m-container--full-height">
                    <div class="m-stack m-stack--ver m-stack--desktop">
                        <!-- BEGIN: Brand -->
                        <div class="m-stack__item m-brand  m-brand--skin-dark ">
                            <div class="m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                    <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>" class="m-brand__logo-wrapper">
                                        <img alt="" src="<?=ADMIN_ASSETS_DIR?>assets/demo/default/media/img/logo/logo_default_dark.png" />
                                    </a>
                                </div>
                                <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                    <!-- BEGIN: Left Aside Minimize Toggle -->
                                    <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                                        <span></span>
                                    </a>
                                    <!-- END -->
                                    <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                    <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>
                                    <!-- END -->
                                    <!-- BEGIN: Responsive Header Menu Toggler -->
                                    <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>
                                    <!-- END -->
                                    <!-- BEGIN: Topbar Toggler -->
                                    <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                        <i class="flaticon-more"></i>
                                    </a>
                                    <!-- BEGIN: Topbar Toggler -->
                                </div>
                            </div>
                        </div>
                        <!-- END: Brand -->
                        <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                            <!-- BEGIN: Horizontal Menu -->
                            <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                            <i class="la la-close"></i>
                            </button>
                            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-add"></i>
                                            <span class="m-menu__link-text">Actions</span>
                                            <i class="m-menu__hor-arrow la la-angle-down"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                            <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a href="#" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-file"></i>
                                                        <span class="m-menu__link-text">Preserve Action 1</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="#" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-diagram"></i>
                                                        <span class="m-menu__link-title">
                                                            <span class="m-menu__link-wrap">
                                                                <span class="m-menu__link-text">Preserve Action 2</span>
                                                                <span class="m-menu__link-badge">
                                                                    <span class="m-badge m-badge--success">2</span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                                        <i class="m-menu__link-icon flaticon-business"></i>
                                                        <span class="m-menu__link-text">Preserve Action 3</span>
                                                        <i class="m-menu__hor-arrow la la-angle-right"></i>
                                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                                    </a>
                                                    <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                                        <span class="m-menu__arrow "></span>
                                                        <ul class="m-menu__subnav">
                                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                                <a href="header/actions.html" class="m-menu__link ">
                                                                    <span class="m-menu__link-text">Preserve Action</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- END: Horizontal Menu -->
                            <!-- BEGIN: Topbar -->
                            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                                <div class="m-stack__item m-topbar__nav-wrapper">
                                    <ul class="m-topbar__nav m-nav m-nav--inline">
                                        <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="m_quicksearch" m-quicksearch-mode="dropdown"
                                            m-dropdown-persistent="1">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-nav__link-icon">
                                                    <i class="flaticon-search-1"></i>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
                                                <div class="m-dropdown__inner ">
                                                    <div class="m-dropdown__header">
                                                        <form class="m-list-search__form">
                                                            <div class="m-list-search__form-wrapper">
                                                                <span class="m-list-search__form-input-wrapper">
                                                                    <input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="Search...">
                                                                </span>
                                                                <span class="m-list-search__form-icon-close" id="m_quicksearch_close">
                                                                    <i class="la la-remove"></i>
                                                                </span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
                                                            <div class="m-dropdown__content">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                                            <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                                <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                                                <span class="m-nav__link-icon">
                                                    <i class="flaticon-music-2"></i>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center" style="background: url(<?=ADMIN_ASSETS_DIR?>assets/app/media/img/misc/notification_bg.jpg); background-size: cover;">
                                                        <span class="m-dropdown__header-title">New</span>
                                                        <span class="m-dropdown__header-subtitle">User Notifications</span>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                                                <li class="nav-item m-tabs__item">
                                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                                                        Alerts
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item m-tabs__item">
                                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">Events</a>
                                                                </li>
                                                                <li class="nav-item m-tabs__item">
                                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">Logs</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                                                    <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                                                        <div class="m-list-timeline m-list-timeline--skin-light">
                                                                            <div class="m-list-timeline__items">
                                                                                <div class="m-list-timeline__item">
                                                                                    <span class="m-list-timeline__badge"></span>
                                                                                    <span class="m-list-timeline__text">Notification Contents</span>
                                                                                    <span class="m-list-timeline__time">2 hrs</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                                                                    <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                                                        <div class="m-list-timeline m-list-timeline--skin-light">
                                                                            <div class="m-list-timeline__items">
                                                                                <div class="m-list-timeline__item">
                                                                                    <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                                                    <a href="" class="m-list-timeline__text">New order received</a>
                                                                                    <span class="m-list-timeline__time">Just now</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                                                    <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                            <span class="">All caught up!
                                                                            <br>No new logs.</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-topbar__userpic">
                                                    <img src="<?php if(file_exists(PROJECT_AVATAR_DIR."/user_".$memberIdx.".jpg")) echo ROOTPATH.PROJECT_AVATAR_DIR."/user_".$memberIdx.".jpg"; else echo ROOTPATH.PROJECT_AVATAR_DIR."/default.jpg";?>" class="m--img-rounded m--marginless" alt="" />
                                                </span>
                                                <span class="m-topbar__username m--hide"><?=$last_name?> <?=$first_name?></span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center" style="background: url(<?=ADMIN_ASSETS_DIR?>assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                                        <div class="m-card-user m-card-user--skin-dark">
                                                            <div class="m-card-user__pic">
                                                                <img src="<?php if(file_exists(PROJECT_AVATAR_DIR."/user_".$memberIdx.".jpg")) echo ROOTPATH.PROJECT_AVATAR_DIR."/user_".$memberIdx.".jpg"; else echo ROOTPATH.PROJECT_AVATAR_DIR."/default.jpg";?>" class="m--img-rounded m--marginless" alt="" />
                                                            </div>
                                                            <div class="m-card-user__details">
                                                                <span class="m-card-user__name m--font-weight-500"><?=$last_name?> <?=$first_name?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav m-nav--skin-light">
                                                                <li class="m-nav__section m--hide">
                                                                    <span class="m-nav__section-text">Section</span>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/members/edit/<?=$memberIdx?>" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                        <span class="m-nav__link-title">
                                                                            <span class="m-nav__link-wrap">
                                                                                <span class="m-nav__link-text">My Profile</span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit">
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/logout" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END: Topbar -->
                        </div>
                    </div>
                </div>
            </header>
            <!-- END: Header -->
            <?php
            $open = $this->category_model->get_parent_menu($menuURL);
            ?>
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
                <i class="la la-close"></i>
                </button>
                <div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                            <?php foreach($categories as $key => $main_category) { ?>
                            <li class="m-menu__item<?php if($open == $main_category->menuName):?><?php if(count($main_category->children)):?> m-menu__item--open<?php else:?> m-menu__item--active<?php endif?><?php endif?><?php if(count($main_category->children)):?>  m-menu__item--submenu<?php endif?>" aria-haspopup="true">
                                <a href="<?php if($main_category->menuURL) echo ROOTPATH.ADMIN_PUBLIC_DIR.$main_category->menuURL; else echo 'javascript:;';?>" class="m-menu__link<?php if(count($main_category->children)):?>  m-menu__toggle<?php endif?>">
                                    <i class="m-menu__link-icon <?=$main_category->menuIcon?>"></i>
                                    <?php if(count($main_category->children) == 0):?><span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap"><?php endif ?>
                                            <span class="m-menu__link-text"><?=$main_category->menuName?></span>
                                        <?php if(count($main_category->children) == 0):?></span>
                                    </span><?php else: ?>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i><?php endif ?>
                                </a>
                                <?php if(count($main_category->children)):?>
                                <div class="m-menu__submenu ">
                                    <span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                            <span class="m-menu__link">
                                                <span class="m-menu__link-text"><?=$main_category->menuName?></span>
                                            </span>
                                        </li>
                                        <?php foreach($main_category->children as $category){?>
                                        <li class="m-menu__item<?php if($category->menuURL == $menuURL):?> m-menu__item--active<?php endif?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?><?=$category->menuURL?>" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text"><?=$category->menuName?></span>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php endif ?>
                            </li>
                            <?php } ?>
                            <?php
                                $is_open = '';
                                if(in_array($menuURL, array('/ads', '/pages_manage', '/email_templates', '/all_messages', '/profiles_lists', '/profile_detail', '/all_user_freinds', '/search_profile_name', '/search_profile_email', '/search_profile_location')))
                                {
                                    $is_open = 'm-menu__item--open';
                                }
                            ?>
                            <li class="m-menu__item m-menu__item--submenu <?php echo $is_open;?>" area-haspopup="true">
                                <a class="m-menu__link m-menu__toggle" href="javascript:void(0)">
                                    <i class="m-menu__link-icon flaticon-business"></i>
                                    <span class="m-menu__link-text">Dating Panel</span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="m-menu__submenu ">
                                    <span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <!-- <li class="m-menu__item" aria-haspopup="true">
                                            <a href="" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Dashboard</span>
                                            </a>
                                        </li> -->
                                        <li class="m-menu__item <?php echo ($menuURL == '/profiles_lists' || $menuURL == '/profile_detail' || $menuURL == '/all_user_freinds')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/profiles_lists" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Manage User Profiles</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/search_profile_name')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/search_profile_name" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Search Profile By Name</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/search_profile_email')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/search_profile_email" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Search Profile By Email</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/search_profile_location')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/search_profile_location" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Search Profile By Location</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/all_messages')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/all_messages" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Manage User's Messages</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/email_templates')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/email_templates" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Manage Email Templates</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/pages_manage')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/pages_manage" class="m-menu__link">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Manage CMS</span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item <?php echo ($menuURL == '/ads')? 'm-menu__item--active': '';?>" aria-haspopup="true">
                                            <a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/ads" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                                </i>
                                                <span class="m-menu__link-text">Manage Ads</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- END: Aside Menu -->
                </div>
                <!-- END: Left Aside -->