/**
 * Created by Sam on 06/11/2016.
 */

MyApp.controller("HomeController", function ($scope, $http)
{

	$scope.createProductInfo = {
		title       : "",
		description : ""
	};

	$scope.products        = null;
	$scope.productsLoading = false;
	$scope.productsError   = null;

	$scope.init = function ()
	{
		$scope.getProducts();
	}

	$scope.createProduct = function ()
	{
		var button = $('#create_product_button');
		buttonLoad(button, true);
		$http({
			method : 'POST',
			url    : '/api/product/create',
			data   : $scope.createProductInfo
		}).then(
			function success(response)
			{
				$scope.getProducts();
				buttonLoad(button, false);
				swal("Success!", response.data.message, "success");
			},
			function failed(response)
			{
				buttonLoad(button, false);
				swal("Error!", response.data.message ? response.data.message : 'Something went wrong... please try again!', "error");
			}
		);
	}

	$scope.getProducts = function ()
	{
		$scope.productsError   = null;
		$scope.productsLoading = true;
		$http({
			method : 'GET',
			url    : '/api/product/get'
		}).then(
			function success(response)
			{
				$scope.products        = response.data;
				$scope.productsLoading = false;
			},
			function failed(response)
			{
				$scope.productsLoading = false;
				$scope.productsError   = {
					message : response.data.message ? response.data.message : 'Something went wrong...'
				};
			}
		);
	}

});