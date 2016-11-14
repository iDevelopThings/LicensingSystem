/**
 * Created by Sam on 06/11/2016.
 */

MyApp.controller("ProductController", function ($scope, $http)
{

	$scope.users = null;
	$scope.keys  = null;

	$scope.productLoaded = false;
	$scope.page          = "product";

	$scope.viewingUser = null;

	/**
	 * The create new user input boxes
	 * @type {{name: string, email: string}}
	 */
	$scope.createUserInfo = {
		name  : "",
		email : ""
	};

	/**
	 * Our product information
	 * @type {{id: number}}
	 */
	$scope.product = {
		id      : 0,
		api_key : ""
	};

	/**
	 * Takes product id and starting page
	 * @param product_id
	 * @param page
	 */
	$scope.init = function (product_id, page)
	{
		$scope.product.id = product_id;
		$scope.page       = page;
		$scope.changePage(page);
		$scope.getProductInformation();

	}

	/**
	 * Get the products information
	 */
	$scope.getProductInformation = function ()
	{
		$scope.productLoaded = false;
		$http({
			method : 'GET',
			url    : '/api/product/get/' + $scope.product.id + '/info',
		}).then(
			function success(response)
			{
				$scope.product       = response.data;
				$scope.productLoaded = true;
			},
			function failed(response)
			{
				$scope.productLoaded = false;
			}
		);
	}

	/**
	 * Create product api key
	 */
	$scope.createApiKey = function (event)
	{
		var button = $(event.target);
		buttonLoad(button, true);
		$http({
			method : 'POST',
			url    : '/api/product/get/' + $scope.product.id + '/create_api_key',
		}).then(
			function success(response)
			{
				console.log(response.data);
				$scope.product.api_key = response.data.api_key;
				swal("Success!", response.data.message, "success");
				buttonLoad(button, false);
			},
			function failed(response)
			{
				buttonLoad(button, false);
				swal("Error!", response.data.message ? response.data.message : 'Something went wrong...', "error");
			}
		);

	}

	/**
	 * Gets the users for this project
	 */
	$scope.getUsers = function ()
	{
		$http({
			method : 'GET',
			url    : '/api/product/get/' + $scope.product.id + '/users',
		}).then(
			function success(response)
			{
				$scope.users = response.data;
			},
			function failed(response)
			{

			}
		);
	}

	/**
	 * Load the view user modal
	 *
	 * @param user_id
	 * @param $event
	 */
	$scope.viewUser = function (user_id, $event)
	{
		buttonLoad($($event.target), true);
		$http({
			method : 'GET',
			url    : '/api/product/get/' + $scope.product.id + '/user/' + user_id
		}).then(
			function success(response)
			{
				$scope.viewingUser = response.data;
				$('#view_user').modal('show');
				buttonLoad($($event.target), false);
			},
			function failed(response)
			{
				buttonLoad($($event.target), false);
				swal("Error!", response.data.message ? response.data.message : 'Something went wrong...', "error");
			}
		);
	}

	/**
	 * Create a new user
	 */
	$scope.createUser = function ()
	{
		if ($scope.createUserInfo.name == "")
		{
			swal("Error!", 'Please enter a name!', "error");
			return;
		}

		if ($scope.createUserInfo.email == "")
		{
			swal("Error!", 'Please enter an email!', "error");
			return;
		}

		var button = $('#create_user_button');
		buttonLoad(button, true);
		$http({
			method : 'POST',
			url    : '/api/product/get/' + $scope.product.id + '/create_user',
			data   : $scope.createUserInfo
		}).then(
			function success(response)
			{
				$scope.getUsers();
				$scope.getProductInformation();
				buttonLoad(button, false);
				swal("Success!", response.data.message, "success");
			},
			function failed(response)
			{
				buttonLoad(button, false);
				swal("Error!", response.data.message ? response.data.message : 'Something went wrong...', "error");
			}
		);

	}

	/**
	 * Deleting a specific user from the project
	 *
	 * @param user_id
	 * @param event
	 */
	$scope.deleteUser = function (user_id, event)
	{
		buttonLoad($(event.target), true);
		$http({
			method : 'POST',
			url    : '/api/product/get/' + $scope.product.id + '/user/' + user_id + '/delete'
		}).then(
			function success(response)
			{
				buttonLoad($(event.target), false);
				$scope.getProductInformation();
				$('#product_user_' + user_id).remove();
				swal("Success!", response.data.message, "success");
			},
			function failed(response)
			{
				buttonLoad($(event.target), false);
				swal("Error!", response.data.message ? response.data.message : 'Something went wrong... please try again!', "error");
			}
		);
	}

	/**
	 * Gets the keys for this project
	 */
	$scope.getKeys = function ()
	{
		$http({
			method : 'GET',
			url    : '/api/product/get/' + $scope.product.id + '/keys',
		}).then(
			function success(response)
			{
				$scope.keys = response.data;
			},
			function failed(response)
			{

			}
		);
	}

	/**
	 * Create a new product key
	 *
	 * @param event
	 */
	$scope.createKey = function (event)
	{
		var button = $(event.target);
		buttonLoad(button, true);
		$http({
			method : 'POST',
			url    : '/api/product/get/' + $scope.product.id + '/create_key'
		}).then(
			function success(response)
			{
				buttonLoad(button, false);
				$scope.getKeys();
				$scope.getProductInformation();
				swal("Success!", response.data.message, "success");
			},
			function failed(response)
			{
				buttonLoad(button, false);
				swal("Error!", response.data.message ? response.data.message : 'Something went wrong...', "error");
			}
		);

	}

	/**
	 * Changes the page
	 *
	 * @param page
	 */
	$scope.changePage = function (page)
	{
		$('#' + $scope.page).hide();
		$scope.page = page;
		$('#' + $scope.page).fadeIn();

		if (page == 'users')
		{
			$scope.getUsers();
		}
		if (page == 'keys')
		{
			$scope.getKeys();
		}
	}

});