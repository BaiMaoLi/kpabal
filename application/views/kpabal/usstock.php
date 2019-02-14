<div class="contents_area_wrap0">
    <!--사이드영역 배경bg-->
	 <style>
   .tradingview-widget-container{
   .    width: 100%;
    height: 600px;
   }
   iframe:not(#top-stock > iframe){
	   height: calc(375px) !important;
    width: 100% !important;
   }
		 .gpe_side_contents_R {border:  none !important;}
		 .con_right_line {display: none}
   </style>
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
    <span class="con_right_line"></span>
	
		 <h1 class="page-title">US Stock</h1>
		 <br />
	 <div class="gpe_contents_box">
	    <div class="news">
			
				
	<?php			 $imx='';
			 if($rlist['tpic'][0]!=''){
				 $imx=str_replace('w=116','w=350',$rlist['tpic'][0]);
			 }
			 	 $imx1='';
			 if($rlist['tpic'][1]!=''){
				 $imx1=str_replace('w=116','w=350',$rlist['tpic'][1]);
			 }
			 	 $imx2='';
			 if($rlist['tpic'][2]!=''){
				 $imx2=str_replace('w=116','w=350',$rlist['tpic'][2]);
			 }
			 	 $imx3='';
			 if($rlist['tpic'][3]!=''){
				 $imx3=str_replace('w=116','w=350',$rlist['tpic'][3]);
			 }

?>			 
				
		<div class="row left-sec">
		<div class="col-md-6"><a href="<?=$rlist['turl'][0]?>" target="_blank">
		<div  style="background-image:url(<?=$imx?>);" class="headline1"></div>
		<div class="headtitle headtitle1"><?=$rlist['tname'][0]?></div></a>
			</div>
		<div class="col-md-6">
		<div class="row right-sec">
		<div class="col-md-12">
			
		<a href="<?=$rlist['turl'][1]?>" target="_blank"><div style="background-image:url(<?=$imx1?>);" class="headline2"></div><div class="headtitle headtitle2"><?=$rlist['tname'][1]?></div></a>
		</div>
		<div class="col-md-6">
		<a href="<?=$rlist['turl'][2]?>" target="_blank"><div style="background-image:url(<?=$imx2?>);" class="headline3"></div><div class="headtitle headtitle3"><?=$rlist['tname'][2]?></div></a></div>
			
		<div class="col-md-6">
		<a href="<?=$rlist['turl'][3]?>" target="_blank"><div style="background-image:url(<?=$imx3?>);" class="headline3"></div><div class="headtitle headtitle3"><?=$rlist['tname'][3]?></div></a></div>
		</div>
		</div>
		
		 
		 </div>
		</div>
		 <p>&nbsp;</p>
		 <ul id="clothing-nav" class="nav nav-tabs" role="tablist">
	
<li class="nav-item">
<a class="nav-link active" href="#news" id="news-tab" role="tab" data-toggle="tab" aria-controls="news" aria-expanded="true">News</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#reuters" role="tab" id="reuters-tab" data-toggle="tab" aria-controls="ideas">Reuters News</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#ideas" role="tab" id="ideas-tab" data-toggle="tab" aria-controls="ideas">Ideas</a>
</li>
			 
<li class="nav-item">
<a class="nav-link" href="#tvnews" role="tab" id="tvnews-tab" data-toggle="tab" aria-controls="board">Trading View News</a>
</li>
			 
<li class="nav-item">
<a class="nav-link" href="#board" role="tab" id="board-tab" data-toggle="tab" aria-controls="board">Discussion Board</a>
</li>

</ul>

<!-- Content Panel -->
<div id="clothing-nav-content" class="tab-content">

<div role="tabpanel" class="tab-pane fade show active" id="news" aria-labelledby="news-tab">

	
  						<h3 class="stock-titles">News</h3>
			 			<div class="row">
						 <?php
						 $ctx=0;
						 foreach($newslist['img'] as $img){
						 ?>
						 <div class="col-md-6"><a class="stock-box" href="<?=$newslist['url'][$ctx]?>" target="_blank"><div class="row">
						 <div class="col-md-12">
							 <div class="stock-img"><div class="stock-img-inr" style="background-image:url(<?=$img?>);"></div></div>
							 </div>
						 <div class="col-md-12"><?=$newslist['name'][$ctx]?></div>
						 </div></a></div>
						 <?php 
						 $ctx++;
						 } ?>
                        </div>
						
						
						
	
</div>

<div role="tabpanel" class="tab-pane fade" id="reuters" aria-labelledby="reuters-tab">

	<h3 class="stock-titles">Reuters News</h3>
						
						 <div class="row">
						 <?php
						 $ctx=0;
						 foreach($rlist['url'] as $img){
						 ?>
						 <div class="col-md-6"><a class="stock-box" href="<?=$rlist['url'][$ctx]?>" target="_blank"><div class="row">
						 <div class="col-md-12">
							 
							 <div class="stock-img"></div>
							 </div>
						 <div class="col-md-12"><?=$rlist['name'][$ctx]?></div>
						 </div></a></div>
						 <?php 
						 $ctx++;
						 } ?>
                        </div>
	
</div>
<div role="tabpanel" class="tab-pane fade" id="ideas" aria-labelledby="ideas-tab">

	<h3 class="stock-titles">Ideas</h3>
						 <div class="row">
						 <?php
						 $ctx=0;
						 foreach($idealist['img'] as $img){
						 ?>
						 <div class="col-md-6"><a class="stock-box" href="<?=$idealist['url'][$ctx]?>" target="_blank"><div class="row">
						 <div class="col-md-12">
							 <div class="stock-img"><div class="stock-img-inr" style="background-image:url(<?=$img?>);"></div></div>
							 </div>
						 <div class="col-md-12"><?=$idealist['name'][$ctx]?></div>
						 </div></a></div>
						 <?php 
						 $ctx++;
						 } ?>
                        </div>
	
</div>
	
<div role="tabpanel" class="tab-pane fade" id="tvnews" aria-labelledby="tvnews-tab">
	
	<h3 class="stock-titles">Trading View News</h3>
						 <div class="row">
						 <?php
						 $ctx=0;
						 foreach($nlist['img'] as $img){
						 ?>
						 <div class="col-md-6"><a class="stock-box" href="<?=$nlist['url'][$ctx]?>" target="_blank"><div class="row">
						 <div class="col-md-12">
							 
							 <div class="stock-img"><div class="stock-img-inr" style="background-image:url(<?=$img?>);"></div></div>
							 </div>
						 <div class="col-md-12"><?=$nlist['name'][$ctx]?></div>
						 </div></a></div>
						 <?php 
						 $ctx++;
						 } ?>
                        </div>
			</div>

<div role="tabpanel" class="tab-pane fade" id="board" aria-labelledby="board-tab">

	<h3 class="stock-titles">Discussion Board</h3>

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

</div>
		 

	</div>
	<div class="gpe_side_contents_R">
	<div>
	    <div class="xe-widget-wrapper" style="float: left; width: 389px; border-width: 0px; border-style: solid; border-color: rgb(0, 0, 0); margin: 0 0px 0px; background-color: transparent; background-image: none; background-repeat: repeat; background-position: 0% 0%;">
                    <div style="*zoom:1;padding:0px 0px 0px 0px !important;">
                        <div class="widgetNOVAContainer">
                    
<!-- TradingView Widget BEGIN -->
		  <h3 class="stock-titles">Techinical Analysis</h3>
							<div class="row">
								<div class="col-md-12">
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async>
  {
  "width": 425,
  "height": 400,
  "symbol": "NASDAQ:NDAQ",
  "locale": "in",
  "interval": "1D"
}
  </script>
</div>
									</div>
								</div>
<!-- TradingView Widget END -->

          <!-- TradingView Widget BEGIN -->
							<div class="row">
								<div class="col-md-12">
		  <h3 class="stock-titles">Indices</h3>
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <div class="tradingview-widget-copyright"><a href="https://in.tradingview.com/markets/indices/" rel="noopener" target="_blank"><span class="blue-text">Indices</span></a> by TradingView</div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
  {
  "showChart": true,
  "locale": "in",
  "largeChartUrl": "",
  "width": "400",
  "height": "450",
  "plotLineColorGrowing": "rgba(60, 188, 152, 1)",
  "plotLineColorFalling": "rgba(255, 74, 104, 1)",
  "gridLineColor": "rgba(233, 233, 234, 1)",
  "scaleFontColor": "rgba(214, 216, 224, 1)",
  "belowLineFillColorGrowing": "rgba(60, 188, 152, 0.05)",
  "belowLineFillColorFalling": "rgba(255, 74, 104, 0.05)",
  "symbolActiveColor": "rgba(242, 250, 254, 1)",
  "tabs": [
    {
      "title": "Indices",
      "symbols": [
        {
          "s": "INDEX:SPX",
          "d": "S&P 500"
        },
        {
          "s": "INDEX:IUXX",
          "d": "Nasdaq 100"
        },
        {
          "s": "INDEX:DOWI",
          "d": "Dow 30"
        },
        {
          "s": "INDEX:NKY",
          "d": "Nikkei 225"
        },
        {
          "s": "INDEX:DAX",
          "d": "DAX Index"
        },
        {
          "s": "OANDA:UK100GBP",
          "d": "FTSE 100"
        }
      ],
      "originalTitle": "Indices"
    }
  ]
}
  </script>
</div>
									
									</div>
								</div>
<!-- TradingView Widget END -->

  <!-- TradingView Widget BEGIN -->
							 <div class="row">
		 <div class="col-md-12">
		 
  <h3>Economic Calendar</h3>
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-events.js" async>
  {
  "width": "100%",
  "height": "400",
  "locale": "in",
  "importanceFilter": "-1,0,1",
  "currencyFilter": "USD,JPY"
}
  </script>
</div>
		 </div>
                        </div>
<!-- TradingView Widget END -->
							
                        </div>
                    </div>
					
                </div>
                </div>
                </div>
	</div>