//console.log("start");
function toTop(){
    $('html,body').animate({
        scrollTop: 0
    }, 900, function(){
        console.log("top !");
    });
}
function initToTopBtn(){
    var $btn = $("#to-top");
    $btn.on("click", null, function(){
        toTop();
    });
    var $win = $(window);
    var wh = $win.height();
    $win.on("scroll", null, function(){
        var y = this.scrollY;
        if( y > (wh /2)  )
        {
            $btn.addClass("show");
        }
        else
        {
            $btn.removeClass("show");
        }
    });
}
function providerId(){
    if($('#btn').css('backgroundColor') != 'rgb(1, 52, 123)'){
        $('#btn').css('cursor','default')
    }
    $('#provideid-input').focus(function(){
        $(this).attr('placeholder','');
        $(this).val('');
        $('#btn').css({'backgroundColor':'#808080','cursor':'default'})
    })
        $('#provideid-input').blur(function(){
        $(this).attr('placeholder','input')
    })
        $('#provideid-input').keyup(function(){
        var textCount = $(this).val().length;
        if(textCount >= 1){
                $('#btn').css({'backgroundColor':'#01347b','cursor':'pointer'})
        }else{
                $('#btn').css({'backgroundColor':'#808080','cursor':'default'})
        }
    })
    $('#btn').click(function(){
      var providerIdValue = $('#provideid-input').val();
        $('span.loading').show();
      var request = {
          "getPegasusVersionInfo":{
              "provider" : providerIdValue,
          }
      };
      request = JSON.stringify(request).replace(/,/g,", ");
      if(!providerIdValue){
          $('span.loading').hide();
          return false;
      }else{
        $.ajax({
          type:'POST',
          url:'../playground/functions.php',
          data:request,
          dataType:'json',
          success:function(response){
            if(response.status == 200){
              $('span.loading').hide();
              sessionStorage.setItem('providerIdValue',providerIdValue);
              window.location.href="../playground";
            }else{
              $('.blank-pop-up').show();
              $('span.loading').hide();
              $('#closeBtn,.close').click(function(){
                $('.blank-pop-up').hide();
              })
            }
          },
          error:function(res){

          }
        })
      }
    });

    $('#provideid-input').keypress(function(event){
        var key = event.which;
        if(key == 13){
            $('#btn').click();
            return false;
        }
    });

}
/* contact form */
function initContactForm(){
    //console.log("aa");
    function emptyAny($inputs){
        for( var i = 0; i < $inputs.length; i++ )
        {
            var $input = $inputs[i];
            var val = $.trim($input.val());
            if( val == "" )
            {
                return {
                    status: true,
                    $input: $input
                };
            }
        }
        return {status: false};
    }
    function resetError(){
        $(".form-wrapper form .input-item").removeClass("error");
    }
    function setError($input){
        $input.parent().addClass("error");
        $input.focus();
    }
    function verifyEmail(email){
        var reg = /^([^@]+)@([^@.]+)\.([^@.]+)$/;
        var result = reg.test(email);
        return result;
    }
    function verifyInputs($inputs){
        var pass = true;
        resetError();
        var empty = emptyAny($inputs);
        if( empty.status )
        {
            setError(empty.$input);
            pass = false;
        }
        var correctEmail = verifyEmail($inputs[3].val());
        if( !correctEmail )
        {
            setError($inputs[3]);
            pass = false;
        }
        //console.log(empty);
        return pass;
    }
    var $form = $(".form-wrapper input[type='submit']");
    $form.click(function(e){
      var $inputs = [
          $("#input-company"),
          $("#input-name"),
          $("#input-phone"),
          $("#input-email"),
          $("#input-subject"),
          $("#input-message")
      ];
      var pass = verifyInputs($inputs);
      if(!pass){
        e.preventDefault();
      }else{

      }
    })
    // $form.on("click", null, function(event){
    //     event.preventDefault();
    //
    //     if( pass )
    //     {
    //         var body = "Company : " + $inputs[0].val() + "<br>" +
    //                    "Name : " + $inputs[1].val() + "<br>" +
    //                    "Phone : " + $inputs[2].val() + "<br>" +
    //                    "Email : " + $inputs[3].val() + "<br>" +
    //                    "Subject : " + $inputs[4].val() + "<br>" +
    //                    "Message : " + $inputs[5].val();
    //          $("#input-body").val(body);
    //          $form.off("submit");
    //          $form.submit();
    //         console.log(body);
    //     }
    //
    //     //console.log(event.target);
    // });
}

initToTopBtn();
initContactForm();
providerId();
