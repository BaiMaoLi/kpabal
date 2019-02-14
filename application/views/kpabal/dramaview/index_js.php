
<script src='https://api.dmcdn.net/all.js'> </script>
<script >
    if (!window['YT']) {var YT = {loading: 0,loaded: 0};}
    if (!window['YTConfig']) {var YTConfig = {'host': 'http://www.youtube.com'};}
    if (!YT.loading) 
        {
            YT.loading = 1;(function(){var l = [];YT.ready = function(f) {if (YT.loaded) {f();} else {l.push(f);}};window.onYTReady = function() {YT.loaded = 1;for (var i = 0; i < l.length; i++) {try {l[i]();} catch (e) {}}};YT.setConfig = function(c) {for (var k in c) {if (c.hasOwnProperty(k)) {YTConfig[k] = c[k];}}};var a = document.createElement('script');a.type = 'text/javascript';a.id = 'www-widgetapi-script';a.src = 'https://s.ytimg.com/yts/jsbin/www-widgetapi-vflIAAJll/www-widgetapi.js';a.async = true;var c = document.currentScript;if (c) {var n = c.nonce || c.getAttribute('nonce');if (n) {a.setAttribute('nonce', n);}}var b = document.getElementsByTagName('script')[0];b.parentNode.insertBefore(a, b);})();
        }
  
    var player,player1;
    var apitype="<?php echo $video['api_type']?>";//Xa0Q0J5tOP0
    var video_id="<?php echo $video['video_id']?>";
    //console.log(apitype);
    function daliplaying(videoid) {
        var VIDEO_ID = videoid; //update this via your CMS technique
    //Create DM Player instance//
        player = DM.player(document.getElementById('video-dis'), {
            video: VIDEO_ID,
            width: "100%", height: "100%",
            params: {autoplay: false, mute: true}
        });
        player1 = DM.player(document.getElementById('popup-video'), {
            video: VIDEO_ID,
            width: "100%", height: "100%",
            params: {autoplay: false, mute: false}
        });

    }
    function onready(){

    }
    function onYouTubeIframeAPIReady() {
        console.log('player');
        if (apitype=="Y"){
            player = new YT.Player('video-dis', {
                videoId: video_id,
                width:'100%',
                height:'100%',
                controls:0,
                /*playerVars: {
                    color: 'white',
                    playlist: 'taJ60kskkns,FG0fTKAqZ5g'
                },*/
                events: {
                    //onReady: initialize
                    
                    
                }
            });
            console.log(player);
            var divHeight = $('#video-dis').width()/16*9;
            $('#video-dis').css({'height':divHeight+'px'});
            var divHeight1 =divHeight-70; 
            //$('#play-list').css('height', divHeight1+'px');
            player1 = new YT.Player('popup-video', {
                        videoId: video_id,
                        
                        /*playerVars: {
                            color: 'white',
                            playlist: 'taJ60kskkns,FG0fTKAqZ5g'
                        },*/
                        events: {
                            //onReady: initialize
                            
                        }
                    });
            player1.mute();
            player.unMute();
        }
        else{
            daliplaying(video_id);
        }
        
    }
   
    
    $(window).resize(function() {
        var divHeight = $('#video-dis').width()/16*9;
        $('#video-dis').css({'height':divHeight+'px'});
        var divHeight1 =divHeight; 
        
        //console.log($('#video-dis').width());
         console.log($(window).width());
        if ($(window).width()<993) {
            $('#similar-pan').css('height','400px');
            $('#play-list').css('height','80%');
            $('#popup-video').css({'width': '100%','height': '300px','bottom': '0%','right': '0%'});
        }
        else{
            $('#similar-pan').css('height', divHeight1+'px');
            $('#play-list').css('height',divHeight1-30+'px');
            $('#popup-video').css({'width': '400px','height': '300px','bottom': '10%','right': '10%'});
        }
    });
    var flag=0;
    $(window).scroll(function(){
        
        var divHeight = $('#video-dis').height();
        
        if ($(window).scrollTop()>divHeight){
            //var player = new YT.Player('video-dis');

            if (flag==0) {
               flag=1;
                // console.log(player.getVideoUrl());
                //console.log($('#video-dis').width());
                if (apitype=="Y"){
                    player1.setVolume(player.getVolume());
                    player.mute();
                    player1.unMute();
                    player1.seekTo(player.getCurrentTime());
                    //console.log(player.getCurrentTime());
                    //console.log(player.getPlayerState());
                    switch(player.getPlayerState()){
                        case -1://unstarted
                            break;
                        case 0: //ended
                            player1.stopVideo();
                            break;
                        case 1://playing
                            player1.playVideo();
                            break;
                        case 2://paused
                            player1.pauseVideo();
                            break;
                        case 3://buffering
                            break;
                        case 5://video cued
                            player1.pauseVideo();
                            break;
                        default:
                            break;
                    }
                    //console.log(player.getVideoEmbedCode());
                }
                else{
                    //dailymotion palyer
                    player1.setVolume(player.volume);
                    player.setMuted(false);
                    player1.setMuted(true);
                    player1.seek(player.currentTime);
                    player.paused?player1.pause():player1.play();
                       
                }


            }
             $('#popup-video').css({
                    'display':'inline'
                });

            //$('#popup-video').html(player.getIframe());
           
        }
        if ($(window).scrollTop()<divHeight){
            
            $('#popup-video').css({
                'display':'none'
                
            });
            if (flag==1){
                flag=0;
                if(apitype=="Y"){
                    player1.mute();
                    player.unMute();
                    player.setVolume(player1.getVolume());
                    player.seekTo(player1.getCurrentTime());
                    //console.log(player.getPlayerState());
                    switch(player1.getPlayerState()){
                        case -1://unstarted
                            break;
                        case 0: //ended
                            player.stopVideo();
                            break;
                        case 1://playing
                            player.playVideo();
                            break;
                        case 2://paused
                            player.pauseVideo();
                            break;
                        case 3://buffering
                            break;
                        case 5://video cued
                            player.pauseVideo();
                            break;
                        default:
                            break;
                    }
                }
                else{
                    player.setVolume(player1.volume);
                    player1.setMuted(false);
                    player.setMuted(true);
                    player.seek(player1.currentTime);
                    player1.paused?player.pause():player.play();
                }
            }
        }
    });
    (function($){
            $(window).on("load",function(){
                
                 var divHeight = $('#video-dis').width()/16*9;
                $('#video-dis').css({'height':divHeight+'px'});
                var divHeight1 =divHeight; 
               if ($(window).width()<993) {
                    $('#similar-pan').css('height','400px');
                    $('#play-list').css('height','370px');
                    $('#popup-video').css({'width': '100%','height': '300px','bottom': '0%','right': '0%'});
                }
                else{
                    $('#similar-pan').css('height', divHeight1+'px');
                    $('#play-list').css('height',divHeight1-30+'px');
                    $('#popup-video').css({'width': '400px','height': '300px','bottom': '10%','right': '10%'});
                }
                //console.log($('#video-dis').width());
                $.mCustomScrollbar.defaults.theme="light-2"; //set "light-2" as the default theme
                
                $(".demo-y").mCustomScrollbar();
                
                $(".demo-x").mCustomScrollbar({
                    axis:"x",
                    advanced:{autoExpandHorizontalScroll:true}
                });
                
                $(".demo-yx").mCustomScrollbar({
                    axis:"yx"
                });
                
                $(".scrollTo a").click(function(e){
                    e.preventDefault();
                    var $this=$(this),
                        rel=$this.attr("rel"),
                        el=rel==="content-y" ? ".demo-y" : rel==="content-x" ? ".demo-x" : ".demo-yx",
                        data=$this.data("scroll-to"),
                        href=$this.attr("href").split(/#(.+)/)[1],
                        to=data ? $(el).find(".mCSB_container").find(data) : el===".demo-yx" ? eval("("+href+")") : href,
                        output=$("#info > p code"),
                        outputTXTdata=el===".demo-yx" ? data : "'"+data+"'",
                        outputTXThref=el===".demo-yx" ? href : "'"+href+"'",
                        outputTXT=data ? "$('"+el+"').find('.mCSB_container').find("+outputTXTdata+")" : outputTXThref;
                    $(el).mCustomScrollbar("scrollTo",to);
                    output.text("$('"+el+"').mCustomScrollbar('scrollTo',"+outputTXT+"advanced:{theme: dark});");
                });
                
            });
        })(jQuery);
        var load_state=0;
        $(function (){
            $.ajax({
                    url:'<?php echo base_url(); ?>Home/getdata',
                    dataType : "json",
                    data: {'video_id': video_id,
                            'api_type':apitype},
                     type:'post',
                    success : function(data) {
                        //console.log(data);
                        // do something
                        var myhtmlcode="";
                        load_state++;
                        for (var i = data.length - 1; i >= 0; i--) {
                            htmlcode=
                            '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+data[i]['video_id']+'/'+data[i]['api_type']+'">'
                                 +'<div class="video-card-body row " style="padding-right: 2px!important,padding-left: 10px!important,width:100%"  >'
                                        +'<div class="col-4 child" style="float:left;" title='+'"'+data[i]['title']+'">'
                                             +'<img src="'+data[i]['image']+'"'+' width="96px" height="54px">'
                                        +'</div>'
                                        +'<div class="col-8 row" style="float:right;padding-left: 0px !important;padding-right:0px!important;">'
                                                +'<div class="col-12 " style="word-break: break-all!important;max-height: 40px;overflow: hidden;">'+data[i]['title']+'</div>'
                                                +'<div class="col-12" style="text-align: center;" >'+data[i]['create_date']+'</div>'
                                        +'</div>'
                                    +'</div>'
                            +'</a>';
                            myhtmlcode+=htmlcode;
                            //console.log(htmlcode);
                            $('#play-list').append(htmlcode);
                        }
                        if (myhtmlcode=="") {
                            $('#mplay-list').append("There is no someting!");
                        }
                        //document.getElementById('#play-list').innerHTML=htmlcode;
                    },
                    error : function(data) {
                        // do something
                        console.log("asdf");
                    }
                });
        });
            $(function (){
            $.ajax({
                    url:'<?php echo base_url(); ?>Home/getdatar',
                    dataType : "json",
                    data: {'video_id': video_id,
                            'api_type':apitype},
                     type:'post',
                    success : function(data) {
                        //console.log(data);
                        // do something
                        if(!player){
                            //window.location.reload();
                        }
                        else{
                            //if ((c_flag1==1)||(c_flag2==1)) {
                                $('#preload-pan').css('display','none');
                           // }
                        }
                        load_state++;
                        var myhtmlcode="";
                        for (var i = data.length - 1; i >= 0; i--) {
                            htmlcode=
                            '<div class="video-card-body col-xs-12 col-sm-6 col-md-4 col-lg-3">'+
                                    '<a class="as" href="'+"<?php echo base_url()?>"+'Home/viewvideo/'+data[i]['video_id']+'/'+data[i]['api_type']+'">'
                                        +'<img src="'+data[i]['image']+'"'+' width="100%" height="auto">'
                                        +'<span class="video-card-title">'+data[i]['title']+'</span>'
                                        +'<span class="video-card-title">'+data[i]['create_date']+'</span>'
                                        +'</a>'
                                    +'</div>';
                            //console.log(htmlcode);
                            $('#bottom-pan').append(htmlcode);
                        }
                        //document.getElementById('#play-list').innerHTML=htmlcode;
                    },
                    error : function(data) {
                        // do something
                        console.log("asdf");
                    }
                });
        });
            $(function (){
            $.ajax({
                    url:'<?php echo base_url(); ?>Home/commentcall',
                    dataType : "json",
                    data: {'video_id': video_id
                            },
                     type:'post',
                    success : function(data) {
                        console.log(data);
                        // do something
                        var myhtmlcode="";
                        for (var i = data.length - 1; i >= 0; i--) {           
                            htmlcode=
                            '<label><i class="fa fa-user"></i>'+data[i]['comment_user']+'</label><br>'+
                            '<label><i class="fa fa-calendar"></i>'+data[i]['create_date']+'</label>'+
                            '<p class="textc">'+data[i]['comment_data']+'</p>';
                            //console.log(htmlcode);
                            $('#commet_c').append(htmlcode);
                        }
                        //document.getElementById('#play-list').innerHTML=htmlcode;
                    },
                    error : function(data) {
                        // do something
                        console.log("asdf");
                    }
                });
        });
    if(load_state==2){
        if(!player){
            //window.location.reload();
        }
                        else{
                            //if ((c_flag1==1)||(c_flag2==1)) {
                                $('#preload-pan').css('display','none');
                           // }
                        }
    }
    
    $(function(){
        $("#submit1").click(function(){
            $.ajax({
                    url:'<?php echo base_url(); ?>Home/commentsave',
                    dataType : "json",
                    data: {'video_id': video_id,
                            'user':$('#fname').val(),
                            'email':$('#email').val(),
                            'comment_data':$('#subject').val()
                        },
                     type:'post',
                    success : function(data) {
                        //console.log(data);
                        // do something
                        alert("Success Submit!!!");
                        //document.getElementById('#play-list').innerHTML=htmlcode;
                    },
                    error : function(data) {
                        // do something
                        console.log("asdf");
                    }
                });
            
        });
    });
</script>