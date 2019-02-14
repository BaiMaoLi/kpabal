<style type="text/css">
    .board-list {
        font-size: 13px;
        line-height: 1.6em;
    }
    .mb-board select {
        width: auto !important;
        min-width: 64px;
        padding: 0px 4px 2px !important;
        *padding: 3px 0px !important;
        display: inline-block !important;
        font-size: 13px;
        line-height: 18px;
        vertical-align: middle;
        height: 30px !important;
        *height: 30px !important;
        border: 1px solid #ccc;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;
        background-color: #FFF;
        background-image: none !important;
        appearance: menulist;
        -moz-appearance: menulist;
        -webkit-appearance: menulist;
        color: #6A6A6A !important;
    }

    .mb-board input[type="text"], .mb-board input[type="password"], .mb-board input[type="datetime"], .mb-board input[type="datetime-local"], .mb-board input[type="date"], .mb-board input[type="month"], .mb-board input[type="color"], .mb-board input[type="time"], .mb-board input[type="week"], .mb-board input[type="number"], .mb-board input[type="email"], .mb-board input[type="url"], .mb-board input[type="search"], .mb-board input[type="tel"] {
        display: inline-block;
        padding: 5px 7px;
        margin: 0;
        *padding: 3px 0px !important;
        font-size: 13px;
        line-height: 18px;
        vertical-align: middle;
        height: 30px !important;
        *height: 22px !important;
        border: 1px solid #ccc;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;
        background-color: #FFF;
        color: #6A6A6A !important;
    }

    .mb-style1 .search-text {
        width: 110px !important;
    }

    .mb-board .btn-search {
        margin: 0;
        padding: 5px 10px 5px !important;
        height: 30px !important;
    }

    .mb-board .btn-default {
        margin: 0;
        padding: 5px 10px 5px;
        border: 1px solid #ccc;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;
        background-color: #F0F0F0 !important;
        height: 30px !important;
    }

    .mb-board .btn {
        display: inline-block;
        min-width: 42px;
        *height: 30px !important;
        text-decoration: none !important;
        font-weight: bold;
        font-size: 13px;
        line-height: 18px !important;
        vertical-align: middle !important;
    }

    .mb-board a, .mb-board button {
        text-decoration: none !important;
        color: #6A6A6A !important;
        background: none;
        box-shadow: none !important;
    }

    .board-list table.table-list {
        border-top: 2px solid #dbdbdb !important;
        border-bottom: solid 1px #b3b2b261;
    }

    .board-list table.table-list th {
        text-align: center;
        font-weight: bold;
    }

    .board-list table.table-list th, .board-list table.table-list td {
        padding: 0;
        border-top: solid 1px #b3b2b261;
        border-bottom: 0;
        font-size: 13px;
        line-height: 2.6em;
    }

    .board-list table.table-list .col-no, .board-list table.table-list .col-date, .board-list table.table-list .col-hit, .board-list table.table-list .col-author {
        text-align: center;
    }

    .board-list table.table-list .col-no, .board-list table.table-list .col-hit {
        width: 50px;
    }
    .board-list table.table-list .col-date, .board-list table.table-list .col-author {
        width: 90px;
    }
    .board-list table.table-list td.col-date {
        font-size: 12px;
        line-height: 20px;
    }

    .pagination-box span.page_button {
        display: inline-block;
        width: 30px;
        cursor: pointer;
    }

    .pagination-box span.page_button.disabled{
        cursor: default;
    }

    .pagination-box span.current_page {
        display: inline-block;
        width: 60px;
    }

    @media (min-width: 321px) {
      .d-ssm-table-cell {
        display: table-cell !important;
      }
    }

    .mb-board a:hover, .mb-board button:hover {
        color: black !important;
    }
</style>
<!--컨텐츠-->
<div class="contents_area_wrap0">
    <div class="gpe_contents_box">
        <div class="mb-style1 board-list mb-board" style="padding: 5px;">
            <div class="list-head">
                <div class="mb-category" style="font-weight: bold;"><?php if($categoryInfo) echo $categoryInfo->categoryName;?></div>    
                <div class="list-search float-right">
                    <select id="search_field">
                        <option value="id">No</option>
                        <option value="article_title" selected="">Title</option>
                        <option value="member_name">Writer</option>
                        <option value="article_content">Content</option>
                        <option value="article_date">Date</option>
                    </select>
                    <input type="text" id="search_text" class="search-text">
                    <button class="btn btn-search btn-default" id="btn_search">Search</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div style="height: 10px;"></div>
            <div class="main-style1">
                <table cellspacing="0" cellpadding="0" border="0" id="tbl_board_list" class="table table-list">
                    <thead>
                        <tr>
                            <th class="col-no d-none d-md-table-cell">No</th>
                            <th>Title</th>
                            <th class="col-author d-none d-ssm-table-cell">Writer</th>
                            <th class="col-date d-none d-sm-table-cell">Date</th>
                            <th class="col-hit d-none d-md-table-cell">Hit</th>
                        </tr>
                    </thead>
                    <tbody id="board_body">
                        <?php foreach($articles as $article){?>
                        <tr>
                            <td class="col-no d-none d-md-table-cell"><?=$article->id?></td>
                            <td><a href="<?=ROOTPATH?>article/<?=$article->id?>"><?=$article->article_title?><?php if($article->reply_count > 0):?> [<?=$article->reply_count?>]<?php endif?></a> <?php if(strtotime($article->regDate) + 86400 > time()):?><img class="user-i-level mb-level-10" src="<?=ROOTPATH.PROJECT_IMG_DIR?>bbs_basic/icon_new.gif"><?php endif?></td>
                            <td class="col-author d-none d-ssm-table-cell"><?=$article->memberName?></td>
                            <td class="col-date d-none d-sm-table-cell"><?=date("M j, Y", strtotime($article->regDate))?><br><?=date("H:i", strtotime($article->regDate))?></td>
                            <td class="col-hit d-none d-md-table-cell"><?=$article->good_count?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div style="text-align: right;">
                    <button class="btn btn-search btn-default" onclick="<?php if($memberIdx):?>top.location.href='<?=ROOTPATH?>article_new/<?=$categoryIdx?>';<?php else:?>alert('You have to login!');<?php endif?>">Write</button>
            </div>            
            <div class="pagination-box">
                <div style="margin: 0px auto; width: 200px; text-align: center;">
                    <span class="page_button"><img src="<?=ROOTPATH.PROJECT_IMG_DIR?>bbs_basic/btn_paging_pprev.gif" alt="First" id="btn_first"></span>
                    <span class="page_button"><img src="<?=ROOTPATH.PROJECT_IMG_DIR?>bbs_basic/btn_paging_prev.gif" alt="Prev" id="btn_prev"></span>
                    <span class="current_page">1</span>
                    <span class="page_button"><img src="<?=ROOTPATH.PROJECT_IMG_DIR?>bbs_basic/btn_paging_next.gif" alt="Next" id="btn_next"></span>
                    <span class="page_button"><img src="<?=ROOTPATH.PROJECT_IMG_DIR?>bbs_basic/btn_paging_nnext.gif" alt="Last" id="btn_last"></span>
                </div>
            </div>
        </div>
    </div>
    <!--[SIDE컨텐츠_우측]-->
    <?php include_once(__DIR__."/../common/sidebar.php");?>
</div>