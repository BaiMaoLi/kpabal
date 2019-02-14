var LottoLogs = function () {
  
  var $game;
  var $gameLottoResult;
  var $tblLogs;
 
  var lotteryData;
  
  return {
    init: function (game) {
     
      $game = jQuery("." + game);
      $gameLottoResult = $game.find('#dialog');
      $tblLogs = $game.find('#tblLogs');
      console.log($gameLottoResult);
    
      this.initEvent();
    },
    
    initEvent: function() {
      $tblLogs.find(".btn-view").click(function() {
        console.log(jQuery(this).attr('data-lottery-data'));            
        lotteryData = jQuery(this).attr('data-lottery-data');
        
        LottoLogs.drawLotteryOrder(lotteryData);
        jQuery( "#dialog" ).dialog({height: 400, width: 370});
      });
    },
    
    
    drawLotteryOrder: function (lotteryData) {
      
      var orderNums = lotteryData.split(",");
      var num = orderNums.length;
      var i=0;   
      $gameLottoResult.find(".games-lines-wrap").detach();
      var orderHtml = '<ul class="games-lines-wrap">';
      orderHtml += '<h4 style="font-weight: bold;">Number of tickets: '+ (num/6) +' </h4>';
      while( i < num ) {
        if ( i%6 == 0 ) {
          orderHtml += '<li>';
          orderHtml += '<ul class="draw-result list-unstyled list-inline">';
          orderHtml += '<h5>Game '+ ((i/6)+1) +': </h5>';
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
