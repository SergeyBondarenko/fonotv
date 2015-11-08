function playVideo(video_source, videoTag){
	var video = document.getElementById(videoTag); 
	var play_music = document.getElementById('play-music');

	// Test console output
	for(var i = 0; i < video_source.length; i++){
	  console.log(video_source[i].file);
	} 
	
	// Play coubs
	var videoCount = video_source.length; 
	var videoId = 0;
	
	video.setAttribute("src",video_source[0].file);
	video.addEventListener('ended',myHandler,false);

	play_music.addEventListener('click', function(){
  	muteVideo(video); 
  }, false);

	function muteVideo(video){
		if(video.muted)
			video.muted = false;
		else
			video.muted = true;	
	}

	function videoPlay(videoNum, mute)
	{
	  video.setAttribute("src",video_source[videoNum].file);
	  video.load();
		if(mute == true)
			video.muted = true;	
		else
			video.muted = false;

	  video.play();
	}

	function myHandler(){
		var mute = "";
		if(video.muted)
			mute = true;
		else
			mute = false;

	  if (videoId == (videoCount - 1)){
	    videoId = 0;
	    videoPlay(videoId, mute);
	  } else {
	    videoId++;
	    videoPlay(videoId, mute);
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

	//$scope.deleteDbFTV = function(){
	//	// Delete FonoTV DB
	//	coub.deleteDbFTV(system_calls, local_json).success(function(data){
	//		video_source = data;	
	//	});
	//}

}]);
