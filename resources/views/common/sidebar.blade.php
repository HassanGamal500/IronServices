<aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a href="{{url('/')}}" class="brand-logo darken-1">
                <img src="{{asset('style/images/logo/materialize-logo.png')}}" alt="materialize logo">
                <span class="logo-text hide-on-med-and-down">Services</span>
            </a>
            <a href="#" class="navbar-toggler">
                <i class="material-icons">radio_button_checked</i>
            </a>
        </h1>
    </div>
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="no-padding">
            <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                    <a href="{{url('/')}}" class="waves-effect waves-cyan">
                        <i class="material-icons">mail_outline</i>
                        <span class="nav-text">{{trans('admin.dashboard')}}</span>
                    </a>
                </li>
                @if(auth()->guard('admin')->user()->type == 1)
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <i class="material-icons">dvr</i>
                            <span class="nav-text">{{trans('admin.services')}}</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{url('/services')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.services')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/add_service')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.add service')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @foreach(services() as $service)
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <i class="material-icons">dvr</i>
                                <span class="nav-text">{{$service->service_name}}</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    <li>
                                        <a href="{{url(route('service_client', $service->service_id))}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>{{$service->service_name}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url(route('add_service_client', $service->service_id))}}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>{{trans('admin.add')}} {{$service->service_name}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                    <li class="bold">
                        <a href="{{url('/cities')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.cities')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/areas')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.areas')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/contactsAdmin')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.contact')}}</span><small id="contactCountAdmin" class=""></small>
                        </a>
                    </li>
                @else
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <i class="material-icons">dvr</i>
                            <span class="nav-text">{{trans('admin.users')}}</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{url('/users')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.users')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/add_user')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.add user')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="bold">
                        <a href="{{url('/categories')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.categories')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/brands')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.brands')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/banners')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.banners')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <i class="material-icons">dvr</i>
                            <span class="nav-text">{{trans('admin.products')}}</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{url('/products')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.products')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/add_product')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.add product')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="bold">
                        <a href="{{url('/orders')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.orders')}}</span><small id="orderCount" class=""></small>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/reminders')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.reminders')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan">
                            <i class="material-icons">dvr</i>
                            <span class="nav-text">{{trans('admin.notifications')}}</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{url('/notifications')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.notifications')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/add_notification')}}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>{{trans('admin.add notification')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="bold">
                        <a href="{{url('/edit_page')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.pages')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/contacts')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.contact')}}</span><small id="contactCount" class=""></small>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/contact')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.contact us')}}</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a href="{{url('/rates')}}" class="waves-effect waves-cyan">
                            <i class="material-icons">mail_outline</i>
                            <span class="nav-text">{{trans('admin.rates')}}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only gradient-45deg-light-blue-cyan gradient-shadow">
        <i class="material-icons">menu</i>
    </a>
</aside>
