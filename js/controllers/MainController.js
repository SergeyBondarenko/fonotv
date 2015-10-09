var videoSource = {};

app.controller('MainController', ['$scope', 'coub', function($scope, coub){
  coub.success(function(data){
    $scope.coubVideo = data.coubs;

    videoSource = data.coubs;

    // Test console output
    for(var i = 0; i < videoSource.length; i++){
      console.log(videoSource[i].file);
    } 

    // Play coubs
    var videoCount = videoSource.length; 
    var videoId = 0;
    
    document.getElementById("myVideo").setAttribute("src",videoSource[0].file);
    function videoPlay(videoNum)
    {
      document.getElementById("myVideo").setAttribute("src",videoSource[videoNum].file);
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

  });
}]);
