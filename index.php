<?php 

$page_title = "Mixarilla.com! Create your own mixtape";

$playlistID =  uniqid();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<meta name="author" content="Nathan Smith" />
<meta name="copyright" content="Licensed under GPL and MIT." />
<meta name="description" content="Adapt.js serves CSS based on screen width." />

<title><?php echo $page_title;?></title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>


<!--Jquery LINKS -->

<script type="text/javascript" src="js/jquery.dropdown.js"></script>


<!--CSS LINKS -->

<link rel="stylesheet" href="css/master.css" />

<link type="text/css" rel="stylesheet" href="css/jquery.dropdown.min.css" />

<noscript>
<link rel="stylesheet" href="css/mobile.min.css" />
</noscript>





<script type="text/javascript">

  $( document ).ready(function() {
  
  $("#mixtapeYtPreviewInfoContain").niceScroll({
      railoffset: { top:0, left:8},
      autohidemode: false,
      grabcursorenabled: false
    });
  
    $("#mixtapePlaylist").niceScroll({
      railoffset: { top:0, left:8},
      autohidemode: false,
      cursorborder: "0px solid #fff",
      cursorcolor:"#ddd",
      grabcursorenabled: false
    });
       
      $("#mixtapePlaylistInfoDescription").niceScroll({
      railoffset: { top:0, left:-3},
      autohidemode: false,
      cursorborder: "0px solid #fff",
      cursorcolor:"#666",
      grabcursorenabled: false
    });
    
      $("#mixtapeYtInfo").niceScroll({
      railoffset: { top:0, left:4},
      autohidemode: false,
      cursorborder: "0px solid #fff",
      cursorcolor:"#666",
      grabcursorenabled: false
    });
  
  
  
  
  $("#mixtapeYtInfoTab, #mixtapeYtVideoTab, #playlistTitle, #mixtapePlaylist li").click(function(){
    $("#mixtapePlaylistInfoDescription").getNiceScroll().resize();
    $("#mixtapeYtInfo").getNiceScroll().resize();

  });
  
  $("#mixtapePlaylistInfoDescription").keyup(function(e) {
  $(this).getNiceScroll().resize();
  });
  
  
  
  $("#mixtapePlaylistInfoTitle").keydown(function(e) {
    keepFontSize(true);
  });
  
    $("#mixtapePlaylistInfoTitle").keyup(function(e) {
    keepFontSize(false);

           if($("#mixtapePlaylistInfoTitle").val().length == 0){
    $("#mixtapeTitleWrap span").html("Click playlist then enter title").css("padding","0px");
    $("#mixtapeTitleWrap").width("auto");

    $("#mixtapeTitleWrap span").css("color","#FFDD00");
    }else{
    $("#mixtapeTitleWrap span").css("color","#000");
    }
    
    var incomplete = incCheck();
    
    if(incomplete > 0){
    $("#incBlock").show();
    }
    else{
    $("#incBlock").hide();
    }
    
  });
  
  
  
  function keepFontSize(held){
    
 
     var titleValue = $("#mixtapePlaylistInfoTitle").val();
     $("#mixtapeTitle span").html(titleValue);
    
    var mixtapeTitleDivWidth = $("#mixtapeTitle").width();
    var mixtapeTitleSpanWidth = $("#mixtapeTitle span").width();
    
    var mixtapeTitleSpanHeight = $("#mixtapeTitle span").height();
    
    //console.log("Div: "+ mixtapeTitleDivWidth + " & Span: "+ mixtapeTitleSpanWidth);
    
    $("#mixtapeTitleWrap").width(mixtapeTitleSpanWidth);

   var currentFontSize = $("#mixtapeTitle span").css("fontSize");

    
    if(mixtapeTitleSpanWidth > mixtapeTitleDivWidth){
      if(currentFontSize > "10px"){
      $("#mixtapeTitle span").css("fontSize","-=1px");
      }    
      
    } else{     
   
      if(currentFontSize < "30px"){
	$("#mixtapeTitle span").css("fontSize","+=1px");
      }

      var curFontSize = parseInt(currentFontSize);

      var newPaddingSize = 29 - curFontSize;
      
       if(curFontSize < 29){
       $("#mixtapeTitle span").css("paddingTop",+newPaddingSize+"px");
	}
  
    }
   
        if(held){
	keepFontSize;
	}
  } // END keepFontSize
  
  
  
  

  
  var ytVideoID = "-vZ0h6pG6r0";
  var maxResults = "4";
  var videoOrder = "relevance"; //date,rating,relevance,title,videoCount,viewCount   
  var pageToken;
  var prevPageToken;
  var nextPageToken;
  var resultsPerPage;
  var totalResults;
  var apiKey = "xxx";
  
  var nextClicked = false;
  var previousClicked = false;


  var firstResult = 1;
  var lastResult = 4;
  
$("#ytSearchBtn").click(function(){

var ytSearchQuery = $("#ytSearchBox").val();
var ytVideoURL = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults="+maxResults+"&order="+videoOrder+"&q="+ytSearchQuery+"&key="+apiKey+"&type=video";
var ytVideosURL = "https://www.googleapis.com/youtube/v3/videos?part=snippet&key="+apiKey+"&id=";
  

if(nextClicked){
ytVideoURL = ytVideoURL + "&pageToken=" + nextPageToken;
nextClicked = false;
previousClicked = false;
firstResult = firstResult + 4;
lastResult = lastResult + 4;

}
else if(previousClicked){
ytVideoURL = ytVideoURL + "&pageToken=" + prevPageToken;
previousClicked = false;
nextClicked = false;
  if(firstResult > 1){
  firstResult = firstResult - 4;
  lastResult = lastResult - 4;
  }
} else{
  firstResult = 1;
  lastResult = 4;
}


var newData;
  $.ajax({ url: ytVideoURL, 
	async: false,
	dataType: 'json',
	success: function(data) {
	  newData = data;
	
	}
  }); //end ajax get
  
  nextPageToken = newData.nextPageToken;
  prevPageToken = newData.prevPageToken;
  resultsPerPage = newData.pageInfo.resultsPerPage;
  totalResults = newData.pageInfo.totalResults;
  
  
  $("#ytSearchList").empty();
  
  var currentResults = firstResult.toString() + "&nbsp;&#8211;&nbsp;" + lastResult.toString();
  
  $("#ytSearchCurrentResults").empty().append(currentResults);
  
  totalResults = totalResults.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  
  $("#ytSearchTotalResults").empty().append(totalResults);
  
  $.each( newData.items, function( key, value ) {
      
    var vidID = value.id.videoId;
    
    var vidTitle;
    var vidDescription;
    var vidThumbSmall;
    var vidThumbMedium;
    var vidThumbHigh;
    
    var singleData;
    
    //console.log('yeaslgas'+vidID);
    
    $.ajax({ 
	  url: ytVideosURL+vidID, 
	  async: false,
	  dataType: 'json',
	  success: function(data) {
	  singleData = data;
	  //console.log(singleData);
		  }
    }); //end ajax get
  

  
  
    var value =  singleData.items[0];
    vidTitle = value.snippet.title;
    vidDescription = value.snippet.description;
    vidThumbSmall = value.snippet.thumbnails.default.url;
    vidThumbMedium = value.snippet.thumbnails.medium.url;
    vidThumbHigh = value.snippet.thumbnails.high.url;
  
  

      vidDescription = escape(vidDescription);
      vidDescription = encodeURIComponent(vidDescription);

  var vidTitleShort = vidTitle.substring(0, 30) + '...'; 
  
      vidTitle = escape(vidTitle);
      vidTitle = encodeURIComponent(vidTitle);

  
  var ytVideoWidget =  
    "<li>"+
    "<p  data-id='"+vidID+"' data-title='"+vidTitle+"' data-description='"+vidDescription+"' class='ytSearchTitle'>"+vidTitleShort+"</p>"+
    "<img class='ytSearchThumb'  title='Click to Preview Song' src='"+vidThumbSmall+"'  alt='Click to Preview Song'/>"+
    "<div class='ytSearchPlayBox' title='Click to Preview Song'><span class='ytSearchPlayBoxText'>Preview</span></div>"+
    "<div class='ytSearchAddBox' id='ytAddLink-"+vidID+"' title='Click to Add to Playlist'><span class='ytSearchAddBoxText'>Added!</span><span class='ytSearchAddBoxCheck'>&#10004;</span><span class='ytSearchAddBoxPlus'>&#43;</span><span class='ytSearchAddBoxNote'>&#9835</span></div>"+
    "</li>";
  
  $("#ytSearchList").append(ytVideoWidget);
    
  }); //end each items  

}); //end youtube search click
  

    
$("#ytSearchBtnPrevious").click(function(){

var ytSearchQuery = $("#ytSearchBox").val(); 
var ytVideoURLPrevious = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults="+maxResults+"&order="+videoOrder+"&pageToken="+previousPageToken+"&q="+ytSearchQuery+"&key="+apiKey;


$.get( ytVideoURLPrevious, function( data ) {
  //console.log(data);

  $("#ytSearchList").empty().html('<li>'+data+'</li>');
  
  }); //end .get YouTube search results
}); //end youtube search  


$("#mixtapeYtPreviewCancel").click(function(){
  $("#mixtapeYtPreviewContain").hide();
});

$("#mixtapeYtPreviewAdd").click(function(){

  var ytVideoID = $(this).attr('data-videoID');
  $("#ytAddLink-"+ytVideoID).click();
  
  $("#mixtapeYtPreviewContain").hide();
  
});





  $('body').on('click', '.ytSearchPlayBox, .ytSearchThumb, .ytSearchTitle', function () {
  
  $("#mixtapeYtPreviewContain").show();
  
  
  var parent = $(this).parent();
  var vidID = parent.children('.ytSearchTitle').attr('data-id');
  var vidTitle = parent.children('.ytSearchTitle').attr('data-title');
  var vidDescription = parent.children('.ytSearchTitle').attr('data-description');
  
  vidTitle = decodeURIComponent(vidTitle);
  vidTitle = unescape(vidTitle);

  vidDescription = decodeURIComponent(vidDescription);
  vidDescription = unescape(vidDescription);

  
  $("#mixtapeYtPreviewTitle").empty().append(vidTitle);
  $("#mixtapeYtPreviewDescription").empty().append(vidDescription);
  $(".mixtapeYtPreview").attr("src","http://www.youtube.com/embed/"+vidID+"?autoplay=0");
  
  $("#mixtapeYtPreviewInfoContain").scrollTop(0).getNiceScroll().resize();
  
  $("#mixtapeYtPreviewAdd").attr('data-videoID', vidID);
  
});





  $('body').on('click', '.ytSearchAddBox', function () {
  
  
  //$(this).css('background-color','#A6FFB2');
  $(this).children('.ytSearchAddBoxPlus').hide();
  $(this).children('.ytSearchAddBoxNote').hide();
  $(this).children('.ytSearchAddBoxText').show().fadeOut(2000);
  $(this).children('.ytSearchAddBoxCheck').show();

  var parent = $(this).parent();
  var vidID = parent.children('.ytSearchTitle').attr('data-id');
  var vidTitle = parent.children('.ytSearchTitle').attr('data-title');
  var vidDescription = parent.children('.ytSearchTitle').attr('data-description');
  
  var vidTitleDecoded = decodeURIComponent(vidTitle);
  vidTitleDecoded = unescape(vidTitleDecoded);
  
  //vidDescription = decodeURIComponent(vidDescription);
  //vidDescription = unescape(vidDescription);
  
  
  

  $("#mixtapePlaylist").append("<li class='mixtapePlaylistLi' id='ytLiId-"+vidID+"' data-id='"+vidID+"' data-title='"+vidTitle+"' data-description='"+vidDescription+"'><span id='mixtapePlaylistSongOuter'><span id='mixtapePlaylistSongInner'>"+vidTitleDecoded+"</span></span></li>");
  
  $("#ytAddLink-"+vidID).click(false);
  
var playlistSize = $("#mixtapePlaylist li").length;

if(playlistSize > 1){
$("#playlistTitleSearch").empty().append(" - "+playlistSize+" Videos").css("color","#000");
}else{
$("#playlistTitleSearch").empty().append(" - "+playlistSize+" Video").css("color","#000");
}

  var incomplete = incCheck();
    
    if(incomplete > 0){
    $("#incBlock").show();
    }
    else{
    $("#incBlock").hide();
    }
  
});



$("#ytSearchBox").keypress(function(e) {
    if(e.which == 13) {
  $("#ytSearchBtn").click();
    }
});

//$("#ytSearchBox").val('Elliott Smith');
//$("#ytSearchBtn").click();


$("#ytSearchNextPageBtn").click(function(){
  nextClicked = true;
  previousClicked = false;
  $("#ytSearchBtn").click();
});

$("#ytSearchPreviousPageBtn").click(function(){
  previousClicked = true;
  nextClicked = false;
    $("#ytSearchBtn").click();
});


$(".ytSort").click(function(){
var value = $(this).attr('data-value');
var valueDisplay = $(this).text();
$("#ytOrderedDropDown").html(valueDisplay+"<span>&nbsp;&nbsp;&#9662;</span>");
videoOrder = value;

if($("#ytSearchBox").val() != ""){
$("#ytSearchBtn").click();
}
});


$("#mixtapeYtVideoTab").click(function(){

$("#mixtapeYtInfo").hide();
$("#mixtapeYtViewContain").show();

});

$("#mixtapeYtInfoTab").click(function(){

$("#mixtapeYtInfo").show();
$("#mixtapeYtViewContain").hide();


$("#mixtapeYtInfoDesc").getNiceScroll().resize();

});



$("#playlistTitle").click(function(){

$("#mixtapeYtContain").hide();
$("#mixtapePlaylistInfoContain").show();

//Remove ALL <li> with selected class, then add normal class back
$("#mixtapePlaylist li").removeClass("playlistSelected").addClass("mixtapePlaylistLi");

//Remove normal class from playlist title, then add selected class
$(this).removeClass("mixtapePlaylistTitle").addClass("playlistSelected").css("borderColor","#ff5343");

$("#mixtapePlaylistInfoDescription").getNiceScroll().resize();

$("#playlistBtns").attr('data-viewing', '');

$("#mixtapePlaylistInfoTitle").focus();

});


 $("#mixtapeTitle").click(function(){
 	$("#playlistTitle").click();
 	});
  
  
  $("#mixtapeYtInfoArtist").keyup(function(e) {
  
  var ytLiID = $("#mixtapeYtInfo").attr('data-viewingID');
  
  var artistValue = $(this).val();
  
  $("#ytLiId-"+ytLiID).attr('data-artist', artistValue);
      
  });
  
  
    
  $("#mixtapeYtInfoSong").keyup(function(e) {
  
  var ytLiID = $("#mixtapeYtInfo").attr('data-viewingID');
  
  var songValue = $(this).val();
  
  $("#ytLiId-"+ytLiID).attr('data-song', songValue);
      
  });

  
   $("#mixtapeYtInfoDesc").keyup(function(e) {
  
  var ytLiID = $("#mixtapeYtInfo").attr('data-viewingID');
  
  var descValue = $(this).val();
  
  $("#ytLiId-"+ytLiID).attr('data-description', descValue);
      
  });

  $('body').on('click', '#mixtapePlaylist li', function () {

  var ytVideoID = $(this).attr('data-id');
  var ytVideoTitle = $(this).attr('data-title');
  var ytVideoDescription = $(this).attr('data-description');

  ytVideoTitle = decodeURIComponent(ytVideoTitle);
  ytVideoTitle = unescape(ytVideoTitle);
  
  ytVideoDescription = decodeURIComponent(ytVideoDescription);
  ytVideoDescription = unescape(ytVideoDescription);
  
$("#mixtapeYtView").attr("src","http://www.youtube.com/embed/"+ytVideoID+"?autoplay=0");




$("#mixtapeYtVideoTab").click(); 


$("#playlistBtns").attr('data-viewing', ytVideoID);


$("#mixtapeYtTitle").empty().append(ytVideoTitle);


$("#mixtapeYtDescription").empty().append(ytVideoDescription);


$("#mixtapeYtContain").show();
$("#mixtapePlaylistInfoContain").hide();

//Remove ALL <li> with selected class, then add normal class back
$("#mixtapePlaylist li").removeClass("playlistSelected").addClass("mixtapePlaylistLi");

//Remove selected class from playlist title and add it's normal class back
$("#playlistTitle").removeClass("playlistSelected").addClass("mixtapePlaylistTitle");

//Remove normal class for clicked <li>, then add selected class
$(this).removeClass("mixtapePlaylistLi").addClass("playlistSelected");

//Change back border color of playlist title
$("#playlistTitle").css("borderColor","#999");


$("#mixtapeYtInfo").getNiceScroll().resize();


    


});

  
  
    function boomBoxAnimation(){
    
      $( "#cassette" ).stop().css('top','-40px').animate({
      top: "+=58"
      }, 650, function() {
      $(this).css('top','-40px');
      boomBoxAnimation();
      });
    } // end boomBoxAnimation
    
    $("#boomBox, #loginBlock").hover(function(){
     $("#cassette").stop().css('top','18px');
      boomBoxAnimation();
      $(this).children("#mixtapeSaveText").css('color','#00FF22');
    }, function(){
      $("#cassette").stop().css('top','18px');
      $(this).children("#mixtapeSaveText").css('color','#00C11A');
    });
    
  
  
  $("#playlistTitle").click();
  

         
	    
    $("body").on('mouseenter', '#mixtapePlaylist li', function() {
    var text = $(this).find("#mixtapePlaylistSongInner");
    var textWidth = $(this).width();
      
      var size = text.width() - textWidth + 10;
      var duration = 2000;
      
      var aniSize = text.width();
      
      if(aniSize <245){
      duration = 250;
      } 
      
      if(aniSize >260){
      duration = 3000;
      } 
      
      
      if(aniSize >300){
      duration = 3500;
      } 
      
      
      if(aniSize >350){
      duration = 4000;
      }
     
      
      if(aniSize >400){
      duration = 4500;
      }
       
      if(aniSize >450){
      duration = 5000;
      }
      
       if(aniSize >500){
      duration = 5500;
      }
      
      if(text.width() > 238){
      
      text.css('right', 'auto');
      
      text.animate({
      right: "+="+size
      }, {
      duration: duration,
      easing: "linear"
      }, function() {
      
      text.css('left', 'auto');
      });
      
      }
      
    });
    $("body").on('mouseleave', '#mixtapePlaylist li', function() {

    var text = $(this).find("#mixtapePlaylistSongInner");
    var textWidth = $(this).width();
    
    text.stop().css("right","auto");

    
    });
    
    
   $("#playlistMoveUp").click( function(){
   
   
    var ytLiID = $("#playlistBtns").attr('data-viewing');
    var liItem = $("#ytLiId-"+ytLiID);
    
    liItem.insertBefore(liItem.prev());
   });
   
   $("#playlistMoveDown").click( function(){
    var ytLiID = $("#playlistBtns").attr('data-viewing');
    var liItem = $("#ytLiId-"+ytLiID);
    
    liItem.insertAfter(liItem.next());
   });
   
    $("#playlistDelete").click( function(){
    var ytLiID = $("#playlistBtns").attr('data-viewing');
    var liItem = $("#ytLiId-"+ytLiID);
    
    
    $("#mixtapePlaylistTitleUL li").click();
    liItem.remove();
   
       var playlistSize = $("#mixtapePlaylist li").length;

    if(playlistSize == 1){
    $("#playlistTitleSearch").empty().append(" - "+playlistSize+" Video").css("color","#000");
    }else if (playlistSize > 1){
    $("#playlistTitleSearch").empty().append(" - "+playlistSize+" Videos").css("color","#000");
    }else if (playlistSize == 0){
    $("#playlistTitleSearch").empty().append(" - Search then add videos").css("color","#FFFF00");
    }

      var incomplete = incCheck();
    
    if(incomplete > 0){
    $("#incBlock").show();
    }
    else{
    $("#incBlock").hide();
    }
    
   });
   
   
   $( "#mixtapePlaylistInfoGenres" ).autocomplete({
  source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
});
   
   $("#loginBlock").click(function(){
   alert("Please login first to save your mixtape!");
   });
   
    $("#incBlock").click(function(){
   alert("Please add a title and at least one song before you share your mixtape");
   saveMixtape();
   
   });
   
   $("#boomBox").click(function(){
   saveMixtape();
  
   });
   
   
   
   function incCheck(){
   
   var playlistSize = $("#mixtapePlaylist li").length;
   var playlistTitleSize = $("#mixtapePlaylistInfoTitle").val().length;
   
   var inc = 0;
   
   if(playlistSize < 1) inc++;
   if(playlistTitleSize < 1) inc++;
    
   return inc;
   }
   
   function saveMixtape(){
   
    var mixtapeTitle = $("#mixtapePlaylistInfoTitle").val();
   
    var mixtapeDesc = $("#mixtapePlaylistInfoDescription").val();
    
    var mixtapeGenre = $("#mixtapePlaylistInfoGenre").val();
    
    var playlistID = "<?PHP echo $playlistID;?>";

    var playlistObj = {
    "playlistTitle":mixtapeTitle,
    "playlistSongs":{},
    "playlistDescription":mixtapeDesc,
    "playlistGenre":mixtapeGenre,
    "playlistID":playlistID,
    "userID":fb_user_id
    };
    
    var listItems = $("#mixtapePlaylist li");
    
    var count = 0;
    
    listItems.each(function(idx, li) {
    count++;
    var videoID = $(li).attr('data-id');
    var videoTitle = $(li).attr('data-title');
    var videoDescription = $(li).attr('data-description');
    //console.log(videoTitle);
    //console.log(videoDescription);
    
    playlistObj.playlistSongs[count]={
    "videoID":videoID,
    "videoTitle":videoTitle,
    "videoDescription":videoDescription
    }
    }); //end each
   
   
   
 
   
   
     var URL = "save.php";
  
    $.ajax({
    type : "POST",
    url : URL,
    data : {
    playlistObject: playlistObj
    },
    dataType : "html",
    cache : false,
    success : function(data) {
    // Process return status data here
    //console.log(data);
    console.log(data);
    }
    });

   
   console.log(playlistObj);
   
   }
   
    
   function checkUser(id,first_name,last_name,email){
   
   //console.log('ran');
   
  var URL = "login.php";
  var userObject  = {
  fb_id: id,
  first_name: first_name,
  last_name: last_name,
  email: email
  };
  
  //console.log(userObject);
  
$.ajax({
type : "POST",
url : URL,
data : {
userObject: userObject
},
dataType : "json",
cache : false,
success : function(data) {
// Process return status data here
//console.log(data);
console.log(data);
}
});

   
   }
   
   
var fb_user_id;
   
      
//FB STUFF    
window.fbAsyncInit = function() {

  FB.init({
  appId      : '1602739366660552',
  xfbml      : true,
  version    : 'v2.3'
  });

    FB.getLoginStatus(function(response) {    
  });
  
  FB.Event.subscribe('auth.statusChange', function(response) {
    // check for status in the response
    if (response.status === 'connected') {
    /* make the API call */
      FB.api(
      "/me",
	function (response) {
	  if (response && !response.error) {
	  /* handle the result */
	  //console.log(response);
	  var id = response.id;
	  var first_name = response.first_name;
	  var last_name = response.last_name;
	  var email = response.email;
	  checkUser(id,first_name,last_name,email);
	  
	  fb_user_id = id;
	  
	  $("#loginBlock").hide();
	  
	  } // END if (response && !response.error)
	} // END function (response)
      ); // END FB.api
    } // END if (response.status === 'connected')
    else{
    $("#loginBlock").show();
    
    }
  }); // END FB.Event.subscribe
  
}; // END window.fbAsyncInit

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  
    ///END FB STUFF   
    
  }); //end jQuery



//Main function to run all size change
function windowSizeChange(i, width) {
  // Alias HTML tag.
  var html = document.documentElement;

  // Find all instances of range_NUMBER and kill 'em.
  html.className = html.className.replace(/(\s+)?range_\d/g, '');

  // Check for valid range.
  if (i > -1) {
    // Add class="range_NUMBER"
    html.className += ' range_' + i;
  }

  // Note: Not making use of width here, but I'm sure
  // you could think of an interesting way to use it.
  
  
  
}


// Edit to suit your needs.
var ADAPT_CONFIG = {
  // Where is your CSS?
  path: 'css/',

  // false = Only run once, when page first loads.
  // true = Change on window resize and page tilt.
  dynamic: true,
  callback:windowSizeChange,

  // First range entry is the minimum.
  // Last range entry is the maximum.
  // Separate ranges by "to" keyword.
  /*
  range: [
    '0px    to 760px  = mobile.min.css', //mobile
    '760px  to 980px  = 720.min.css',
    '980px  to 1280px = 960.min.css',
    '1280px to 1600px = 1200.min.css',
    '1600px to 1940px = 1560.min.css',
    '1940px to 2540px = 1920.min.css',
    '2540px           = 2520.min.css'
  ]
  */
    range: [
    //'0px    to 760px  = mobile.min.css', //mobile
    '0px    to 760px  = mobile.min.css', //mobile
    '0px  to 2540px = 960.min.css' //desktop

  ]
};




    </script>
    
<!--Adapt.js-->
<script src="js/adapt.min.js"></script>

<script src="js/jquery.nicescroll.min.js"></script>

</head>

<body>

  <script>

    </script>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-552e162d301bb09c" async="async"></script>


  
  
<div class="container_12" > <!--Container of all grid elements -->
  <!--12 = 3 + 9 -->

  
  <div id="headerWrap" class="grid_12"> 
  <div id="header"> 
  
<div id="headlineCreate"><p><span>Create</span> your own mixtape...</p></div>
<div id="headlineShare"><p>...<span>Share</span> with your friends</p></div>
  
  
  </div> <!-- END #header -->
  </div> <!-- END #headerWrap -->
  
  <div id="mainMenuWrap"  class="grid_12">   
  <ul id="mainMenu">
    <li><a href="#" title="Homepage for Mixrilla.com">Home</a></li>
    <li><a href="#" title="Create your own mixtape">Create&nbsp;&nbsp;Mixtape</a></li>
    <li><a href="#" title="View Recent Mixtapes">My&nbsp;&nbsp;Mixtapes</a></li>
    <li><a href="#" title="Homepage for Mixrilla.com">Home</a></li>
    <li>
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true" onlogin=" FB.getLoginStatus();"></div>
    </li>
  </ul> <!-- END #mainMenu -->
  </div> <!-- END #mainMenuWrap -->
  
  
  <div id="ytContain" class="grid_3"> 
  
      <div id="ytSearchBoxBtnWrap">
	
	<input id="ytSearchBox" type="text" placeholder="Search Youtube Here...">
	
	<div id="ytSearchBtn" title="Click to search for Youtube Videos" alt="Click to search for Youtube Videos">
	</div> <!-- END #ytSearchBtn-->

    </div> <!-- END #ytSearchBoxBtnWrap-->
    
     <div id="ytOrderedWrap">
      <span id="ytOrderedText">Sorting By: &nbsp;</span>
      <a data-jq-dropdown="#jq-dropdown-1" href="#" id="ytOrderedDropDown" class="ytOrderedDropDown">Relevance<span>&nbsp;&nbsp;&#9662;</span></a> 
     </div><!-- END #ytOrderedWrap-->
    
    <div id="ytSearchResults">
    <ul id="ytSearchList"></ul> <!-- END #ytSearchList -->
    
    <div id="ytPageResults">
      <button class="btn" id="ytSearchPreviousPageBtn" title="Click for the previous page of results"></button>
      <span id="ytSearchShowingText"><span id='ytSearchCurrentResults'></span></span>
      <span id="ytSearchResultsText">&nbsp;&nbsp;<span><b>of</b></span>&nbsp;&nbsp;<span id='ytSearchTotalResults'></span></span>
      <button class="btn" id="ytSearchNextPageBtn" title="Click for the next page of results"></button>

    </div> <!-- END #ytPageResults-->
    
    </div> <!-- END #ytSearchResults -->
  
  
  </div> <!-- END #ytContain .grid_3-->   
    

<!--9-->  
<div class="grid_9" id="mixtapeContain">

  <div id="mixtapeTitle">
    <div id="mixtapeTitleWrap">
    <span>Click Playlist then enter title</span>
    </div>
    </div> <!-- ENd #mixtapeTitle -->
      
  <div id="mixtapeContentContain">
    
    <div id="mixtapeContent">
     
      <div id="mixtapePlaylistContain">
	
	<ul id="mixtapePlaylistTitleUL">
	<li class="mixtapePlaylistTitle" id="playlistTitle">
	<span id="playlistTitlePlaylist">Playlist<span>
	<span id="playlistTitleSearch"> - Search then add videos<span>
	</li>
	</ul>
	
	<ul id="mixtapePlaylist"></ul>
     
      <div id="playlistBtns"  data-viewing="">
      <a id="playlistMoveUp" class="playlistBtn">Move Up</a>
      <a id="playlistMoveDown" class="playlistBtn">Move Down</a>
      <a id="playlistDelete" class="playlistBtn">Delete</a>
      </div>
      
      </div> <!-- END mixtapePlaylistContain -->
      
     <div id="mixtapeYtContain"> 
      
      <div id="mixtapeYtHeaderTabs">
      	<div id="mixtapeYtVideoTab"><span>Video Player</span></div> <!-- END #mixtapeYtVideoTab -->
	<div id="mixtapeYtInfoTab"><span>Video Info</span></div> <!-- END #mixtapeYtInfoTab -->
      </div> <!-- END #mixtapeYtHeaderTabs -->
     
     <div id="mixtapeYtInfo">
          
	  <pre id="mixtapeYtTitle"></pre>
	  <pre id="mixtapeYtDescription"></pre>
     </div> <!-- END #mixtapeYtInfo -->
     
     <div id="mixtapeYtViewContain">
     <iframe id='mixtapeYtView' type='text/html'  src='' frameborder='0'>
     </iframe> <!-- END .mixtapeYtPreview -->
     </div> <!--End mixtapeYtViewContain -->
     
     </div> <!-- END #mixtapeYtContain --> 
      
     <div id="mixtapePlaylistInfoContain">
            
	<input id="mixtapePlaylistInfoTitle" type="text" placeholder="Enter playlist title here..." maxlength="50">
	<textarea id="mixtapePlaylistInfoDescription" placeholder="Describe your playlist here..."></textarea>
	<input id="mixtapePlaylistInfoGenre" type="text" placeholder="Enter playlist genre here..." maxlength="50">

     </div> <!-- End mixtapePlaylistInfoContain --> 
      
      
    </div> <!--END #mixtapeContent -->
    
    
    <!-- Youtube Video Preview -->
    <div id="mixtapeYtPreviewContain">

      <div id="mixtapeYtPreviewInfoWrap">
	   
	<div id="mixtapeYtPreviewInfoContain">
	  <pre id="mixtapeYtPreviewTitle"></pre>
	  <pre id="mixtapeYtPreviewDescription"></pre>
	</div> <!-- ENd #mixtapeYtPreviewInfoContain -->

	<div id="mixtapeYtPreviewControls"> 
	  <button class="button" id="mixtapeYtPreviewCancel">Cancel</button>
	  <button class="button" id="mixtapeYtPreviewAdd">Add Song</button>
	</div>  <!--  ENd #mixtapeYtPreviewControls -->
      
      </div>  <!--  ENd #mixtapeYtPreviewInfoWrap -->

      <iframe class='mixtapeYtPreview' type='text/html'  src='' frameborder='0'>
      </iframe> <!-- END .mixtapeYtPreview -->
    
    </div> <!-- END #mixtapeYtPreviewContain -->
   <!-- END Youtube Video Preview -->
   
  </div> <!-- ENd #mixtapeContentContain -->
           
  <div id="mixtapeFooter">
  
  <div id="loginBlock"></div>
  <div id="incBlock"></div>
 
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <div id="shareWidget" class="addthis_sharing_toolbox"></div>
    
    <div id="mixtapeSave">
    
      <div id="boomBox">
      <span id="mixtapeSaveText">Save</span>
      <div id="cassette"></div>
      </div>
    
      <div id="mixtapeSaveTextWrap">
      <span id="mixtapeSaveTextSave">Save</span><span id="mixtapeSaveTextMixtape">Mixtape!</span>
      </div> <!-- End #mixtapeSaveTextWrap -->
    
    </div> <!-- End #mixtapeSave -->
    
  </div> <!-- ENd #mixtapeFooter -->
   
</div> <!-- END #mixtapeContain .grid_9-->

<div id="footer" class="grid_12"></div> <!-- ENd #footer .grid_12-->


</div> <!-- END .container_12 -->

<div id="jq-dropdown-1" class="jq-dropdown jq-dropdown-tip">
    <ul class="jq-dropdown-menu">
        <li><a class="ytSort" data-value="relevance">Relevance</a></li>
        <li><a class="ytSort" data-value="title">Video Title</a></li>
        <li><a class="ytSort" data-value="rating">Video Rating</a></li>
        <li><a class="ytSort" data-value="date">Upload Date</a></li>
        <li><a class="ytSort" data-value="viewCount">View Count</a></li>
        <li><a class="ytSort" data-value="videoCount">Video Count</a></li>
    </ul>
</div>



</body>
</html>

