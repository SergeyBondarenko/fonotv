function playVideo(video_source){
	// Test console output
	for(var i = 0; i < video_source.length; i++){
	  console.log(video_source[i].file);
	} 
	
	// Play coubs
	var videoCount = video_source.length; 
	var videoId = 0;
	
	document.getElementById("myVideo").setAttribute("src",video_source[0].file);
	function videoPlay(videoNum)
	{
	  document.getElementById("myVideo").setAttribute("src",video_source[videoNum].file);
	  document.getElementById("myVideo").load();
	  document.getElementById("myVideo").play();
	}
	 
	document.getElementById('myVideo').addEventListener('ended',myHandler,false);
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
	$search_coubs = 'php/searchcoubs.php';
	$download_coubs = 'php/downloadcoubs.php';

	// Play default video
	coub.getCoubs($search_coubs, $scope.coubText).success(function(data){
		video_source = data.coubs;	
		playVideo(video_source);
	});

	// Search for video and insert it
  $scope.fetch = function(){
		// Search for video
    coub.getCoubs($search_coubs, $scope.coubText).success(function(data){
      video_source = data.coubs;
			// Insert video in DOM
			playVideo(video_source);
    }); 
  }

	$scope.downloadCoub = function(){
		coub.getCoubs($download_coubs, $scope.coubPageUrl).success(function(data){
			$scope.coubVideoLink = data;
		});
	}

}]);
