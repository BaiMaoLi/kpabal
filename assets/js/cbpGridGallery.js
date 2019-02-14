;( function( window ) {

    'use strict';

    var docElem = window.document.documentElement,
        transEndEventNames = {
            'WebkitTransition': 'webkitTransitionEnd',
            'MozTransition': 'transitionend',
            'OTransition': 'oTransitionEnd',
            'msTransition': 'MSTransitionEnd',
            'transition': 'transitionend'
        },
        transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
        support = {
            transitions : Modernizr.csstransitions,
            support3d : Modernizr.csstransforms3d
        };

    function extend( a, b ) {
        for( var key in b ) {
            if( b.hasOwnProperty( key ) ) {
                a[key] = b[key];
            }
        }
        return a;
    }

    function CBPGridGallery( el, options ) {
        this.el = el;
        this.options = extend( {}, this.options );
        extend( this.options, options );
        this._init();
    }

    $.urlParam = function(){
        var pathexp = /\/\/[\w.-]*(?:\/([^?]*))/;
        var match = pathexp.exec(window.location.href);
        if (match != null && match.length > 1){
            var pair = match[1].split('/');
            return pair[1];
        }

        return "";
    };


    CBPGridGallery.prototype.options = {
    };

    CBPGridGallery.prototype._init = function() {
        // main grid
        this.grid = this.el.querySelector( 'section.grid-wrap > ul.grid' );
        // main grid items
        this.gridItems = [].slice.call( this.grid.querySelectorAll( 'li:not(.grid-sizer)' ) );
        // items total
        this.itemsCount = this.gridItems.length;
        // init masonry grid
        this._initMasonry();
        // init events
        this._initEvents();
    };

    CBPGridGallery.prototype._initMasonry = function() {
        var grid = this.grid;
        imagesLoaded( grid, function() {
            new Masonry( grid, {
                itemSelector: 'li',
                columnWidth: grid.querySelector( '.grid-sizer' )
            });
        });


    };

    CBPGridGallery.prototype._initEvents = function() {

        var grid = this.grid;
        var append = $( 'section.grid-wrap > ul.grid' );


        $('ul.tags').on('click','li',function() {
            $('.tags li').removeClass("active");
            $(this).addClass("active");

            var tags = $('a',this).data('tags');
            sessionStorage["start"] = 0;



            imagesLoaded(append, function(){
                append.masonry( {
                    columnWidth: grid.querySelector( '.grid-sizer' ),
                    itemSelector: 'li',
                    transitionDuration: '0.7s',
                });

            });

            if(tags>0) {
                $.ajax({
                    dataType: "html",
                    type: "POST",
                    url: "/talky/view_list/"+tags,
                    data: {keyword: tags},
                    success: function (response) {
                        $('#grid').empty();
                        $(append).append(response);
                        $(append).masonry('reloadItems');
                        $(append).masonry('layout');

                    }, error: function (e) {
                        alert('Unfortunately a network error occurred. Please try again.');
                        return false;
                    }
                });

                $('html, body').animate({scrollTop: 300}, 'slow');
            }

        });
        $('select.tags').on('change',function() {
            $('.tags li').removeClass("active");
            //$(".tags li").addClass("active");

            var tags = $(this).val();
            if(tags==""){
                location.href="http://www.kpabal.com/talky";
            }else {
                sessionStorage["start"] = 0;


                imagesLoaded(append, function () {
                    append.masonry({
                        columnWidth: grid.querySelector('.grid-sizer'),
                        itemSelector: 'li',
                        transitionDuration: '0.7s',
                    });

                });

                if (tags > 0) {
                    $.ajax({
                        dataType: "html",
                        type: "POST",
                        url: "/talky/view_list/" + tags,
                        data: {keyword: tags},
                        success: function (response) {
                            $('#grid').empty();
                            $(append).append(response);
                            $(append).masonry('reloadItems');
                            $(append).masonry('layout');

                        }, error: function (e) {
                            alert('Unfortunately a network error occurred. Please try again.');
                            return false;
                        }
                    });

                    $('html, body').animate({scrollTop: 300}, 'slow');
                }
            }
        });

        var win = $(window);
        var loadcheck;
        $(document).scroll(function() {

            imagesLoaded(append, function(){

                append.masonry( {
                    columnWidth: grid.querySelector( '.grid-sizer' ),
                    itemSelector: 'li',
                    transitionDuration: '0.6s',
                });

            });

            /*var percent = Math.ceil(($(window).scrollTop()/ ($(document).height()-$(window).height())) * 100);
             console.log(percent);

             if (percent == 85) {*/

            if (loadcheck)
                return false;

            if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.95){


                loadcheck = true;
                sessionStorage["start"] = (+sessionStorage["start"]) + 20;
                var snoteid = $.urlParam();


                $.ajax( {
                    type: "POST",
                    url: "/talky/load",
                    data: { },
                    dataType: "html",
                    success: function (html) {

                        var $content = $(html);

                        $( append ).append( $content ).masonry('appended',$content);
                        $( append ).masonry( 'reloadItems' );
                        $( append ).masonry( 'layout' );
                        loadcheck = false;

                    },
                    error:function(e) {
                        alert('Network error occurred. Please try again.');
                        return false;
                    }
                });

                //setTimeout(function(){ $('.loader').fadeOut(); 	console.log("hide_7000");}, 7000);

            }



        });


    };

    window.CBPGridGallery = CBPGridGallery;

})( window );