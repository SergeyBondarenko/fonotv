app.factory('coub', ['$http', function($http){

	var coub = {};

	coub.getCoubs = function(phpScript, coubText){
		var urlBase = phpScript;
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
