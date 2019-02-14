loaded([".js"], init);

function init() {
    
    loaded([".md-typeset__table"], responseTab, true);
    loaded(["#faq"], initFAQItemCollapse, false);
    setNavLinks();
    hashScrolling();
    footerI18nLink();
    setTimeout(function() {
        copyCode();
    }, 1000);
    setTimeout(function() {
        codeBlockExtend();
        // setContentHeight();
    }, 2000);
}



function betweenWidth(min, max, callback){
    var vw = $(window).width();
    max = max ? max : 999999;
    if( min < vw && vw < max )
    {
        callback();
    }
}

function loaded(selectors, callback, flag) {
    function goNext() {
        if( isLoaded(selectors) )
        {
            callback();
        }
        else
        {
            if( flag )
            {
                setTimeout(goNext, 100);
            }
        }
    }
    goNext();
}

function isLoaded(selectors) {
    var eLen = 0;
    var sLen = selectors.length;
    for( var i = 0; i < sLen; i++ )
    {
        if( $(selectors[i]).length > 0 )
        {
            eLen++;
        }
    }
    if( eLen === sLen )
    {
        return true;
    }
    return false;
}

/**
 * 代码区域展开
 */
function codeBlockExtend() {
    var $codeBlocks = $(".code-block");
    $codeBlocks.each(function(i, e){
        var $codeBlock = $(e);
        var $content = $codeBlock.find("pre");
        var $extendBtn = $('<div class="extend-btn" ></div>');
        if( $content.height() > 204 )
        {
            $codeBlock.after($extendBtn);
            $extendBtn.on("click", null, function(){
                if( $codeBlock.hasClass("extend") ) 
                {
                    $codeBlock.removeClass("extend");
                }
                else
                {
                    $codeBlock.addClass("extend");
                }
            });
        }
    });
}

/**
 * 点击链接后滚动到目标锚点
*/
function hashScrolling(){
    $("body").on("click", "a[href*='#']:not([href='#'])", function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            var hash = this.hash;
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) 
            {
                $('html,body').animate({
                    scrollTop: target.offset().top - (target.height() + 37)
                }, 900, function(){
                    var id = target.attr("id"); 
                    target.attr("id", ""); 
                    location.hash = hash;
                    target.attr("id", id); 
                });
                return false;
            }
        }
    });
}

/**
 * 代码块处理 
 * 1. copy 按钮
 * 2. 代码高亮着色
 */
function copyCode(){
    $("pre").wrap('<div class="code-block"></div>');
    $(".code-block").each(function(i, e){
        var $e = $(e);
        var $code = $e.find("code");
        var id = "target-" + i + "-code-text";
        $code[0].id = id;
        $e.find("pre").addClass("prettyprint");
        $e.before('<div data-clipboard-target="' + id + '" class="copy-btn">Copy</div>');
    });
    PR.prettyPrint();


    if(window.clipboardData)
    {
        //ie
        var $copyBtn = $(".copy-btn");
        $copyBtn.on("click", null, function(){
            var $this = $(this);
            var code = $this.next().find("code").text(); 
            window.clipboardData.setData('text',code); 
            alert("Copied text to clipboard: \n\n" + code );
        });
    }
    else
    {
        var client = new ZeroClipboard($(".copy-btn"));
        client.on( "ready", function(readyEvent){
            client.on( "aftercopy", function(event){
                alert("Copied text to clipboard: \n\n" + event.data["text/plain"] );
            });
        });
    }
    $(".code-title").each(function(i, item){
        var $item = $(item);
        $item.parent().replaceWith($item);
    });
}

/**
 * response 区域的表格聚合
 */
function responseTab(){
    var $start = $("#response");
    var $tables = $start.nextAll().filter(".md-typeset__table");
    var $tabs = $start.nextAll().filter("p").children().filter(".tab-title");
    var $tabP = $tabs.parents().filter("p");
    
    var $group = $tables.splice(1, $tables.length - 2);
    var $groupTab = $tabs.splice(1, $tabs.length - 2);

    $tables.wrapAll('<div class="response-tabs-content"></div>');
    $(".response-tabs-content").wrapAll('<div class="response-tabs"></div>');
    $(".response-tabs").prepend('<div class="response-tabs-tabs"></div>');
    var $tabWrap = $(".response-tabs-tabs");
    
    
    $tables.each(function(i, e){
        $tabWrap.append('<div class="response-tabs-tabs-item">'+ $tabs.eq(i).text() +'</div>');
        $tabs.eq(i).remove();
    });
    var $data = $tables.eq(0);
    var $dataTable = $data.find("table").eq(0);
    // var minWidth = $data.width();
    // var cw = 0;
    for( var i = 0; i < $group.length; i++ )
    {
        var $groupItem = $($group[i]).find("table");
        var $groupTabItem = $($groupTab[i]);
        var $tbody = $dataTable.find("tbody");
        $tbody.append('<tr><td colspan="3" class="sub-table-title">'+ $groupTabItem.text() +'</td></tr>')
        $groupItem.find("tbody tr").each(function(i, item){
            $tbody.append($(item).clone());
        });
        // $groupItem.css({
        //     "min-width": "calc(" + minWidth + "px - 3.2rem)"
        // });

        // var $groupTabItem = $($groupTab[i]);
        // var $GroupWrapper = $(".response-tabs-content .md-typeset__table").eq(0);
        // var $ItemWrapper = $('<div class="table-group-item-wrapper" ></div>');
        // cw = $groupItem.width();
        // $groupTabItem.width(cw);
        // $ItemWrapper.append($groupTabItem.clone());
        // $ItemWrapper.append("<br/>");
        // $ItemWrapper.append($groupItem.clone());
        // $GroupWrapper.append($ItemWrapper);
        
        $groupItem.parent().remove();
        $groupTabItem.parent().remove();
    }
    // if( cw > minWidth )
    // {
    //     $data.find("table").eq(0).width(cw);
    // }
    function addActive(index){
        $(".response-tabs-tabs-item").eq(index).addClass("active");
        $(".response-tabs-content>.md-typeset__table").eq(index).addClass("active");
    }
    $(".response-tabs-tabs-item").on("click", null, function(){
        var $this = $(this);
        var index = $this.index();
        $(".response-tabs .active").removeClass("active");
        addActive(index);
    });
    addActive(0);
}

/**
 * 导航链接
 * 
 */

function setNavLinks(){
    $("a[title=Playground]").attr("href", "http://192.168.0.91/tecdoc");
}

/**
 * 内容高度
 */

function setContentHeight(){
    var $nav = $(".md-sidebar.md-sidebar--primary");
    var height = $nav.offset().top + $nav.height() + 140;
    console.log(height);
    $("main.md-main").height(height);
}


/**
 * FAQ页面项目折叠
 */
function getHeight($el){
    var $clone = $el.clone();
    var $temp = $('<div class="temp-div"><div>');
    $clone.css("height", "");
    $temp.append($clone);
    $el.after($temp);
    var h = $temp.height();
    $temp.remove();
    return h;
}
function initFAQItemCollapse(){
    var $items = $("#faq~h2");
    $items.each(function(i, item){
        var $item = $(item);
        var $content = $item.nextUntil("h2");
        $content.wrapAll('<div class="collapse-item-content" ></div>');
        var $wrap = $content.parent();
        $item = $item.add($wrap);
        $item.wrapAll('<div class="collapse-item-wrapper" ></div>');
    });
    var $wraps = $(".collapse-item-wrapper");
    function closeItem($el){
        $el.removeClass("open");
        $el.find(".collapse-item-content").stop().animate({
            "height": "0px"
        }, 300);
    }
    function openItem($el, jump){
        $el.addClass("open");
        var $content = $el.find(".collapse-item-content");
        var $title = $el.find("h2");
        var id = $title.attr("id");
        function setHash($title, hash){
            $title.attr("id", "");
            location.hash = hash;
            $title.attr("id", hash);
        }
        $el.find(".collapse-item-content").stop().animate({
            "height": getHeight($content)
        }, 300, function(){
            if( jump )
            {
                $('html,body').animate({
                    scrollTop: $el.offset().top - $title.height()
                }, 300, function(){
                    setHash($title, id);
                });
            }
            else
            {
                setHash($title, id);
            }
        }); 
    }
    function openItemWithHash($wraps, jump){
        var initIndex = $(location.hash).parent().index() - 1;
        initIndex = initIndex >= 0 ? initIndex : 0;
        closeItem($wraps);
        openItem($wraps.eq(initIndex), jump);
    }
    $items.on("click", null, function(){
        var $item = $(this);
        var $wrap = $item.parent();
        var hasClass = $wrap.hasClass("open");
        closeItem($wraps);
        if( !hasClass )
        {
            openItem($wrap, false);
        }
    });
    var initIndex = $(location.hash).parent().index() - 1;
    initIndex = initIndex >= 0 ? initIndex : 0;
    if( initIndex === 0 )
    {
        location.hash = $wraps.eq(0).attr("id");
    }
    else
    {
        openItemWithHash($wraps, true);
    }
    $(window).on("hashchange", null, function(){
        openItemWithHash($wraps, false);
    });
}

function footerI18nLink(){
    var $links = $("footer li a");
    $links.each(function(i, link){
        var href = link.href;
        var curHref = location.href;
        var langSegReg = /\/(:?(zh)|(en))\//;
        var curLangSeg = langSegReg.exec(curHref)[0];
        var newLangSeg = langSegReg.exec(href)[0];
        var newHref = curHref.replace(curLangSeg, newLangSeg);
        link.href = newHref;
    });
}