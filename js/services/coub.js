app.factory('coub', ['$http', function($http){

	var urlBase = 'php/searchcoubs.php';
	var coub = {};

	coub.getCoubs = function(){
    return $http.post(urlBase, {coubText: 'cats'})
    .success(function(data){
      return data;
    })
    .error(function(err){
      return err;
    });
	};
	
	return coub;

}]);
