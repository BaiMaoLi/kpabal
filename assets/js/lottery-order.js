var LottoOrder = function () {
  
  var $game;
  var $gamePadOrder;
  var $gameLottoResult;
  
  var lotteryTitle;
  var lotteryPrice;
  var lotteryImage;
  var lotteryDate;
  var lotteryData;
  var lotteryAllPrice;

  
  return {
    init: function (game, configs) {
 
      if (configs.lotteryTitle)
        lotteryTitle = configs.lotteryTitle;
      if (configs.lotteryImage)
        lotteryImage = configs.lotteryImage;
      if (configs.lotteryDate)
        lotteryDate = configs.lotteryDate;
      if (configs.lotteryData)
        lotteryData = configs.lotteryData;
      if (configs.lotteryPrice)
        lotteryPrice = configs.lotteryPrice;
      if (configs.lotteryAllPrice)
        lotteryAllPrice = configs.lotteryAllPrice;
      
      $game = jQuery("#" + game);
      $gamePadOrder = $game.find('.order-result');
      $gameLottoResult = $game.find('#dialog');
      LottoOrder.drawLotteryOrder();
      
      $game.find("p").click(function () {
        jQuery( "#dialog" ).dialog({height: 400, width: 370});
      });
      
      $game.find(".confirmOrder_btn").click(function () {
//        jQuery('#confirm_order_frm').submit();
//        jQuery.ajax({
//          type: "POST",
//          url: 'ticket_result',
//          data: configs,
//          success: function(data) {
//            alert("ok");
//            jQuery('#confirm_order_paypal').submit();
//          }
//        });
            jQuery('#confirm_order_paypal').submit();
      });
      
      $game.find(".btn-default").click(function () {
        var role = jQuery(this).attr("data-role");
        if (role === 'edit') {

        } else if (role === 'trash') {
          window.history.back();
        }
      });
      
    },
    
    drawLotteryOrder: function () {
      
      var orderNums = lotteryData.split(",");
      var num = orderNums.length;
      var i=0;
      
      var padHtml = '<div style="border-bottom: 1px solid #CCC; padding: 15px 0;">';
          padHtml += '<div class="col-md-6 col-sm-6 col-xs-8">';
          padHtml += '<img src="' + lotteryImage + '" width="115" height="54" style="float: left;">';
          padHtml += '<h4 style="float: left; padding-left: 2px;">' + lotteryTitle + '<br/>';
          padHtml += '<span style="font-size: 0.5em">USA</span>';
          padHtml += '</h4>';
          padHtml += '</div>';
          padHtml += '<div class="col-md-4 col-sm-4 col-xs-4">';
          padHtml += '<strong>'+ (num/6) +'  Ticket  </strong><br>';
          padHtml += '1 Draws<br>';
          padHtml += '<small>Draw Date: ' + lotteryDate + '</small><br>';
          padHtml += '<p><a>Your picks</a></p>';
          padHtml += '</div>';
          padHtml += '<div class="col-md-2 col-sm-2 col-xs-12" style="text-align: right;">';
          padHtml += '<br>';
          padHtml += '<button type="button" class="btn btn-default btn-xs" data-role="edit"><a class="fa fa-edit"></a></button>';
          padHtml += '<button type="button" class="btn btn-default btn-xs" data-role="trash"><a class="fa fa-trash"></a></button>';
          padHtml += '<br>';
          padHtml += '<strong>$ ' + lotteryPrice + '</strong>';
          padHtml += '</div>';          
          padHtml += '<div class="clearfix"></div>';
          padHtml += '</div>';
          
          padHtml += '<div style="border-bottom: 1px solid #CCC; padding: 15px; text-align: right;">';
          padHtml += '<p><strong><span>Total</span> $ ' + lotteryPrice + '</strong></p>';
          padHtml += '</div>';
      $gamePadOrder.append(padHtml);
      
      var orderHtml = '<ul class="games-lines-wrap">';
      while( i < num ) {
        if ( i%6 == 0 ) {
          orderHtml += '<li>';
          orderHtml += '<ul class="draw-result list-unstyled list-inline">';
          orderHtml += '<h4>Game '+ ((i/6)+1) +': </h4>';
        }
        
        if (i%6 == 5) {
          orderHtml += '<li style="color: red;"> '+ orderNums[i] +'</li>';
          orderHtml += '</ul>';
          orderHtml += '</li>';
        } else {
          orderHtml += '<li> '+ orderNums[i] +'</li>';
        }
        i++;
      }
      orderHtml += '</ul>';
      $gameLottoResult.append(orderHtml);
    }
  };
}();