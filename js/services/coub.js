app.factory('coub', ['$http', function($http){

	var urlBase = 'php/searchcoubs.php';
	var coub = {};

	coub.getCoubs = function(coubText){
    return $http.post(urlBase, {coubText: coubText})
    .success(function(data){
      return data;
    })
    .error(function(err){
      return err;
    });
	};
	
	return coub;

}]);
