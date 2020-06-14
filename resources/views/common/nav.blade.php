<audio id="mysound" src="{{asset('style/sound/not-bad.mp3')}}"></audio>
<!-- START HEADER -->
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light translation-button" data-activates="translation-dropdown">
                            <span class="flag-icon flag-icon-gb"></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen">
                            <i class="material-icons">settings_overscan</i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown">
                            <i class="material-icons">notifications_none
                                <small class="notification-contact"></small>
                            </i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                  <span class="avatar-status avatar-online">
                    <img src="{{asset(auth()->guard('admin')->user()->image)}}" alt="avatar">
                    <i></i>
                  </span>
                        </a>
                    </li>
                </ul>
                <!-- translation-button -->
                <ul id="translation-dropdown" class="dropdown-content">
                    <li>
                        <a href="{{asset('lang/en')}}" class="grey-text text-darken-1">
                            <i class="flag-icon flag-icon-gb"></i> {{trans('admin.english')}}</a>
                    </li>
                    <li>
                        <a href="{{asset('lang/ar')}}" class="grey-text text-darken-1">
                            <i class="flag-icon flag-icon-eg"></i> {{trans('admin.arabic')}}</a>
                    </li>
                </ul>
                <!-- notifications-dropdown -->
                <ul id="notifications-dropdown" class="dropdown-content">
                    <li>
                        <h6>{{trans('admin.notifications')}}
                            <!-- <span class="new badge">0</span> -->
                        </h6>
                    </li>
                    <li class="divider"></li>
                    @foreach(messageContact() as $message)
                    <li>
                        <a href="{{url(route('contacts'))}}" class="grey-text text-darken-2">
                            <span class="material-icons icon-bg-circle cyan small"><img src="{{asset($message->image)}}" class="circle responsive-img" width="22px"></span> {{$message->contact_subject}}</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">{{$message->created_at}}</time>
                    </li>
                    @endforeach
                </ul>
                <!-- profile-dropdown -->
                <ul id="profile-dropdown" class="dropdown-content">
                    <li>
                        <a href="{{url(route('edit_profile', auth()->guard('admin')->user()->id))}}" class="grey-text text-darken-1">
                            <i class="material-icons">face</i> {{trans('admin.profile')}}</a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="#" class="grey-text text-darken-1">--}}
{{--                            <i class="material-icons">settings</i> {{trans('admin.setting')}}</a>--}}
{{--                    </li>--}}
                    <li>
                        <form method="post" action="{{route('admin.logout')}}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <div>
                                   {{trans('admin.logout')}}
                            <i class="material-icons">keyboard_tab</i></button>
                            </div>
                          
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<!-- END HEADER -->
