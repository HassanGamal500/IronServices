@extends('common.index')
@section('page_title')
    {{trans('admin.dashboard')}}
@endsection
@section('content')
<section id="content">
    <!--start container-->
    <div class="container">
        <!--card stats start-->
        <div id="card-stats">
            <div class="row">
                @if(auth()->guard('admin')->user()->type == 2)
                <div class="col s12 m6 l3">
                    <a href="{{asset('/users')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">perm_identity</i>
                                    <p>{{trans('admin.users')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$users}}</h3>
                                    <!-- <p class="no-margin">New</p>
                                    <p>1,12,900</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <a href="{{asset('/orders')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">add_shopping_cart</i>
                                    <p>{{trans('admin.orders')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$orders}}</h3>
                                    <!-- <p class="no-margin">New</p>
                                    <p>6,00,00</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <a href="{{asset('/reminders')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">timeline</i>
                                    <p>{{trans('admin.reminders')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$reminders}}</h3>
                                    <!-- <p class="no-margin">Growth</p>
                                    <p>3,42,230</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <a href="{{asset('/rates')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">attach_money</i>
                                    <p>{{trans('admin.rates')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$rates}}</h3>
                                    <!-- <p class="no-margin">Today</p>
                                    <p>$25,000</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <a href="{{asset('/categories')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-deep-purple-blue gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">attach_money</i>
                                    <p>{{trans('admin.categories')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$categories}}</h3>
                                    <!-- <p class="no-margin">Today</p>
                                    <p>$25,000</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <a href="{{asset('/products')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-purple-amber gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">attach_money</i>
                                    <p>{{trans('admin.products')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$products}}</h3>
                                    <!-- <p class="no-margin">Today</p>
                                    <p>$25,000</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <a href="{{asset('/brands')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-brown-brown gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">attach_money</i>
                                    <p>{{trans('admin.brands')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$brands}}</h3>
                                    <!-- <p class="no-margin">Today</p>
                                    <p>$25,000</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @else
                <div class="col s12 m6 l3">
                    <a href="{{asset('/services')}}" style="text-decoration: none;">
                        <div class="card gradient-45deg-purple-amber gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">attach_money</i>
                                    <p>{{trans('admin.services')}}</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h3 class="mb-0">{{$allServices}}</h3>
                                    <!-- <p class="no-margin">Today</p>
                                    <p>$25,000</p> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">perm_identity</i>
                                <p>{{trans('admin.users')}}</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h3 class="mb-0">{{$users}}</h3>
                                <!-- <p class="no-margin">New</p>
                                <p>1,12,900</p> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">add_shopping_cart</i>
                                <p>{{trans('admin.orders')}}</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h3 class="mb-0">{{$orders}}</h3>
                                <!-- <p class="no-margin">New</p>
                                <p>6,00,00</p> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">timeline</i>
                                <p>{{trans('admin.reminders')}}</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h3 class="mb-0">{{$reminders}}</h3>
                                <!-- <p class="no-margin">Growth</p>
                                <p>3,42,230</p> -->
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!--card stats end-->
    </div>
</section>
@endsection
