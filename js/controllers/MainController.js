function playVideo(video_source, videoTag){
	// Test console output
	for(var i = 0; i < video_source.length; i++){
	  console.log(video_source[i].file);
	} 
	
	// Play coubs
	var videoCount = video_source.length; 
	var videoId = 0;
	
  //var local_file = video_source[0].file;
  //local_file = local_file.split("/");
  //local_file = "video/" + local_file[local_file.length - 1];
	//document.getElementById(videoTag).setAttribute("src",local_file);
	document.getElementById(videoTag).setAttribute("src",video_source[0].file);
	function videoPlay(videoNum)
	{
    //local_file = video_source[videoNum].file;
    //local_file = local_file.split("/");
    //local_file = "video/" + local_file[local_file.length - 1];
	  //document.getElementById(videoTag).setAttribute("src",video_source[videoNum].file);
	  document.getElementById(videoTag).setAttribute("src",video_source[videoNum].file);
	  document.getElementById(videoTag).load();
	  document.getElementById(videoTag).play();
	}
	 
	document.getElementById(videoTag).addEventListener('ended',myHandler,false);
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
	//var search_coubs = 'php/searchcoubs.php';
	//var download_coubs = 'php/downloadcoubs.php';
	var local_json = 'php/apimongo.php';
	//var system_calls = 'php/systemcalls.php';

	// Default play video
	//coub.getCoubs(search_coubs, $scope.coubText).success(function(data){
	//	video_source = data.coubs;	
	//	playVideo(video_source, "myVideo");
	//});

	// Default play FonoTV video
	coub.getCoubsForFTV(local_json).success(function(data){
		video_source = data;	
		playVideo(video_source, "video-about");
	});

	// Search for video and insert it
  //$scope.fetch = function(){
	//	// Search for video
  //  coub.getCoubs(search_coubs, $scope.coubText).success(function(data){
  //    video_source = data.coubs;
	//		// Insert video in DOM
	//		playVideo(video_source, "myVideo");
  //  }); 
  //}

	//$scope.downloadCoub = function(){
	//	coub.getCoubs(download_coubs, $scope.coubPageUrl).success(function(data){
	//		$scope.coubVideoLink = data;
	//	});
	//}

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
