app.factory('coub', ['$http', function($http){
  return $http.get('php/searchcoubs.php')
  .success(function(data){
    return data;
  })
  .error(function(err){
    return err;
  });
}]);
