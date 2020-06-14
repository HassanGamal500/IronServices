@extends('common.index')
@section('page_title')
{{trans('admin.edit profile')}}
@endsection
@section('content')
<section id="content">
    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper">
        <!-- Search for small screen -->
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">{{trans('admin.edit profile')}}</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{trans('/')}}">{{trans('admin.dashboard')}}</a></li>
                        <li class="active">{{trans('admin.edit profile')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12">
                    <div class="card-panel">
                        <h4 class="header2">{{trans('admin.edit profile')}}</h4>
                        <div class="row">
                            @if(session()->has('message'))
                            <div id="card-alert" class="card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">check</i> {{session()->get('message')}}</p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @elseif(session()->has('error'))
                            <div id="card-alert" class="card gradient-45deg-red-pink">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">error</i> {{session()->get('error')}}</p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            <form class="col s12" method="post" action="{{route('update_profile', $id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">account_circle</i>
                                        <input id="name3" type="text" name="name" value="{{$users->name}}" required>
                                        <label for="first_name">{{trans('admin.name')}}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">phone</i>
                                        <input id="phone3" type="tel" pattern="^[0-9]+$" name="phone" value="{{$users->phone}}" required>
                                        <label for="phone">{{trans('admin.phone')}}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">email</i>
                                        <input id="email3" type="email" name="email" value="{{$users->email}}" required>
                                        <label for="email">{{trans('admin.email')}}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="file-field input-field col s10">
                                        <div class="btn">
                                            <span>{{trans('admin.upload photo')}}</span>
                                            <input type="file" name="image" id="image-selecter">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text">
                                        </div>
                                    </div>
                                    <div class="col s2">
                                        <br>
                                        <input type="hidden" name="old_image" value="{{asset($users->image)}}">
                                        <img src="{{asset($users->image)}}" class="img-thumbnail" height="100px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">lock_outline</i>
                                        <input id="password3" type="password" name="password">
                                        <label for="password">{{trans('admin.password')}}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">{{trans('admin.submit')}}
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end container-->
</section>

@endsection
