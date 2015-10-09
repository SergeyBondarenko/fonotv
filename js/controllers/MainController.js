app.controller('MainController', ['$scope', 'coub', function($scope, coub){
  coub.success(function(data){
    $scope.coubVideo = data; 
  });
}]);
