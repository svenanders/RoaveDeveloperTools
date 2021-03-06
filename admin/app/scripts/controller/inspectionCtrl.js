'use strict';

angular
    .module('RoaveDeveloperToolsAdmin')
    .controller(
        'inspectionCtrl',
        ['$scope', '$routeParams', '$inspectionsRepository', 'RDT_REPORTS', function ($scope, $routeParams, $inspectionsRepository, RDT_REPORTS) {
        $scope.inspection     = null;
        $scope.subInspections = null;

        $inspectionsRepository.getInspectionById($routeParams.inspectionId).then(function (inspection) {
            $scope.inspection     = inspection;
            $scope.subInspections = inspection.getSubInspections();
        });

        // @todo should be an object, not just an array
        $scope.reports = RDT_REPORTS;
    }]);
