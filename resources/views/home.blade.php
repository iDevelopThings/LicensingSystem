@extends('layouts.app')

@section('content')
    <div class="container" ng-controller="HomeController" ng-init="init()">

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-plus"></i> Create Product
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <input type="text" ng-model="createProductInfo.title" placeholder="Product Title"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea name="" placeholder="Product Description" ng-model="createProductInfo.description"
                                      id="" cols="30" rows="5"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        <button class="btn btn-primary" id="create_product_button" ng-click="createProduct()">
                            <i class="fa fa-plus"></i> Create Product
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Your products
                    </div>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="product in products.data">
                            <th>@{{ product.title }}</th>
                            <td>@{{ product.description | limitTo:50 }}</td>
                            <td>@{{ product.created_at }}</td>
                            <td>
                                <ul class="list-inline" style="margin: 0">
                                    <li>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </li>
                                    <li>
                                        <a href="/product/view/@{{ product.id }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="/app/controllers/HomeController.js"></script>
@endsection
