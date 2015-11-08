function playVideo(video_source, videoTag){
	// Test console output
	for(var i = 0; i < video_source.length; i++){
	  console.log(video_source[i].file);
	} 
	
	// Play coubs
	var videoCount = video_source.length; 
	var videoId = 0;
	
	document.getElementById(videoTag).setAttribute("src",video_source[0].file);
	document.getElementById(videoTag).addEventListener('ended',myHandler,false);

	function videoPlay(videoNum)
	{
	  document.getElementById(videoTag).setAttribute("src",video_source[videoNum].file);
	  document.getElementById(videoTag).load();
	  document.getElementById(videoTag).play();
	}

	function myHandler(){
	  if (videoId == (videoCount - 1)){
	    videoId = 0;
	    videoPlay(videoId);
	  } else {
	    videoId++;
	    videoPlay(videoId);
	  }
	}
}

var video_source = {};
app.controller('MainController', ['$scope', 'coub', function($scope, coub){
	
	$scope.coubText = 'Space ship';
	var local_json = 'php/apimongo.php';

	// Default play FonoTV video
	coub.getCoubsForFTV(local_json).success(function(data){
		video_source = data;	
		playVideo(video_source, "video-about");
	});

	$scope.readDbFTV = function(){
		// Play FonoTV video
		coub.getCoubsForFTV(local_json).success(function(data){
			video_source = data;	
			playVideo(video_source, "video-about");
		});
	}

	$scope.deleteDbFTV = function(){
		// Delete FonoTV DB
		coub.deleteDbFTV(system_calls, local_json).success(function(data){
			video_source = data;	
		});
	}

}]);
