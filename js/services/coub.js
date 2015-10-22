app.factory('coub', ['$http', function($http){

	var coub = {};

	//coub.getCoubs = function(phpScript, coubText){
	//	var urlBase = phpScript;
  //  return $http.post(urlBase, {coubText: coubText})
  //  .success(function(data){
  //    return data;
  //  })
  //  .error(function(err){
  //    return err;
  //  });
	//};
	
	coub.getCoubsForFTV = function(local_json){
    return $http.post(local_json)
    .success(function(data){
      return data;
    })
    .error(function(err){
      return err;
    });
	};
	
	coub.deleteDbFTV = function(system_calls, local_json){
		var urlBase = system_calls;
    return $http.post(urlBase, {coubDB: local_json})
    .success(function(data){
      return data;
    })
    .error(function(err){
      return err;
    });
	};
	
	return coub;

}]);
