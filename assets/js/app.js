// AngularJS application එක
var app = angular.module('eventApp', []);

app.controller('EventController', function ($scope, $http) {
    $scope.events = [];
    $scope.categories = [];
    $scope.searchText = '';
    $scope.selectedCategory = '';
    $scope.loading = true;
    $scope.error = false;

    // PHP API එකෙන් events ගන්නවා
    $http.get('api/get_events.php').then(function (response) {
        $scope.events = response.data;

        // අගයන් අංක බවට හරවනවා, categories එකතු කරනවා
        $scope.events.forEach(function (ev) {
            ev.available_seats = parseInt(ev.available_seats);
            ev.total_seats = parseInt(ev.total_seats);
            ev.ticket_price = parseFloat(ev.ticket_price);

            if ($scope.categories.indexOf(ev.category) === -1) {
                $scope.categories.push(ev.category);
            }
        });

        $scope.loading = false;
    }, function () {
        $scope.loading = false;
        $scope.error = true;
    });

    // Search box එකට සහ category එකට ගැළපෙනවාද බලනවා
    $scope.matchEvent = function (ev) {
        var text = $scope.searchText.toLowerCase();
        var matchesText = ev.title.toLowerCase().indexOf(text) !== -1 ||
                          ev.venue.toLowerCase().indexOf(text) !== -1;
        var matchesCategory = $scope.selectedCategory === '' ||
                              ev.category === $scope.selectedCategory;
        return matchesText && matchesCategory;
    };
});