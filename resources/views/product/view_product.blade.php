@extends('layouts.app')

@section('content')
    <div class="container-fluid" ng-controller="ProductController" ng-init="init('{{$product->id}}','product')">

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Navigation
                    </div>
                    <ul class="list-group">
                        <li style="list-style-type: none;">
                            <a href="javascript:;" ng-click="changePage('product')"
                               class="list-group-item @{{ page === 'product' ? 'active' : '' }}">
                                Product
                            </a>
                        </li>
                        <li style="list-style-type: none;">
                            <a href="javascript:;" ng-click="changePage('users')"
                               class="list-group-item @{{ page === 'users' ? 'active' : '' }}">
                                Users
                            </a>
                        </li>
                        <li style="list-style-type: none;">
                            <a href="javascript:;" ng-click="changePage('keys')"
                               class="list-group-item @{{ page === 'keys' ? 'active' : '' }}">
                                Keys
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">

                <div ng-if="productLoaded == false" class="panel panel-body text-center">
                    <h1><i class="fa fa-spin fa-spinner"></i></h1>
                </div>

                <div ng-if="productLoaded == true">

                    <div ng-if="page === 'product'">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="panel panel-body">
                                    <h1 class="text-center" ng-if="product.api_key == ''">
                                        You have not set an api key yet!
                                        <br>
                                        <small>
                                            Click
                                            <button class="btn btn-sm btn-primary" ng-click="createApiKey($event)">here
                                            </button>
                                            to create one!
                                        </small>
                                    </h1>
                                    <h1 class="text-center" ng-if="product.api_key != ''">
                                        Click
                                        <button class="btn btn-sm btn-primary" ng-click="createApiKey($event)">here
                                        </button>
                                        to reset your api key!
                                    </h1>

                                    <div class="form-group text-center center-block" ng-if="product.api_key != ''">
                                        <label for="">Your product api key</label>
                                        <input type="text" disabled value="@{{ product.api_key }}" style="width: 300px;"
                                               class="form-control center-block">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-body text-center">
                                    <h1>
                                        @{{ product.user_count | number}}
                                        <br>
                                        <small>
                                            <i class="fa fa-users"></i> Users
                                        </small>
                                    </h1>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-body text-center">
                                    <h1>
                                        @{{ product.key_count | number}}
                                        <br>
                                        <small>
                                            <i class="fa fa-key"></i> Keys
                                        </small>
                                    </h1>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-code"></i> Api Info
                                    </div>
                                    <div class="panel-body">

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Product Endpoints
                                            </div>
                                            <div class="panel-body">

                                                <div class="panel-group" id="accordion" role="tablist"
                                                     aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordion" href="#collapseOne"
                                                                   aria-expanded="true" aria-controls="collapseOne">
                                                                    <span class="label label-info">POST</span>
                                                                    /product/{product_id}/use_key/{key}?token={user_token}
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in"
                                                             role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <p style="font-size: 17px;">
                                                                    Your application can hit this url with a
                                                                    <strong>key</strong> and <strong>user_token</strong>
                                                                    to activate a key on a users account
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button"
                                                                   data-toggle="collapse" data-parent="#accordion"
                                                                   href="#collapseTwo" aria-expanded="false"
                                                                   aria-controls="collapseTwo">
                                                                    <span class="label label-info">POST</span>
                                                                    /product/{product_id}/check_key
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse"
                                                             role="tabpanel" aria-labelledby="headingTwo">
                                                            <div class="panel-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high
                                                                life accusamus terry richardson ad squid. 3 wolf moon
                                                                officia aute, non cupidatat skateboard dolor brunch.
                                                                Food truck quinoa nesciunt laborum eiusmod. Brunch 3
                                                                wolf moon tempor, sunt aliqua put a bird on it squid
                                                                single-origin coffee nulla assumenda shoreditch et.
                                                                Nihil anim keffiyeh helvetica, craft beer labore wes
                                                                anderson cred nesciunt sapiente ea proident. Ad vegan
                                                                excepteur butcher vice lomo. Leggings occaecat craft
                                                                beer farm-to-table, raw denim aesthetic synth nesciunt
                                                                you probably haven't heard of them accusamus labore
                                                                sustainable VHS.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div ng-if="page === 'users'">


                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Create User
                                    </div>
                                    <div class="panel panel-body">

                                        <div class="form-group">
                                            <input type="text" ng-model="createUserInfo.name" class="form-control"
                                                   placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" ng-model="createUserInfo.email"
                                                   placeholder="Email">
                                        </div>

                                    </div>
                                    <div class="panel-footer clearfix">
                                        <button class="btn btn-primary pull-right" ng-click="createUser()"
                                                id="create_user_button">
                                            <i class="fa fa-plus"></i> Create User
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Users
                                    </div>

                                    <div ng-if="users != null">

                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="user in users.data" id="product_user_@{{ user.id }}">
                                                <th>@{{ user.name }}</th>
                                                <td>@{{ user.email }}</td>
                                                <td>@{{ user.created_at }}</td>
                                                <td>
                                                    <ul class="list-inline" style="margin: 0;">
                                                        <li>
                                                            <button class="btn btn-sm btn-danger"
                                                                    ng-click="deleteUser(user.id, $event)">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-sm btn-primary"
                                                                    ng-click="viewUser(user.id, $event)">
                                                                <i class="fa fa-eye"></i> View
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div ng-if="users == null" class="text-center">
                                        <h2 class="text-center">Cannot load users</h2>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="view_user" tabindex="-1" role="dialog"
                             aria-labelledby="view_userLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="view_userLabel">
                                            Viewing @{{ viewingUser.user.name }}</h4>
                                    </div>
                                    <div class="modal-body">

                                        <dl class="dl-horizontal">
                                            <dt>Name</dt>
                                            <dd>@{{ viewingUser.user.name }}</dd>

                                            <dt>Email</dt>
                                            <dd>@{{ viewingUser.user.email }}</dd>

                                            <dt>Registered</dt>
                                            <dd>@{{ viewingUser.user.created_at }}</dd>
                                        </dl>

                                        <hr>

                                        <div ng-if="viewingUser.keys.length == 0">
                                            <h3 class="text-center">
                                                No keys activated!
                                            </h3>
                                        </div>
                                        <div ng-if="viewingUser.keys.length > 0">
                                            <div class="panel panel-body" ng-repeat="key in viewingUser.keys"
                                                 style="border: solid 1px #eaeaea;">
                                                <strong>@{{ key.key | limitTo:4 }}**********</strong>
                                                <span class="label label-info pull-right">
                                                    Activated about <strong>@{{ key.claimed_at_diff }}</strong>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div ng-if="page === 'keys'">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Create Key
                                    </div>
                                    <div class="panel panel-body">

                                        <div class="form-group">
                                            <input type="date" class="form-control">
                                        </div>

                                        <button class="btn btn-primary btn-block" ng-click="createKey($event)">
                                            <i class="fa fa-plus"></i> Create Key
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Keys
                                    </div>

                                    <div ng-if="keys != null">

                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Claimed By?</th>
                                                <th>Claimed At?</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="key in keys.data" id="product_key_@{{ key.id }}">
                                                <th>@{{ key.key }}</th>
                                                <td>@{{ key.claimed_by == null ? 'No one' : 'Someone' }}</td>
                                                <td>@{{ key.claimed_at == null ? 'Not Claimed' : key.claimed_at }}</td>
                                                <td>@{{ key.created_at }}</td>
                                                <td>
                                                    <ul class="list-inline" style="margin: 0;">
                                                        <li>
                                                            <button class="btn btn-sm btn-danger"
                                                                    ng-click="deleteUser(user.id, $event)">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-sm btn-primary">
                                                                <i class="fa fa-eye"></i> View
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div ng-if="users == null" class="text-center">
                                        <h2 class="text-center">Cannot load users</h2>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>
@endsection

@section('js')
    <script src="/app/controllers/Product/ProductController.js"></script>
@endsection
