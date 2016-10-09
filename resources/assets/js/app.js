
$(function() {
    /*AJAX Interceptor*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Everest.csrfToken
        }
    });
});

var app = angular.module('everest', []);

app.controller('PostCreatorCtrl', ['$scope', function($scope){
    $scope.form = {
        trip_type : 'short_distance'
    };
}]);

app.directive('postCreator', function(){
    return {
        restrict: 'E',
        templateUrl: '/templates/PostCreator.html',
        link: function(){
            componentHandler.upgradeAllRegistered();
        }
    };
});