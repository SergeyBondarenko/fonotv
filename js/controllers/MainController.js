function playVideo(video_source, videoTag){
	var video = document.getElementById(videoTag); 
	var play_music = document.getElementById('play-music');
	var video_link = document.getElementById('orig-link');
	var video_link_title = document.getElementById('orig-link-title');

	// Test console output
	for(var i = 0; i < video_source.length; i++){
	  console.log(video_source[i].file);
	} 
	
	// Play coubs
	var videoCount = video_source.length; 
	var videoId = 0;
	
	// Set first video
	video.setAttribute("src",video_source[0].file);
	//video_link.setAttribute("href",video_source[0].orig_page);
	//video_link_title.textContent = video_source[0].title;

	// Listen for video end and run handler to play other videos
	video.addEventListener('ended',myHandler,false);

	play_music.addEventListener('click', function(){
  	muteVideo(video); 
  }, false);

	// Mute and unmute
	function muteVideo(video){
		if(video.muted)
			video.muted = false;
		else
			video.muted = true;	
	}

	// Play all other videos
	function videoPlay(videoNum, mute)
	{
	  video.setAttribute("src",video_source[videoNum].file);
		//video_link.setAttribute("href",video_source[videoNum].orig_page);
		//video_link_title.textContent = video_source[videoNum].title;

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
