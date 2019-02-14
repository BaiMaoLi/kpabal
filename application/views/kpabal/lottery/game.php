<div id="span_js_messages" style="display:none"><span id="error_msg">you must select user</span>
</div>    <!-- start: megamilions-->
<link rel="stylesheet" href="<?=ROOTPATH?>assets/css/lotto-game.css?v=1.1" type="text/css">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="height: auto; position: static !important; padding: 0.75rem 1rem !important; margin: 0 0 1rem 0 !important; background-color: #e9ecef !important;"> 
    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>lottery">Megamilions</a></li> 
    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>lottery/CashforLife">CashforLife</a></li> 
    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>lottery/LuckyforLife">LuckyforLife</a></li> 
    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>lottery/HotLotto">HotLotto</a></li> 
    <li class="breadcrumb-item"><a href="<?=ROOTPATH?>lottery/powerball">Powerball</a></li> 
    </ol>
</nav>
<div class="nm-row">
    <div id="lotto-games" class="panel panel-default">    <?php if($lotteryTitle == "Mega Millions"){ ?>
        <div class="panel-heading">    <?php }else{ ?>
            <div class="panel-heading" style="height: 5em;">    <?php } ?>
                <div class="lottery-title"><img src="<?=$lotteryImage?>">            <h4><strong><?=$gameType?></strong> |
                        USA | <?=$lotteryAllPrice?> | <?=$lotteryNextDate?></h4></div>
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default quick-pick">Quick Pick +1</button>
                        <button type="button" class="btn btn-default all-pick">+ All</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default all-delete"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="panel-body">
                <div class="lotto-game-number-pads">
                    <div class="lotto-game-number-pads-contents">
                        <div class="lotto-game-number-pads-contents-override"></div>
                    </div>
                    <div class="lotto-game-number-pad-move-left"><i class="fa fa-arrow-left"></i></div>
                    <div class="lotto-game-number-pad-move-right"><i class="fa fa-arrow-right"></i></div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-8">
                        <div class="btn-toolbar draw-actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" disabled="">Duration:</button>
                                <button type="button" class="btn btn-default active" data-draw-count="1"><i
                                            class="fa fa-check"></i> 1 Draw
                                </button>
                                <button type="button" class="btn btn-default" data-draw-count="5"><i
                                            class="fa fa-check"></i> 5 Draws
                                </button>
                                <button type="button" class="btn btn-default" data-draw-count="10"><i
                                            class="fa fa-check"></i> 10 Draws
                                </button>
                                <button type="button" class="btn btn-default" data-draw-count="20"><i
                                            class="fa fa-check"></i> 20 Draws
                                </button>
                                <button type="button" class="btn btn-default" data-draw-count="25"><i
                                            class="fa fa-check"></i> 25 Draws
                                </button>
                                <button type="button" class="btn btn-default" data-draw-count="50"><i
                                            class="fa fa-check"></i> 50 Draws
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group"><span class="input-group-addon" id="total-result">Total: $0.00</span>
                            <button type="button" class="btn btn-danger result-submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="<?=ROOTPATH?>lottery/ticket_result" method="post" style="display: none;" id="lotteryForm"><input
                type="hidden" name="lotteryTitle" id="lotteryTitle"/> <input type="hidden" name="lotteryPrice"
                                                                             id="lotteryPrice"/> <input type="hidden"
                                                                                                        name="lotteryImage"
                                                                                                        id="lotteryImage"/>
        <input type="hidden" name="lotteryDate" id="lotteryDate"/> <input type="hidden" name="lotteryData"
                                                                          id="lotteryData"/> <input type="hidden"
                                                                                                    name="lotteryAllPrice"
                                                                                                    id="lotteryAllPrice"/><input type="hidden" name="gameType" id="gameType" value="<?=$gameType?>" />
    </form>
    <script type="text/javascript" src="<?=ROOTPATH?>assets/js/lotto-game.js?v=1.2.1"></script>
    <script>                      
    jQuery(function () {
            LottoGame.init("lotto-games", {
                maxPadNumber: <?=$maxPadNumber?>,
                maxBall: <?=$maxBall?>,
                lotteryImage: '<?=$lotteryImage?>',
                lotteryDate: '<?=date("Y-m-d H:i:s")?>',
                lotteryTitle: '<?=$gameType?>',
                lotteryAllPrice: '<?=$lotteryAllPrice?>',
            });
        });          </script>