var LOOP = 0;
var mute = true;

// Randomize
function randomizer(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle
  while (0 !== currentIndex) {

    // Pick a remaining element
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

// Function to play videos
function playVideo(video_source, videoTag, videoNext){
	var video = document.getElementById(videoTag); 
	var video_next = document.getElementById(videoNext); 
	var play_music = document.getElementById('play-music');
	var video_link = document.getElementById('orig-link');
	var video_link_title = document.getElementById('orig-link-title');

	video_source = randomizer(video_source);

	//Test console output
	for(var i = 0; i < video_source.length; i++){
	  console.log(video_source[i].file);
	} 
	
	// Play coubs
	var videoCount = video_source.length; 
	var videoId = 0;
	
	// Set the first video that starts automatically
	video.setAttribute("src",video_source[videoId].file);
	video_link.setAttribute("href",video_source[videoId].orig_page);
	video_link_title.textContent = video_source[videoId].title;

  console.log(video.readyState);

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
	function playVideoForHandler(videoNum)
	{
	  video.setAttribute("src",video_source[videoNum].file);
		video_link.setAttribute("href",video_source[videoNum].orig_page);
		video_link_title.textContent = video_source[videoNum].title;

		//video_next.setAttribute("src",video_source[videoNum + 1].file);

	  video.load();

		if(mute == true)
			video.muted = true;	
		else
			video.muted = false;

	  video.play();
	}

	function myHandler(){
		//var mute = "";
		if(video.muted)
			mute = true;
		else
			mute = false;

	  if (videoId == (videoCount - 1)){
	    videoId = 0;
	    playVideoForHandler(videoId);
	  } else {
	    videoId++;
	    playVideoForHandler(videoId);
	  }
	} // myHandler

}

var video_source = {};
// Execute the main controller stuff
app.controller('MainController', ['$scope', 'coub', function($scope, coub){
	
	var local_json = 'php/apimongo.php';

	// Default play FonoTV video
	coub.getCoubsForFTV(local_json).success(function(data){
		video_source = data;	
		playVideo(video_source, "video-about", "video-about-next");
	});

	//$scope.deleteDbFTV = function(){
	//	// Delete FonoTV DB
	//	coub.deleteDbFTV(system_calls, local_json).success(function(data){
	//		video_source = data;	
	//	});
	//}

}]);
