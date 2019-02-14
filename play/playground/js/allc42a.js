//var TECDOC_MANDATOR = Number(sessionStorage.getItem('providerIdValue'));
var TECDOC_MANDATOR = 21010;
//var TECDOC_MANDATOR = <?php echo json_encode("21010", JSON_HEX_TAG); ?>; //Don't forget the extra semicolon!
//var TECDOC_MANDATOR = '<?php include("provajder.php"); echo $provajder; ?>';
var COUNTRY = "RS";
var LANGUAGE = "sr";
var LINKINGTARGETYPE = "P";
var CARTYPE = "P";

var BRANDS = [];

var MANUID = "";
var MODELID = "";
var CARID = "";
var BRANDIDS = [];
var ASSEMBLYGROUPNODEID = "";

var ARTICLESIDS = "";
var ASSIGNEDARTICLESIDS = "";
var PAGE = 1;

var assignedArticleId;
// Display any error that occurs:
// window.onerror = function(message, file, lineNumber) {
//     alert(file + ' (line: ' + lineNumber + '): ' + message);
//     return true;
// };

// Start code highlighter
// hljs.initHighlightingOnLoad();

/*
*	This function finds all possible articles for the query from TecDoc
*	It returns an array with the TecDoc ID of the article
*	Query can be article number, oen number, ean number and others
*/

function searchArticleByNumbers() {
    var search = $(".search input").val();
    var numberType = $("select.numberType option:selected").val();

    if (PAGE == 1) {
        $(".result").html('<span class="loading"></span>');
    }

    var request = {
            "articleCountry": COUNTRY,
            "articleNumber": search,
            "lang": LANGUAGE,
            "numberType": numberType,
            "provider": TECDOC_MANDATOR,
            "searchExact": true,
            "sortType": 1
    };
    request = toJSON(request);
    tecdocToCatPort["getArticleDirectSearchAllNumbersWithState"](request, gearchArticleByNumbers);
}
function gearchArticleByNumbers(response) {

			ARTICLESIDS = response.data.array;

            if (ARTICLESIDS) {

                totalnumber = 'Ukupan broj: <strong>' + ARTICLESIDS.length + '</strong>';
                $(".totalnumber").html( totalnumber );

                LimitArticlesFromDirectSearchResult();
            } else {
            	var info = '<div class="alert alert-danger" role="alert">Po ovim kriterijumima pretrage nije pronadjen nijedan artikal. Molimo pokusajte ponovo.</div>';
				$(".result").html( info );
            }

}

$('.search input[type="text"]').keyup(function(){
    var len = $(this).val().length;
    if(len !== 0){
        $('.search button').css({'background':'#003058','border':'1px solid #003058','cursor':'pointer'}).attr('disabled',false);
        // $('.search button').click(function(){})
    }else{
        $('.search button').css({'background':'#ccc','border':'1px solid #ccc','cursor':'default'}).attr('disabled',true);
    }
})
$('.search input[type="text"]').on('paste',function(e){
    var el = $(this)
    setTimeout(function(){
        var text = $(el).val();
        var len = el.val().length;
        if(len !== 0){
            $('.search button').css({'background':'#003058','border':'1px solid #003058','cursor':'pointer'}).attr('disabled',false);
            // $('.search button').click(function(){})
        }else{
            $('.search button').css({'background':'#ccc','border':'1px solid #ccc','cursor':'default'}).attr('disabled',true);
        }
    },100)
})
if($('.search button').css('backgroundColor') != 'rgb(1, 52, 123)'){
    $('.search button').css('cursor','default').attr('disabled',true);
}
$('.search button').click(function(){
  clearGlobalVariable();
  removeNewIcon();
  searchArticleByNumbers();
})
// if($('.search button').css('backgroundColor') != 'rgb(1, 52, 123)'){
//         $('.search button').css('cursor','default').attr('disabled',true);
// }
// $('.search button').click(function(){
//   clearGlobalVariable();
//   removeNewIcon();
//   searchArticleByNumbers();
// })


function LimitArticlesFromDirectSearchResult() {

    LimitedIds = [];

    number_articles = ARTICLESIDS.length;
    max_articles_per_page = 5;
    number_pages = Math.ceil( number_articles / max_articles_per_page );

    startArticle = (PAGE-1)*max_articles_per_page;
    endArticle = PAGE*max_articles_per_page;

// alert("Number of articles: " + number_articles + "; Number pages: " + number_pages + "; Start Article: " + startArticle + ";" + endArticle );
    var index;
    for (index = 0; index < ARTICLESIDS.length; ++index) {
        if (index >= startArticle && index < endArticle) {
            LimitedIds.push( ARTICLESIDS[index]['articleId'] );
        }
    }

    if (number_articles <= endArticle ) {
    	// Set the page back to one for the next search or filter
        PAGE = 1;
    } else {
        PAGE++;
    }

    getDirectArticlesByIds6(LimitedIds);
}

function getDirectArticlesByIds6(articleIds) {

    var request = {
        "articleCountry": COUNTRY,
        "articleId": {
            "array": articleIds
        },
        "attributs": true,
        "basicData": true,
        "documents": true,
        "eanNumbers": true,
        "immediateAttributs": true,
        "immediateInfo": true,
        "info": true,
        "lang": LANGUAGE,
        "mainArticles": true,
        "normalAustauschPrice": true,
        "oeNumbers": true,
        "prices": true,
        "replacedByNumbers": true,
        "replacedNumbers": true,
        "thumbnails": true,
        "usageNumbers": true,
        "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getDirectArticlesByIds6"](request, setDirectArticlesByIds6);
}
function setDirectArticlesByIds6(response){
            var html = '';

            var array = response.data.array;

            for(var x in array) {
                html += '<div id="' + x + '" class="article">';
        //        html += '<div class="artikelnummer">' + array[x]['directArticle']['articleNo'] + ' (articleId: ' + array[x]['directArticle']['articleId'] + ')</div>';
                addArticleName = '';
                if(array[x]['directArticle']['articleAddName']) {
                    addArticleName = ' - ' + array[x]['directArticle']['articleAddName'];
                }
                html += '<h1 class="title">' + array[x]['directArticle']['brandName'] + ': '+ array[x]['directArticle']['articleName'] + addArticleName + ' ';
                html += '</h1>';

                html += '<div class="leftside pull-left">';
                html += '<div>';

                if ( array[x]['articleDocuments']['array'] ) {
                    var docTypeId = array[x]['articleDocuments']['array'][0]['docTypeId'];
                    if (docTypeId == 5 || docTypeId == 1) {
                        var docid =  array[x]['articleDocuments']['array'][0]['docId'];

                        // var src = 'image.php?docId=' + docid + '&flag=1';
                        var src = 'https://webservice.tecalliance.services/pegasus-3-0/documents/100002/'+docid+'/1';
                        html += '<img src="' + src + '">';
                    } else {
                        html += '<img src="img/no-image.jpg">';
                    }
                } else {
                    html += '<img src="img/no-image.jpg">';
                }
                html += '</div>';

                // Get logo from brand
                brandNo = array[x]['directArticle']['brandNo'];
                brandLogoID = getBrandLogoId(brandNo);

                // var src_logo = 'logo.php?brandLogoID=' + brandLogoID;
                var src_logo = 'https://webservice.tecalliance.services/pegasus-3-0/documents/100002/' + brandLogoID;

                html += '<div class="brandlogo"><img src="' + src_logo + '"></div>';

                // Bootstrap modal button for vehicle selection
	            html += '<br><button type="button" id="' + array[x]['directArticle']['articleId'] + '" class="btn btn-success btn-xs load_assigned_vehicles" data-toggle="modal" data-target="#modal_tecdoc">Povezana vozila <span class="glyphicon glyphicon-link" aria-hidden="true"></span></button>';
                html += '<br><a href="http://automehanika.rs"><img class="automehanika_logo" src="../images/automehanika_logo.png" /></a>';
                html += '</div>';

                html += '<div class="description pull-left">';
                html += '<div class="artikelnummer"><span>Br. artikla:</span>' + array[x]['directArticle']['articleNo'] + '<br><span>articleId:</span>' + array[x]['directArticle']['articleId'] + '</div>';

                var attributes = array[x]['articleAttributes']['array'];

				html_attr = '';
                for(var i in attributes) {
                    if (attributes[i]['attrValue']) {
                        html_attr += '<div>' + attributes[i]['attrName'] + ': <strong>' + attributes[i]['attrValue'] + '</strong></div>';
                    } else {
                        html_attr += '<div><strong>' + attributes[i]['attrName'] + '</strong></div>';
                    }
                }

                var ean =  array[x]['eanNumber']['array'];

                html_ean = '';
                for(var j in ean) {
                    html_ean += '<div>' + ean[j]['eanNumber'] + '</div>';
                }

                var oen =  array[x]['oenNumbers']['array'];

                html_oen = '';
                for(var k in oen) {
                    html_oen += '<div>' + oen[k]['brandName'] + ' - ' + oen[k]['oeNumber'] + '</div>';
                }

                artID = array[x]['directArticle']['articleId'];

                html += createTab(artID, html_attr, html_ean, html_oen);
                html += '<br><a href="http://automehanika.rs"><img class="automehanika_logo" src="../images/automehanika_logo.png" /></a>';
                html += '</div>';
                html += '<div style="clear:both"></div>';
                html += '</div>';

            }

            if ( $(".articlelist").length > 0 ) {
                // No need to do anything!
            } else {
                // If the article wrapper doesn't exist, dann add into inside
                $(".result").html('<div class="articlelist"></div>');
            }

            $(".articlelist").append(html);
            $(".column_middle .loading").remove();

            $( ".load_assigned_vehicles" ).click(function() {
            	removeNewIcon();
            	articleId = $(this).attr("id");
				getArticleLinkedAllLinkingTarget3(articleId);
			});

            if (PAGE > 1) {
                // If more articles exists, then show an icon to button more
                $(".result .loading").remove();
                $(".result").after( '<button type="button" class="btn btn-primary loadArticles">U&#269;itaj jo&#353; artikala</button>' );

                $( ".loadArticles" ).click(function() {
                	$(this).after('<span class="loading"><span>');
                    $(this).remove();
                    LimitArticlesFromDirectSearchResult();
                });
            }

}

function searchVehicleByVIN() {
    var vin = $(".vin input").val();
    removeNewIcon();

    $(".result").html('<span class="loading"></span>');

    var request = {
        "country": COUNTRY,
        "lang": LANGUAGE,
        "vin": vin,
        "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getVehiclesByVIN"](request, setVehiclesByVIN);
}
function setVehiclesByVIN(response){

            matchingVehiclesCount = response.data.matchingVehiclesCount;

            if ( matchingVehiclesCount == 1 ) {

                MANUID = response.data.matchingVehicles.array[0].manuId;
                MODELID = response.data.matchingVehicles.array[0].modelId;
                CARID = response.data.matchingVehicles.array[0].carId;

				$("select.manufacturers option[value="+MANUID+"]").prop("selected", "selected");
				getModell();
				getVehicle();
                getVehicleByCarId();
            } else {

                // If there are no matching vehicles, then check array and send to the next function
                matchingManufacturers = [];
                matchingModels = [];

                if ( response.data.matchingModels.array ) {
                    matchingModels = response.data.matchingModels.array;
                }

                if ( response.data.matchingManufacturers.array ) {
                    matchingManufacturers = response.data.matchingManufacturers.array;
                }

                displayMatchingResultsFromVINSearch(matchingManufacturers, matchingModels);
            }

}


$('.vin input[type="text"]').keyup(function(){
    var len = $(this).val().length;
    if(len !==0 ){
        $('.vin button').css({'background':'#003058','border':'1px solid #003058','cursor':'pointer'}).attr('disabled',false);
    }else{
        $('.vin button').css({'background':'#ccc','border':'1px solid #ccc','cursor':'default'}).attr('disabled',true);
    }
})
$('.vin input[type="text"]').on('paste',function(e){
    var el = $(this)
    setTimeout(function(){
        var text = $(el).val();
        var len = el.val().length;
        if(len !== 0){
            $('.vin button').css({'background':'#003058','border':'1px solid #003058','cursor':'pointer'}).attr('disabled',false);

        }else{
            $('.vin button').css({'background':'#ccc','border':'1px solid #ccc','cursor':'default'}).attr('disabled',true);
        }
    },100)
})
if($('.vin button').css('backgroundColor') != 'rgb(1, 52, 123)'){
    $('.vin button').css('cursor','default').attr('disabled',true);
}
$('.vin button').click(function(){
    clearGlobalVariable();
    searchVehicleByVIN();
})
function displayMatchingResultsFromVINSearch(matchingManufacturers, matchingModels) {

    html = "<p><strong>Nismo prona&#353;li!</strong> Molimo izaberite sa liste ispod:</p>";

    arrayManufacturer = [];
    if (matchingManufacturers.length > 0) {

        html += '<p>Marka:</p>';
        html += '<p>';
        for(var k in matchingManufacturers) {
            html += '<a class="btn btn-default matchManufacturer" href="' + matchingManufacturers[k].manuId + '" role="button">' + matchingManufacturers[k].manuName + '</a>';
            if( jQuery.inArray( matchingManufacturers[k].manuName, arrayManufacturer ) == -1 ){
                arrayManufacturer[ matchingManufacturers[k].manuId ] = matchingManufacturers[k].manuName;
            }
        }
        html += '</p>';

    }

    if (matchingModels.length > 0) {
            html += '<p>Model:</p>';

        for(var k in matchingModels) {

            html += '<a class="btn btn-default matchModels" href="' + matchingModels[k].manuId + '|' + matchingModels[k].modelId + '" role="button">' + arrayManufacturer[ matchingModels[k].manuId ] + " " + matchingModels[k].modelName + '</a>';
        }
    }

    $(".result").html(html);

    $(".matchManufacturer").click(function(){
        MANUID = $(this).attr("href");
        $("select.manufacturers option[value="+MANUID+"]").prop("selected", "selected");
        getModell();
        return false;
    });

    $(".matchModels").click(function(){
        string = $(this).attr("href");
        array = string.split('|');

        MANUID = array[0];
        MODELID = array[1];
        $("select.manufacturers option[value="+MANUID+"]").prop("selected", "selected");
        getModell();
        getVehicle();

        return false;
    });

}

function getManufactures() {

    $("select.manufacturers").next().toggleClass("loading");

    var request = {
        "getManufacturers":{
            "country" : COUNTRY,
            "lang" : LANGUAGE,
            "linkingTargetType": LINKINGTARGETYPE,
            "provider" : TECDOC_MANDATOR
        }
    };
    request = toJSON(request);

    getdata(request, setManufacturers);
}
function setManufacturers(response) {

            for(var k in response.data.array) {
//                console.log(k, response.data.array);
                $("select.manufacturers").append("<option value='"+response.data.array[k]['manuId']+"'>"+response.data.array[k]['manuName']+"</option>");
            }

            $( "select.manufacturers" ).attr("disabled", false);
            $( "select.manufacturers" ).next().toggleClass("loading");

            $( "select.manufacturers" ).change(function() {
                if ($(this).val() != "") {
                	MANUID = $(this).val();
                	removeNewIcon();
                    getModell();
                }
            });

}

function getModell() {
    $("select.modell").html("<option value=''>- Izaberite model -</option>").attr("disabled", true);
    $("select.modell").next().toggleClass("loading");
    $("select.vehicle").html("<option value=''>- Izaberite tip -</option>").attr("disabled", true);

    var request = {
            "country": COUNTRY,
            "lang": LANGUAGE,
            "linkingTargetType": LINKINGTARGETYPE,
            "manuId": MANUID,
            "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getModelSeries"](request, setModell);
}
function setModell(response){

            var option = "";

            for(var k in response.data.array) {
                var fromTXT = '';
                var toTXT = '';

                if (response.data.array[k]['yearOfConstrFrom']) {
                    var fromTXT = response.data.array[k]['yearOfConstrFrom'];
                    fromTXT = fromTXT.toString();
                }
                if (response.data.array[k]['yearOfConstrTo']) {
                    var toTXT = response.data.array[k]['yearOfConstrTo'];
                    toTXT = toTXT.toString();
                }

                option += "<option value='" + response.data.array[k]['modelId'] + "'>";
                option += response.data.array[k]['modelname'] + ", ";
                option += fromTXT.substring(4,6) + "/" + fromTXT.substring(2,4);
                if(toTXT != '') {
                    option += " until ";
                    option += toTXT.substring(4,6) + "/" + toTXT.substring(2,4);
                } else {
                    option += " until now";
                }
                option += "</option>";
            }

            $("select.modell").append(option).attr("disabled", false);

            // If the event was fired without changing the select field, then select the right element from global value
            // Search by Vin Number functions fires events without changing select fields
			if ( $("select.modell option:selected").val() != MODELID ) {
				$("select.modell option[value=" + MODELID + "]").prop("selected", "selected");
			}

            $("select.modell").next().toggleClass("loading");

}

$( "select.modell" ).change(function() {
	MODELID = $(this).val();
	removeNewIcon();
    getVehicle();
});

function getVehicle() {
    $("select.vehicle").html("<option value=''>- Izaberite tip -</option>").attr("disabled", true);
    $("select.vehicle").next().toggleClass("loading");

    var request = {
        "countriesCarSelection": COUNTRY,
        "lang": LANGUAGE,
        "carType": CARTYPE,
        "manuId": MANUID,
        "modId": MODELID,
        "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getVehicleIdsByCriteria"](request, setVehicle);
}
function setVehicle(response){

            var option = "";

            for(var k in response.data.array) {

                option += "<option value='" + response.data.array[k]['carId'] + "'>";
                option += response.data.array[k]['carName'];
                option += "</option>";

            }

            $( "select.vehicle" ).append(option).attr("disabled", false);
            $( "select.vehicle" ).next().toggleClass("loading");

            // If the event was fired without changing the select field, then select the right element from global value
            // Search by Vin Number functions fires events without changing select fields
            if ( $("select.vehicle option:selected").val() != CARID ) {
                $("select.vehicle option[value=" + CARID + "]").prop("selected", "selected");
            }

}

$( "select.vehicle" ).change(function() {
	CARID = $(this).val();
	removeNewIcon();
    getVehicleByCarId();
});


function getVehicleByCarId() {
    $("div.result").html("");

    var request = {
        "articleCountry": COUNTRY,
        "countriesCarSelection": COUNTRY,
        "country": COUNTRY,
        "lang": LANGUAGE,
        "carIds": {
            "array": [
                CARID
            ]
        },
        "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getVehicleByIds3"](request, setVehicleByCarId);
}
function setVehicleByCarId(response){

            var vd = response.data.array[0]['vehicleDetails'];

            var vehicle = vd.manuName + " " + vd.modelName + ", " + vd.cylinderCapacityCcm + " cm<sup>3</sup>, " + vd.powerHpFrom + " PS, " + vd.powerKwFrom + " KW, ";

                var fromTXT = '';
                var toTXT = '';

                if (vd.yearOfConstrFrom) {
                    var fromTXT = vd.yearOfConstrFrom;
                    fromTXT = fromTXT.toString();
                }
                if (vd.yearOfConstrTo) {
                    var toTXT = vd.yearOfConstrTo;
                    toTXT = toTXT.toString();
                }

                vehicle += "Construction year: ";
                vehicle += fromTXT.substring(4,6) + "/" + fromTXT.substring(2,4);
                if(toTXT != '') {
                    vehicle += " until ";
                    vehicle += toTXT.substring(4,6) + "/" + toTXT.substring(2,4);
                } else {
                    vehicle += " until today";
                }

            $(".selectedVehicle").remove();

            // var txt = '<div class="alert alert-info selectedVehicle" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' + vehicle + '</div>';
            var txt = '<div class="alert alert-danger selectedVehicle" role="alert"><button type="button" class="close" data-dismiss="danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>Poni&#353;ti filter </div>';
            $(".column_left").prepend(txt);

            $(".selectedVehicle button").click(function() {
			  removeSelectedVehicle();
			});

            clearGlobalVariable();
			getArticleIdsWithState();

}

function removeSelectedVehicle() {
	MANUID = "";
	MODELID = "";
	CARID = "";

	BRANDIDS = [];
	ASSEMBLYGROUPNODEID = "";

	ASSIGNEDARTICLESIDS = "";
	PAGE = 1;

	$("select.manufacturers option:selected").prop("selected", false);
	$("select.manufacturers option:first").prop("selected", "selected");

	$("select.modell option:selected").prop("selected", false);
	$("select.modell option:first").prop("selected", "selected");

	$("select.vehicle option:selected").prop("selected", false);
	$("select.vehicle option:first").prop("selected", "selected");

	$("select.brands option:selected").prop("selected", false);
	$("select.brands option:first").prop("selected", "selected");

	$('.assemblyGroup .tree').jstree("deselect_all");

	$(".selectedVehicle").remove();
    $("button.loadArticles").remove();

    $(".totalnumber").html( "" );

}

function clearGlobalVariable() {
    ASSIGNEDARTICLESIDS = "";
    PAGE = 1;
    $(".totalnumber").html( "" );
    $("button.loadArticles").remove();
}

function getBrands() {

    $("select.brands").next().toggleClass("loading");

    var request = {
        "getAmBrands":{
            "articleCountry" : COUNTRY,
            "lang" : LANGUAGE,
            "provider" : TECDOC_MANDATOR
        }
    };

    request = toJSON(request);

    getdata(request, setBrands);
}
function setBrands(response){
        	BRANDS = response.data.array;
            var resultArray = response.data.array;

            resultArray.sort(function(a,b) {
                if ( a.brandName < b.brandName )
                    return -1;
                if ( a.brandName > b.brandName )
                    return 1;
                return 0;
            } );

            for(var k in resultArray) {
                $("select.brands").append("<option value='"+resultArray[k]['brandId']+"'>"+resultArray[k]['brandName']+"</option>");
            }

            $( "select.brands" ).attr("disabled", false);
            $( "select.brands" ).next().toggleClass("loading");

            $( "select.brands" ).change(function() {
            	BRANDIDS = [];

                if ($(this).val() != "") {
                    BRANDIDS.push( $(this).val() );
                }
                clearGlobalVariable();
                removeNewIcon();
            	getArticleIdsWithState();
            });

}

function getBrandLogoId(brandNo) {
	for(var i = 0, len = BRANDS.length; i < len; i++) {
	    if (BRANDS[i].brandId === brandNo) {
	        return BRANDS[i].brandLogoID;
	        break;
	    }
	}
};

function getAssemblyGroup() {
	var request = {
        "getChildNodesAllLinkingTarget2":{
            "articleCountry" : COUNTRY,
            "childNodes" : true,
            "lang" : LANGUAGE,
            "linkingTargetType" : 'P',
            "provider" : TECDOC_MANDATOR
        }
    };

    request = toJSON(request);
    getdata(request, setAssemblyGroup);
}
function setAssemblyGroup(response) {

//            console.log(response.data.array);
            str = toJSON(response.data.array);
            obj = modifyAssemblyGroupResponseJSON(str);

            $('.assemblyGroup .tree').jstree({ 'core' : {'data' : obj} });
            $('.assemblyGroup .tree').on("select_node.jstree", function (e, data) {
                ASSEMBLYGROUPNODEID = data.node.id
                clearGlobalVariable();
                removeNewIcon();
                getArticleIdsWithState();
            });

}

function toJSON(obj) {
// Create JSON String and put a blank after every ',':
    return JSON.stringify(obj).replace(/,/g,", ");
}

function modifyAssemblyGroupResponseJSON(str) {
    str = str.replace(/assemblyGroupName/g, "text");
    str = str.replace(/assemblyGroupNodeId/g, "id");
    // Find all numbers and wrap them with "
    str = str.replace(/\b(\d+)\b/g, "\"$1\"");

    var obj = JSON.parse(str);
    // Add to the top an additional new item!
    obj.unshift({"text":"All","id":0,"hasChilds":false});

    for(var k in obj) {
        if (obj[k].parentNodeId) {
            obj[k].parent = obj[k].parentNodeId;
            delete obj[k].parentNodeId;
        } else {
            obj[k].parent = "#";
        }
    }

    return obj;
}

function getArticleIdsWithState() {

    $(".result").html('<span class="loading"></span>');

    if (CARID == "") {

        var info = '<div class="alert alert-warning" role="alert">Izaberite vozilo!</div>';
        $(".result").html(info);
        return;

    } else if (( ASSEMBLYGROUPNODEID == "" && BRANDIDS.length == 0 ) || ( ASSEMBLYGROUPNODEID == 0 && BRANDIDS.length == 0 )) {

        var info = '<div class="alert alert-warning" role="alert">Molimo vas izabereite brend ili grupu delova!</div>';
        $(".result").html(info);
        return;

    }

    var request = {
        "articleCountry": COUNTRY,
        "lang": "de",
        "linkingTargetId": CARID,
        "linkingTargetType": CARTYPE,
        "provider": TECDOC_MANDATOR,
        "sort": "1"
    };

    if (ASSEMBLYGROUPNODEID != "" && ASSEMBLYGROUPNODEID != 0) {
        request['assemblyGroupNodeId'] = ASSEMBLYGROUPNODEID;
    }

    if (BRANDIDS.length != 0) {
        request['brandNo'] = {'array': BRANDIDS};
    }

    request = toJSON(request);
    tecdocToCatPort["getArticleIdsWithState"](request, setArticleIdsWithState);
}
function setArticleIdsWithState(response){

            ASSIGNEDARTICLESIDS = response.data.array;

            if (ASSIGNEDARTICLESIDS) {

                totalnumber = 'Ukupan broj: <strong>' + ASSIGNEDARTICLESIDS.length + '</strong>';
                $(".totalnumber").html( totalnumber );

                $(".result").html('');

                LimitAssignedArticles();
            } else {
            	var info = '<div class="alert alert-danger" role="alert">Po ovim kriterijumima nije bilo pronadjenih artikala. Molimo vas da napravite jos jedan izbor.</div>';
				$(".result").html( info );
            }

}

function LimitAssignedArticles() {

    LimitedAssignedArticlesIds = [];

    number_articles = ASSIGNEDARTICLESIDS.length;
    max_articles_per_page = 5;
    number_pages = Math.ceil( number_articles / max_articles_per_page );

    startArticle = (PAGE-1)*max_articles_per_page;
    endArticle = PAGE*max_articles_per_page;

// alert("Number of articles: " + number_articles + "; Number pages: " + number_pages + "; Start Article: " + startArticle + ";" + endArticle );
    var index;
    for (index = 0; index < ASSIGNEDARTICLESIDS.length; ++index) {
        if (index >= startArticle && index < endArticle) {

            LimitedAssignedArticlesIds.push( ASSIGNEDARTICLESIDS[index] );
        }
    }

    if (number_articles <= endArticle ) {
    	// Set the page back to one for the next search or filter
        PAGE = 1;
    } else {
        PAGE++;
    }

    getAssignedArticlesByIds6(LimitedAssignedArticlesIds);
}

function getAssignedArticlesByIds6(assignedArticleIds) {
    assignedArticleId=assignedArticleIds;
//    $(".result").after('<span class="loading"></span>');

    var request = {
            "articleCountry": COUNTRY,
            "articleIdPairs": {
                "array": assignedArticleIds
            },
            "attributs": true,
            "basicData": true,
            "documents": true,
            "eanNumbers": true,
            "immediateAttributs": true,
            "immediateInfo": true,
            "info": true,
            "lang": LANGUAGE,
            "linkingTargetId": CARID,
            "linkingTargetType": CARTYPE,
            "mainArticles": true,
            "manuId": MANUID,
            "modId": MODELID,
            "normalAustauschPrice": true,
            "oeNumbers": true,
            "prices": true,
            "replacedByNumbers": true,
            "replacedNumbers": true,
            "thumbnails": true,
            "usageNumbers": true,
            "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getAssignedArticlesByIds6"](request, setAssignedArticlesByIds6);
}
function setAssignedArticlesByIds6(response){

            var html = '';

            var array = response.data.array;

            for(var x in array) {
                html += '<div id="' + x + '" class="article">';
//                html += '<div class="artikelnummer">' + array[x]['assignedArticle']['articleNo'] + ' ('+ array[x]['assignedArticle']['articleId'] +')</div>';
                html += '<h1>' + assignedArticleId[x]['brandName'] + ': ' + array[x]['assignedArticle']['articleName'] + '</h1>';

                html += '<div class="leftside pull-left">';
                html += '<div>';

                if ( array[x]['articleDocuments']['array'] ) {
                    var docTypeId = array[x]['articleDocuments']['array'][0]['docTypeId'];
                    if (docTypeId == 5 || docTypeId == 1) {
                        var docid =  array[x]['articleDocuments']['array'][0]['docId'];
                        // var src = 'image.php?docId=' + docid + '&flag=1';
                        var src = 'https://webservice.tecalliance.services/pegasus-3-0/documents/100002/'+docid+'/1';
                        html += '<img src="' + src + '">';
                    } else {
                        html += '<img src="img/no-image.jpg">';
                    }
                } else {
                    html += '<img src="img/no-image.jpg">';
                }
                html += '</div>';

                // Get logo from brand
                brandNo = assignedArticleId[x]['brandNo'];
                brandLogoID = getBrandLogoId(brandNo);

                // var src_logo = 'logo.php?brandLogoID=' + brandLogoID;
                var src_logo = 'https://webservice.tecalliance.services/pegasus-3-0/documents/100002/' + brandLogoID;
                html += '<div class="brandlogo"><img src="' + src_logo + '"></div>';

                // Bootstrap modal button for vehicle selection
	            html += '<br><button type="button" id="' + array[x]['assignedArticle']['articleId'] + '" class="btn btn-success btn-xs load_assigned_vehicles" data-toggle="modal" data-target="#modal_tecdoc">Povezana vozila <span class="glyphicon glyphicon-link" aria-hidden="true"></span></button>';
                html += '<br><a href="http://automehanika.rs"><img class="automehanika_logo" src="../images/automehanika_logo.png" /></a>';
                html += '</div>';

                html += '<div class="description pull-left">';
                html += '<div class="artikelnummer"><span>Br. artikla:</span>' + array[x]['assignedArticle']['articleNo'] + '<br><span>articleId:</span>'+ array[x]['assignedArticle']['articleId'] +'</div>';

                var attributes = array[x]['articleAttributes']['array'];

				html_attr = '';
                for(var i in attributes) {
                    if (attributes[i]['attrValue']) {
                        html_attr += '<div>' + attributes[i]['attrName'] + ': <strong>' + attributes[i]['attrValue'] + '</strong></div>';
                    } else {
                        html_attr += '<div><strong>' + attributes[i]['attrName'] + '</strong></div>';
                    }
                }

                var ean =  array[x]['eanNumber']['array'];

                html_ean = '';
                for(var j in ean) {
                    html_ean += '<div class="ean">EAN: ' + ean[j]['eanNumber'] + '</div>';
                }

                var oen =  array[x]['oenNumbers']['array'];

                html_oen = '';
                for(var k in oen) {
                    html_oen += '<div>' + oen[k]['brandName'] + ' - ' + oen[k]['oeNumber'] + '</div>';
                }

                artID = array[x]['assignedArticle']['articleId'];

                html += createTab(artID, html_attr, html_ean, html_oen);
                html += '<br><a href="http://automehanika.rs"><img class="automehanika_logo" src="../images/automehanika_logo.png" /></a>';
                html += '</div>';
                html += '<div style="clear:both"></div>';
                html += '</div>';

            }

            if ( $(".articlelist").length > 0 ) {
                // No need to do anything!
            } else {
                // If the article wrapper doesn't exist, dann add into inside
                $(".result").html('<div class="articlelist"></div>');
            }

            $(".articlelist").append(html);
            $(".column_middle .loading").remove();

            $( ".load_assigned_vehicles" ).click(function() {
            	removeNewIcon();
            	articleId = $(this).attr("id");
				getArticleLinkedAllLinkingTarget3(articleId);
			});

            if (PAGE > 1) {
                // If more articles exists, then show an icon to button more
                $(".result .loading").remove();
                $(".result").after( '<button type="button" class="btn btn-primary loadArticles">U&#269;itaj jo&#353; artikala</button>' );

                $( ".loadArticles" ).click(function() {
                	$(this).after('<span class="loading"><span>');
                    $(this).remove();
                    LimitAssignedArticles();
                });
            }
}

function getArticleLinkedAllLinkingTarget3(articleId) {

    $("#modal_tecdoc .modal-body").html('<span class="loading"></span>');

    var request = {
            "articleCountry": COUNTRY,
            "articleId": articleId,
            "lang": LANGUAGE,
            "linkingTargetType": 'P',
            "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getArticleLinkedAllLinkingTarget3"](request, setArticleLinkedAllLinkingTarget3);
}
function setArticleLinkedAllLinkingTarget3(response){
        	var linkedArticlePairs = response.data.array[0]['articleLinkages'];
        	if (linkedArticlePairs != "") {
				getArticleLinkedAllLinkingTargetsByIds3(articleId, linkedArticlePairs);
        	} else {
        		$( "#modal_tecdoc .modal-body" ).html('There were no cars linked to this part number!');
        	}

            console.log( "All linkage data with articleLinkId and linkingTargetId were loaded from TecDoc." );

}

function getArticleLinkedAllLinkingTargetsByIds3(articleId, linkedArticlePairs) {

    total_vehicle = linkedArticlePairs['array'].length;

    if (total_vehicle > 25) {
        limited = linkedArticlePairs['array'].slice(1, 25);
        linkedArticlePairs['array'] = limited;
    }

    var request = {
        "articleCountry": COUNTRY,
        "articleId": articleId,
        "immediateAttributs": true,
        "lang": LANGUAGE,
        "linkedArticlePairs": linkedArticlePairs,
        "linkingTargetType": 'P',
        "provider": TECDOC_MANDATOR
    };

    request = toJSON(request);
    tecdocToCatPort["getArticleLinkedAllLinkingTargetsByIds3"](request, setArticleLinkedAllLinkingTargetsByIds3);
}
function setArticleLinkedAllLinkingTargetsByIds3(response){

        	var html = '';

        	if ( total_vehicle > 25 ) {
        		html += '<p>Pronadjeno ' + total_vehicle + ' vozila povezano sa ovim brojem artikla. Rezultat ispod je ogranicen na 25 vozila:</p>';
        	}

        	if (response.status != 400) {
            	var array = response.data.array;

                html += '<table class="table table-striped">';

                html += '<thead>';
                html += '<tr>';
        		html += '<td>Marka</td>';
                html += '<td>Model</td>';
                html += '<td>Tip</td>';
                html += '<td>Karoserija</td>';
                html += '<td>KS/Kw</td>';
                html += '<td>Zapremina</td>';
                html += '<td>Godina</td>';
                html += '<td>Napomena</td>';
                html += '</tr>';
                html += '</thead><tbody>';

            	for(var x in array) {

            		// Contruction time

            		var fromTXT = '';
	                var toTXT = '';

	                if (array[x]['linkedVehicles']['array'][0]['yearOfConstructionFrom']) {
	                    var fromTXT = array[x]['linkedVehicles']['array'][0]['yearOfConstructionFrom'];
	                    fromTXT = fromTXT.toString();
	                }
	                if (array[x]['linkedVehicles']['array'][0]['yearOfConstructionTo']) {
	                    var toTXT = array[x]['linkedVehicles']['array'][0]['yearOfConstructionTo'];
	                    toTXT = toTXT.toString();
	                }

	                yearOfConstruction = fromTXT.substring(4,6) + "/" + fromTXT.substring(0,4);

	                if(toTXT != '') {
	                    yearOfConstruction += " - ";
	                    yearOfConstruction += toTXT.substring(4,6) + "/" + toTXT.substring(0,4);
	                } else {
	                    yearOfConstruction += " until now";
	                }

	                // Notes regarding limitation

	                notes = '';

	                if (array[x]['linkedArticleImmediateAttributs']['array']) {

	                	attributes = '';
	                	for(var y in array[x]['linkedArticleImmediateAttributs']['array']) {
	                		attributes += '<div style="white-space: nowrap">' + array[x]['linkedArticleImmediateAttributs']['array'][y]['attrName'] + ': ' + array[x]['linkedArticleImmediateAttributs']['array'][y]['attrValue'] + '</div>';
	                	}

						notes = attributes;
	                }

                    html += '<tr>';
            		html += '<td>' + array[x]['linkedVehicles']['array'][0]['manuDesc'] + '</td>';
                    html += '<td>' + array[x]['linkedVehicles']['array'][0]['modelDesc'] + '</td>';
                    html += '<td>' + array[x]['linkedVehicles']['array'][0]['carDesc'] + '</td>';
                    html += '<td>' + array[x]['linkedVehicles']['array'][0]['constructionType'] + '</td>';
                    html += '<td style="white-space: nowrap">' + array[x]['linkedVehicles']['array'][0]['powerHpFrom'] + ' / ' + array[x]['linkedVehicles']['array'][0]['powerKwFrom'] + '</td>';
                    html += '<td>' + array[x]['linkedVehicles']['array'][0]['cylinderCapacity'] + ' cm<sup>3</sup></td>';
                    html += '<td>' + yearOfConstruction + '</td>';
                    html += '<td>' + notes + '</td>';
                    html += '</tr>';
            	}

                html += '</tbody></table>';

                console.log( "Car related information were loaded from the API!" );
        	} else {
        		html = response.statusText;
        	}

			$( "#modal_tecdoc .modal-body" ).html(html);


}

function createTab(artID, attribute, ean, oen) {
	html = '<div>';
	html += '<ul class="nav nav-tabs" role="tablist">';
	html += '<li role="presentation" class="active"><a href="#attr' + artID + '" aria-controls="attr' + artID + '" role="tab" data-toggle="tab">Osobine</a></li>';
	html += '<li role="presentation"><a href="#ean' + artID + '" aria-controls="ean' + artID + '" role="tab" data-toggle="tab">EAN</a></li>';
	html += '<li role="presentation"><a href="#oen' + artID + '" aria-controls="oen' + artID + '" role="tab" data-toggle="tab">OEN</a></li>';
	html += '</ul>';
	html += '<div class="tab-content">';
	html += '<div role="tabpanel" class="attr tab-pane active" id="attr' + artID + '">' + attribute + '</div>';
	html += '<div role="tabpanel" class="ean tab-pane fade" id="ean' + artID + '">' + ean + '</div>';
	html += '<div role="tabpanel" class="oen tab-pane fade" id="oen' + artID + '">' + oen + '</div>';
	html += '</div>';
	html += '</div>';
	return html;
}


function showJSON(json_data, id, IsStringVal) {

    if ( IsStringVal == true) {
        json_data = JSON.parse( json_data );
    }

    var jsonPretty = JSON.stringify( json_data ,null,2);

    $( '#' + id ).html( '<pre><code>' + jsonPretty + '</code></pre>' );

}

function displayJSONCodeBlock( title ) {

    var random = Math.floor((Math.random() * 100000000000) + 1);
    tab = '<div>';
    tab += '<ul class="nav nav-tabs" role="tablist">';
    tab += '<li role="presentation" class="active"><a href="#request' + random + '" aria-controls="request' + random + '" role="tab" data-toggle="tab"><strong>Request</strong></a></li>';
    tab += '<li role="presentation"><a href="#response' + random + '" aria-controls="response' + random + '" role="tab" data-toggle="tab"><strong>Response</strong></a></li>';
    tab += '</ul>';
    tab += '<div class="tab-content">';
    tab += '<div role="tabpanel" class="request tab-pane active" id="request' + random + '"></div>';
    tab += '<div role="tabpanel" class="response tab-pane fade" id="response' + random + '"><span class="loading"></span></div>';
    tab += '</div>';
    tab += '</div>';

    accordion = '<div class="panel panel-default ' + random + '">';
    accordion += '<div class="panel-heading" role="tab" id="heading' + random + '">';
    accordion += '<h4 class="panel-title">';
    accordion += '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + random + '" aria-expanded="false" aria-controls="collapse' + random + '">';
    accordion += '<span class="plus-minus">+</span> ' + title;
    accordion += '</a>';
    accordion += '<span class="new pull-right">NEW</span>';
    accordion += '</h4>';
    accordion += '</div>';
    accordion += '<div id="collapse' + random + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + random + '">';
    accordion += '<div class="panel-body">';
    accordion += tab;
    accordion += '</div>';
    accordion += '</div>';
    accordion += '</div>';


    // Close all and open the new one
    $('.panel-collapse.in').collapse('hide');

    // Change the icon on the block title
    $( "span.plus-minus" ).each(function( index ) {
	  $(this).html('+');
	});

	$('.code .panel-group').append( accordion );

	// Switch plus/minus icon in code block title
    $( "." + random + " .panel-heading a" ).click(function() {
        var character = $(this).find('span.plus-minus').html();
        if ( character == '+' ) {
            $('.plus-minus').html('+');
            $(this).find('span.plus-minus').html('-');
        } else {
            $(this).find('span.plus-minus').html('+');
        }
    });

    return random;

}

function removeNewIcon() {
	// Remove all new icons
    $( "span.new" ).each(function( index ) {
    	$(this).fadeOut( "slow", function() {
    		$(this).remove();
  		});
	});
}


function redirectLink(){
  var providerid = 21010;
  if(!providerid){
    $('.container-fluid').hide();
    window.location.href = '../../en/playgrounds/';
  }
}

/*
redirectLink();
*/
getManufactures();
getBrands();
getAssemblyGroup();

//a=call("getManufacturers",request);
var request={
        "lang": "sr",
        "provider": TECDOC_MANDATOR
}
request = toJSON(request);
tecdocToCatPort["getLanguages"](request, callback);
function callback(response){
    console.log(response);
}

function getdata(request, func){
	$.ajax({
        type: "POST",
        dataType: "json",
        url: "./functions.php",
        data: request,
        success: function(response){
			func(response);
		}
	});
}