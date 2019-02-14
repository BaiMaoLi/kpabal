var LottoGame = function () {
  var $game;
  var $gamePadContents;

  var firstDrawCount = 0;
  var drawCount = 0;
  var maxNumberPadCount = 19;
  var focusDrawIndex = 1;
  var padWidth;

  var maxPadNumber = 75;
  var maxBall = 15;
  var chooseCount = 5;
  
  var lotteryImage;
  var lotteryTitle;
  var lotteryID;
  var lotteryPageID;
  var lotteryAllPrice;
  var lotteryDate;
  
  var costUnit = 2.5;
  var totalCost = 0;
  return {
    init: function (game, configs) {
      if (configs.maxPadNumber)
        maxPadNumber = configs.maxPadNumber;
      if (configs.maxBall)
        maxBall = configs.maxBall;
      if (configs.lotteryTitle)
        lotteryTitle = configs.lotteryTitle;
      if (configs.lotteryImage)
        lotteryImage = configs.lotteryImage;
      if (configs.lotteryID)
        lotteryID = configs.lotteryID;
      if (configs.lotteryPageID)
        lotteryPageID = configs.lotteryPageID;
      if (configs.lotteryAllPrice)
        lotteryAllPrice = configs.lotteryAllPrice;
      if (configs.lotteryDate)
        lotteryDate = configs.lotteryDate;

      $game = jQuery("#" + game);
      $gamePadContents = $game.find('.lotto-game-number-pads-contents-override');
      $game.find(".quick-pick").click(function () {
        LottoGame.quickPick();
      });

      $game.find(".all-pick").click(function () {
        LottoGame.allPick();
      });

      $game.find(".all-delete").click(function () {
        LottoGame.allDelete();
      });

      $game.find(".draw-actions .btn-default").click(function () {
        LottoGame.clickDraw(jQuery(this));
      });

      $game.find(".result-submit").click(function () {
        LottoGame.totalSubmit();
      });

      var gamePadContentsW = $game.find('.lotto-game-number-pads').width();
      if (gamePadContentsW < 400) {
        firstDrawCount = 1;
      } else if (gamePadContentsW < 600) {
        firstDrawCount = 2;
      } else if (gamePadContentsW < 900) {
        firstDrawCount = 3;
      } else if (gamePadContentsW < 1000) {
        firstDrawCount = 4;
      } else if (gamePadContentsW < 1100) {
        firstDrawCount = 5;
      } else {
        firstDrawCount = 6;
      }
      padWidth = gamePadContentsW / firstDrawCount;
      console.log(padWidth);
      for (var i = 1; i <= firstDrawCount; i++) {
        LottoGame.drawNumberPad(i);
      }

      jQuery(".lotto-game-number-pad-move-left").click(function () {
        if (focusDrawIndex <= 1) {
          return;
        }
        focusDrawIndex--;
        $gamePadContents.animate({
          marginLeft: "+=" + padWidth
        }, 200);
      });

      jQuery(".lotto-game-number-pad-move-right").click(function () {
        if (firstDrawCount + focusDrawIndex > drawCount) {
          return;
        }
        focusDrawIndex++;
        $gamePadContents.animate({
          marginLeft: "-=" + padWidth
        }, 200);
      });

      jQuery(window).resize(function () {
        setTimeout(function () {
          LottoGame.resizeDraw();
        }, 20);
      });
    },
    quickPick: function () {
      var isPicked = false;
      $game.find(".lotto-game-number-pad").each(function (index) {
        if (isPicked || jQuery(this).hasClass('successed')) {
          return;
        }

        LottoGame.randomLottory(index + 1);
        LottoGame.randomBall(index + 1);
        isPicked = true;
      });

      if (isPicked) {
        LottoGame.calcTotal();
        return;
      }

      if (drawCount >= maxNumberPadCount) {
        alert("Can't buy ticket any more.");
        return;
      }

      $game.find(".lotto-game-number-pads").addClass('overflow');
      LottoGame.drawNumberPad(drawCount + 1);

      focusDrawIndex = drawCount - firstDrawCount + 1;

      $gamePadContents.animate({
        marginLeft: "-" + ((focusDrawIndex - 1) * padWidth)
      }, 500, function () {
        setTimeout(function () {
          LottoGame.randomLottory(drawCount);
          LottoGame.randomBall(drawCount);
        }, 200);
      });
    },
    allPick: function () {
      $game.find(".lotto-game-number-pad").each(function (index) {
        LottoGame.randomLottory(index + 1);
        LottoGame.randomBall(index + 1);
      });

      LottoGame.calcTotal();
    },
    allDelete: function () {
      $gamePadContents.find(".lotto-game-number-pad").removeClass('successed');
      $gamePadContents.find(".lotto-game-number-pad-number.selected").removeClass('selected');
      $gamePadContents.find(".lotto-game-number-pad-numbers").removeClass("writed");

      LottoGame.calcTotal();
    },
    clickDraw: function ($drawBtn) {
      $game.find(".draw-actions .btn-default").removeClass('active');

      $drawBtn.addClass('active');

//      drawCount = $drawBtn.attr('data-draw-count');

      LottoGame.calcTotal();
    },
    drawNumberPad: function (index) {
      drawCount++;

      var padHtml = '<div id="lotto-game-number-pad-' + index + '" class="lotto-game-number-pad" style="width:' + padWidth + 'px;">';
      padHtml += '<div class="lotto-game-number-pad-header">';
      padHtml += '<label>Choose ' + chooseCount + '</label>';
      padHtml += '<div class="lotto-game-number-pad-actions">';
      padHtml += '<button type="button" class="btn btn-default btn-xs" data-role="refresh"><i class="fa fa-refresh"></i></button>';
      padHtml += '<button type="button" class="btn btn-default btn-xs" data-role="trash"><i class="fa fa-trash"></i></button>';
      padHtml += '</div>';
      padHtml += '</div>';
      padHtml += '<div class="lotto-game-number-pad-numbers">';
      for (var i = 1; i <= maxPadNumber; i++) {
        padHtml += '<div class="lotto-game-number-pad-number" data-number="' + i + '">';
        padHtml += '<span>' + i + '</span>';
        padHtml += '<i class="fa fa-remove"></i>';
        padHtml += '</div>';
      }
      if(maxPadNumber != 75){
        padHtml += '<div class="lotto-game-number-pad-index" style="margin-top: 40%;">' + index + '</div>';
      }
      else{
        padHtml += '<div class="lotto-game-number-pad-index">' + index + '</div>';
      }
      padHtml += '<div class="clear"></div>';
      padHtml += '</div>';
      padHtml += '<div class="lotto-game-number-pad-footer">';
      padHtml += '<label>Mega Ball</label>';
      padHtml += '<select class="form-control">';
      var defaultBall = LottoGame.getRandomInt(1, maxBall);
      for (var i = 1; i <= maxBall; i++) {
        padHtml += '<option value="' + i + '"' + (defaultBall === i ? ' selected' : '') + '>' + i + '</option>';
      }
      padHtml += '</select>';
      padHtml += '<i class="fa fa-question-circle"></i>';
      padHtml += '<i class="fa fa-check-circle"></i>';
      padHtml += '</div>';
      padHtml += '</div>';

      $gamePadContents.width(drawCount * padWidth);
      $gamePadContents.append(padHtml);

      LottoGame.initPadNumberEvent(index);
    },
    resizeDraw: function () {
      var gamePadContentsW = $game.find('.lotto-game-number-pads').width();
      if (gamePadContentsW < 400) {
        firstDrawCount = 1;
      } else if (gamePadContentsW < 600) {
        firstDrawCount = 2;
      } else if (gamePadContentsW < 900) {
        firstDrawCount = 3;
      } else if (gamePadContentsW < 1000) {
        firstDrawCount = 4;
      } else if (gamePadContentsW < 1100) {
        firstDrawCount = 5;
      } else {
        firstDrawCount = 6;
      }
      padWidth = gamePadContentsW / firstDrawCount;

      $gamePadContents.width(drawCount * padWidth);
      $gamePadContents.find(".lotto-game-number-pad").outerWidth(padWidth);

      if (firstDrawCount < drawCount) {
        $game.find(".lotto-game-number-pads").addClass('overflow');
      } else {
        $game.find(".lotto-game-number-pads").removeClass('overflow');
      }

      $gamePadContents.css({
        marginLeft: 0
      });
    },
    initPadNumberEvent: function (index) {
      var $numberPad = jQuery("#lotto-game-number-pad-" + index);
      $numberPad.find(".lotto-game-number-pad-number").click(function () {
        var $parent = jQuery(this).parent();

        var selectedNumbers = $parent.find(".lotto-game-number-pad-number.selected").length;

        if (jQuery(this).hasClass("selected")) {
          jQuery(this).removeClass("selected");
          selectedNumbers--;
        } else {
          if (selectedNumbers === chooseCount)
            return;

          jQuery(this).addClass("selected");
          selectedNumbers++;
        }

        if (selectedNumbers === 0) {
          $parent.removeClass("writed");
        } else {
          $parent.addClass("writed");
        }

        if (selectedNumbers === chooseCount) {
          $numberPad.addClass('successed');
        } else {
          $numberPad.removeClass('successed');
        }

        LottoGame.calcTotal();
      });

      $numberPad.find(".lotto-game-number-pad-actions .btn").each(function () {
        var role = jQuery(this).attr("data-role");
        if (role === 'refresh') {
          jQuery(this).click(function () {
            LottoGame.randomLottory(index);
            LottoGame.randomBall(index);
          });
        } else if (role === 'trash') {
          jQuery(this).click(function () {
            $numberPad.removeClass('successed');
            $numberPad.find(".lotto-game-number-pad-number.selected").removeClass('selected');
            $numberPad.find(".lotto-game-number-pad-numbers").removeClass("writed");

            LottoGame.calcTotal();
          });
        }
      });
    },
    randomLottory: function (index) {
      var $numberPad = jQuery("#lotto-game-number-pad-" + index);

      var selectedNumbers = $numberPad.find(".lotto-game-number-pad-number.selected").length;
      if (selectedNumbers === chooseCount) {
        $numberPad.find(".lotto-game-number-pad-number").removeClass("selected");
      }

      while (true) {
        selectedNumbers = $numberPad.find(".lotto-game-number-pad-number.selected").length;

        if (selectedNumbers === chooseCount)
          break;

        var randomNumber = LottoGame.getRandomInt(1, maxPadNumber);
        var $numberItem = $numberPad.find(".lotto-game-number-pad-number[data-number=" + randomNumber + "]");
        $numberItem.addClass('selected');
      }
      
      $numberPad.addClass("successed");
      $numberPad.find(".lotto-game-number-pad-numbers").addClass("writed");

      LottoGame.calcTotal();
    },
    
    randomBall: function (index) {
      var randomBall = LottoGame.getRandomInt(1, maxBall);
      var $numberPad = jQuery("#lotto-game-number-pad-" + index);
      $numberPad.find(".form-control").val(randomBall);              
    },
    
    calcTotal: function () {
      var calsPadCount = 0;
      $game.find(".lotto-game-number-pad").each(function () {
        if (jQuery(this).hasClass('successed')) {
          calsPadCount++;
          return;
        }

        if (jQuery(this).find('.lotto-game-number-pad-numbers').hasClass('writed')) {
          calsPadCount++;
          return;
        }
      });
      
      var selectedDraw = $game.find(".draw-actions .btn-default.active").attr("data-draw-count");
      
      totalCost = costUnit * calsPadCount * selectedDraw;
      if(selectedDraw > 1 )
        totalCost = totalCost - 0.32*selectedDraw*calsPadCount;
      jQuery("#total-result").text("$ " + totalCost);
    },
    totalSubmit: function () {
      var lotteryArray = [];
      $game.find(".lotto-game-number-pad").each(function (index) {        
        if (jQuery(this).find('.lotto-game-number-pad-numbers').hasClass('writed')) {
          if(!jQuery(this).hasClass('successed')) {
            LottoGame.randomLottory(index+1);
          }
          jQuery(this).find('.lotto-game-number-pad-number.selected').each(function(){  
            lotteryArray.push(jQuery(this).find('span').text());              
          });
          
        }
        if(jQuery(this).hasClass('successed')){
          lotteryArray.push(jQuery(this).find('.form-control option:selected').text());
        }
      });
      if (lotteryArray.length != 0){
        jQuery("#lotteryTitle").val(lotteryTitle);
        jQuery("#lotteryImage").val(lotteryImage);
        jQuery("#lotteryPrice").val(totalCost);
        jQuery("#lotteryID").val(lotteryID);
        jQuery("#lotteryPageID").val(lotteryPageID);
        jQuery("#lotteryAllPrice").val(lotteryAllPrice);
        jQuery("#lotteryDate").val(lotteryDate);
        jQuery("#lotteryData").val(lotteryArray.join(","));
        jQuery("#lotteryForm").submit();
      }
      else {
        alert("You need to select 1 ticket at least.");
      }
    },
    getRandomInt: function (min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }
  };
}();