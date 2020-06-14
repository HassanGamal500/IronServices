

<!-- jQuery Library -->
{{--<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
{{--<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.semanticui.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>--}}
<script type="text/javascript" src="{{asset('style/vendors/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="{{asset('style/js/slick.min.js')}}"></script>
<!--materialize js-->
<script type="text/javascript" src="{{asset('style/js/materialize.min.js')}}"></script>
<!--prism-->
<script type="text/javascript" src="{{asset('style/vendors/prism/prism.js')}}"></script>
<!--scrollbar-->
<script type="text/javascript" src="{{asset('style/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{asset('style/vendors/sweetalert/dist/sweetalert.min.js')}}"></script>
<!-- data-tables -->
<script type="text/javascript" src="{{asset('style/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
<!--data-tables.js - Page Specific JS codes -->
<script type="text/javascript" src="{{asset('style/js/scripts/data-tables.js')}}"></script>
<!-- chartjs -->
<script type="text/javascript" src="{{asset('style/vendors/chartjs/chart.min.js')}}"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="{{asset('style/js/plugins.js')}}"></script>
<!--extra-components-sweetalert.js - Some Specific JS-->
<script type="text/javascript" src="{{asset('style/js/scripts/extra-components-sweetalert.js')}}"></script>
<!--advanced-ui-modals.js - Some Specific JS codes -->
<script type="text/javascript" src="{{asset('style/js/scripts/advanced-ui-modals.js')}}"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="{{asset('style/js/custom-script.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('style/js/scripts/dashboard-ecommerce.js')}}"></script>--}}
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<!--Select 2-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-app.js"></script>


<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-analytics.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-messaging.js"></script>




<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyCg2P-ax3ekqBkk6M8u-zXkbdyb65pd7cs",
        authDomain: "reservation-faffa.firebaseapp.com",
        databaseURL: "https://reservation-faffa.firebaseio.com",
        projectId: "reservation-faffa",
        storageBucket: "reservation-faffa.appspot.com",
        messagingSenderId: "345267501157",
        appId: "1:345267501157:web:4a019585bf1c56393c6e8c",
        measurementId: "G-ZBT1031YK0"
    };
    
    firebase.initializeApp(firebaseConfig);
    
    if(firebase.messaging.isSupported()) {
        const messaging = firebase.messaging();

        // Add the public key generated from the console here.
        messaging.usePublicVapidKey("BIkjfKt7n0NdZjP-7VBLtsarTIKqknDJpbtgqj7o8wqFVVRZ0x5lous_yPhtVcJ7sRHMOVPpo8EAkrXNLsxDejA");
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Notification permission granted.');
                // TODO(developer): Retrieve an Instance ID token for use with FCM.
                getRegisterToken();
                // ...
            } else {
                console.log('Unable to get permission to notify.');
            }
        });
        
        function getRegisterToken() {
            // Get Instance ID token. Initially this makes a network call, once retrieved
            // subsequent calls to getToken will return from cache.
            messaging.getToken().then((currentToken) => {
                if (currentToken) {
                    saveToken(currentToken);
                    console.log(currentToken);
                    sendTokenToServer(currentToken);
                    // updateUIForPushEnabled(currentToken);
                } else {
                    // Show permission request.
                    console.log('No Instance ID token available. Request permission to generate one.');
                    // Show permission UI.
                    // updateUIForPushPermissionRequired();
                    setTokenSentToServer(false);
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
                // showToken('Error retrieving Instance ID token. ', err);
                setTokenSentToServer(false);
            });
        }
    
        
        // // Callback fired if Instance ID token is updated.
        // messaging.onTokenRefresh(() => {
        //     messaging.getToken().then((refreshedToken) => {
        //         console.log('Token refreshed.');
        //         // Indicate that the new Instance ID token has not yet been sent to the
        //         // app server.
        //         setTokenSentToServer(false);
        //         // Send Instance ID token to app server.
        //         sendTokenToServer(refreshedToken);
        //         // ...
        //     }).catch((err) => {
        //         console.log('Unable to retrieve refreshed token ', err);
        //         // showToken('Unable to retrieve refreshed token ', err);
        //     });
        // });
        
        // Send the Instance ID token your application server, so that it can:
        // - send messages back to this app
        // - subscribe/unsubscribe the token from topics
        function sendTokenToServer(currentToken) {
            if (!isTokenSentToServer()) {
                console.log('Sending token to server...');
                // TODO(developer): Send the current token to your server.
                setTokenSentToServer(true);
            } else {
                console.log('Token already sent to server so won\'t send it again ' + 'unless it changes');
            }
        }
        
        function isTokenSentToServer() {
            return window.localStorage.getItem('sentToServer') === '1';
        }
        
        function setTokenSentToServer(sent) {
            window.localStorage.setItem('sentToServer', sent ? '1' : '0');
        }
        
        function saveToken(currentToken){
            jQuery.ajax({
                data: {"token":currentToken},
                type: "post",
                url: '{{url(route('getToken'))}}',
                success: function(result){
                    console.log(result);
                }
            });
        }
        
        function type(){
            jQuery.ajax({
                type: "get",
                url: '{{url(route('getType'))}}',
                success: function(result){
                    console.log(result);
                    if(result == 1){
                        
                        $.ajax({
                            cache: false,
                            type: 'GET',
                            url: '{{ url(route('contact_count')) }}',
                            success:function(data){
                                if(data > 0){
                                    $('.notification-badge').text(data);
                                    $('.new.badge').text(data);
                                    $('.contactCount').addClass('btn btn-floating pulse red right').text(data);
                                }
                            }
                        });
                        
                        $.ajax({
                            cache: false,
                            type: 'POST',
                            url: '{{ url(route('contact_notify')) }}',
                            success:function(data){
                                document.getElementById('mysound').play();
                            }
                        });
                        
                        swal("{{trans('admin.new contact')}}");
                        
                    } else {
                        
                        $.ajax({
                            cache: false,
                            type: 'POST',
                            url: '{{ url(route('order_count')) }}',
                            success:function(data){
                                if(data > 0){
                                    $('#orderCount').removeClass('btn btn-floating pulse red right').text('');
                                    $('#orderCount').addClass('btn btn-floating pulse red right').text(data);
                                }
                            }
                        });
                        
                        $.ajax({
                            cache: false,
                            type: 'POST',
                            url: '{{ url(route('order_notify')) }}',
                            success:function(data){
                                document.getElementById('mysound').play();
                            }
                        });
                        
                        swal("{{trans('admin.new order')}}");
                        
                    }
                }
            });
        }
        
        messaging.onMessage(function(payload) {
            console.log('Message received. ', payload);
            type();
            var title =payload.data.title;
            
            var options ={
                body: payload.data.body,
                icon: payload.data.icon,
                image: payload.data.image,
                data:{
                    time: new Date(Date.now()).toString(),
                    click_action: payload.data.click_action
                }
            };
            var myNotification = new Notification(title, options);
        });
    } else {
        console.log('Firebase Is Not Support');
    }


    $(document).ready(function() {

        $(".searchOption2").select2( {
            placeholder: "Select Email",
            allowClear: true,
            width: 'resolve'
        } );

        //delete row
        // $(".delete").on('click', function () {
        //     $(this).parents('tr').remove();
        //
        // })

        $('#selectOption').on('change', function(){
            if ($(this).val() == '2') {
                $('#show_hide').removeClass('hide');
            } else {
                $('#show_hide').addClass('hide');
            }
        });



        

        $('#selectPrice').on('change', function(){
            if ($(this).val() == '2') {
                // alert("accepted");
                $('#y').removeClass('hide');
                $(".x").prop('required',true);
            } else { 
                // alert("rejected");
                $('#y').addClass('hide');
                $('.x').prop('required', false);
            }
        });

        // $('select').formSelect();


        CKEDITOR.replace( 'example1' );
        CKEDITOR.replace( 'example2' );

        $('.slide_show').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });

        $('#dataTableUser').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.alerts', function(e){
            var url = $(this).data("url");
            var id = $(this).data("id");
            var table = '.' + $(this).data('table');
            var thisClick = $(this).parents('tr');
            // var classRaw = '#' + id;
            e.preventDefault();
            console.log(table);
            // var datatable = $(table).DataTable();
            // datatable.row($(this).parents('tr')).remove().draw();
            swal({   title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: 'DELETE',
                            url: url+id,
                            data: {id: id},
                            success:function(data){
                                var datatable = $(table).DataTable();
                                datatable.row(thisClick).remove().draw();
                            }
                        });
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    }
                    else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        });

        // $(document).on('click', '.alerts', function(e){
        //     var url = $(this).data("url");
        //     var id = $(this).data("id");
        //     e.preventDefault();
        //     swal({   title: "Are you sure?",
        //             text: "You will not be able to recover this imaginary file!",
        //             type: "warning",
        //             showCancelButton: true,
        //             confirmButtonColor: "#DD6B55",
        //             confirmButtonText: "Yes, delete it!",
        //             cancelButtonText: "No, cancel plx!",
        //             closeOnConfirm: false,
        //             closeOnCancel: false },
        //         function(isConfirm){
        //             if (isConfirm) {
        //                 $.ajax({
        //                     type: 'DELETE',
        //                     url: url+id,
        //                     data: {id: id},
        //                     success:function(data){
        //                         var datatable = $('.dataTableCity').DataTable();
        //                         datatable.row($('.alerts').parents('tr')).remove().draw();
        //                     }
        //                 });
        //                 swal("Deleted!", "Your imaginary file has been deleted.", "success");
        //             }
        //             else {
        //                 swal("Cancelled", "Your imaginary file is safe :)", "error");
        //             }
        //         });
        // });

        $.ajax({
            cache: false,
            type: 'GET',
            url: '{{ url(route('order_count')) }}',
            success:function(data){
                if(data > 0){
                    $('#orderCount').removeClass('btn btn-floating pulse red right').text('');
                    $('#orderCount').addClass('btn btn-floating pulse red right').text(data);
                }
            }
        });
        
        $.ajax({
            cache: false,
            type: 'GET',
            url: '{{ url(route('contact_count')) }}',
            success:function(data){
                if(data > 0){
                    $('.notification-contact').addClass('notification-badge').text(data);
                    $('.new.badge').text(data);
                    $('#contactCount').addClass('btn btn-floating pulse red right').text(data);
                }
            }
        });

        $.ajax({
            cache: false,
            type: 'GET',
            url: '{{ url(route('contact_countAdmin')) }}',
            success:function(data){
                if(data > 0){
                    $('.notification-contact').addClass('notification-badge').text(data);
                    $('.new.badge').text(data);
                    $('#contactCountAdmin').addClass('btn btn-floating pulse red right').text(data);
                }
            }
        });


        {{--var old_notifty = 0;--}}
        {{--setInterval(function(){--}}
        {{--    $.ajax({--}}
        {{--        cache: false,--}}
        {{--        type: 'POST',--}}
        {{--        url: '{{ url(route('contact_notify')) }}',--}}
        {{--        success:function(data){--}}
        {{--            if (data > old_notifty) {--}}
        {{--                old_notifty = data;--}}
        {{--                document.getElementById('mysound').play();--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}, 2000);--}}

        {{--var old_count = 0;--}}
        {{--setInterval(function(){--}}
        {{--    $.ajax({--}}
        {{--        cache: false,--}}
        {{--        type: 'GET',--}}
        {{--        url: '{{ url(route('contact_count')) }}',--}}
        {{--        success:function(data){--}}
        {{--            if (data > old_count) {--}}
        {{--                $('.notification-badge').text(data);--}}
        {{--                $('.new.badge').text(data);--}}
        {{--                $('.contactCount').addClass('btn btn-floating pulse red right').text(data);--}}
        {{--                old_count = data;--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}, 2000);--}}

        {{--var old_notifty_order = 0;--}}
        {{--setInterval(function(){--}}
        {{--    $.ajax({--}}
        {{--        cache: false,--}}
        {{--        type: 'POST',--}}
        {{--        url: '{{ url(route('order_notify')) }}',--}}
        {{--        success:function(data){--}}
        {{--            if (data > old_notifty_order) {--}}
        {{--                old_notifty_order = data;--}}
        {{--                document.getElementById('mysound').currentTime=0;--}}
        {{--                document.getElementById('mysound').play();--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}, 2000);--}}

        {{--var old_order = 0;--}}
        {{--setInterval(function(){--}}
        {{--    $.ajax({--}}
        {{--        cache: false,--}}
        {{--        type: 'GET',--}}
        {{--        url: '{{ url(route('order_count')) }}',--}}
        {{--        success:function(data){--}}
        {{--            if (data > old_order) {--}}
        {{--                $('#orderCount').removeClass('btn btn-floating pulse red right').text('');--}}
        {{--                $('#orderCount').addClass('btn btn-floating pulse red right').text(data);--}}
        {{--                old_order = data;--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}, 2000)--}}
    } );
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Load Image
    $('#image-selecter').change(function(){

        let reader = new FileReader();
        reader.onload = (e) => {
            $('#image_preview_container').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);

    });
    // Load Logo
    $('#image-logo').change(function(){

        let reader = new FileReader();
        reader.onload = (e) => {
            $('#image_preview_container_logo').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);

    });
    // Modal add user Store
    $('#submit_user').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('#dataTableUser').DataTable();
        if(typeof(name) != "undefined" && name !== null){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{url('add_user')}}',
                data: form_data,
                cache:false,
                processData: false,
                contentType: false,
                success: function(data){
                    // console.log(data);
                    $('#add_user').modal('close');
                    $(".name").val('');
                    $(".email").val('');
                    $(".phone").val('');
                    $(".image").val('');
                    $('#image_preview_container').attr('src', '{{ asset("image/user_avatar.png") }}');
                    $(".password").val('');
                    if(data['status'] == 1){
                        // console.log(data);
                        datatable.clear();
                        var i;
                        for (i = 0; i < data['data'].length; i++) {
                            datatable.row.add( [
                                i+1,
                                data['data'][i].name,
                                data['data'][i].email,
                                data['data'][i].phone,
                                '<img class="materialboxed" width="60" src="' + '{{asset("")}}/' + data['data'][i].image + '">'
                            ] ).draw(false);
                        }
                        swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                    } else {
                        swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                    }
                },
                error: function(data){
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            });
        }
    });
    // Modal Edit User Show
    $(document).on('click', '.get_edit', function() {
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('get_user')}}',
            data: {'id': id},
            success: function(data){
                console.log(data);
                $(".edit_name").val(data.name);
                $(".edit_email").val(data.email);
                $(".edit_phone").val(data.phone);
                $(".edit_image").attr('src', '{{ asset('data.image') }}');
                $('.edit_user').modal('open');
            }
        });
    });

    //-----------------------------------------------------------------------

    // Modal add City Store
    $('#submit_city').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableCity').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('add_city')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#add_city').modal('close');
                $(".city_name").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_city" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_city')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableCity"><i class="material-icons">clear</i></a>'
                        ] ).draw(false).node();
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });

    // Modal Edit City Show
    $(document).on('click', '.edit_city', function() {
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('edit_city')}}',
            data: {'id': id},
            success: function(data){
                console.log(data);
                $(".city_id").val(data[0].id);
                $(".city_name_first").val(data[0].name);
                $(".city_name_second").val(data[1].name);
                $('#edit_city').modal('open');
            }
        });
    });

    $('#update_city').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableCity').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('update_city')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#edit_city').modal('close');
                $(".city_name").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_city" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_city')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableCity"><i class="material-icons">clear</i></a>'
                        ] ).draw(false);
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });



//-----------------------------------------------------


    // Modal add Area Store
    $('#submit_area').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableArea').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('add_area')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#add_area').modal('close');
                $(".area_name").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            data['data'][i].city_name,
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_area" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_area')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableArea"><i class="material-icons">clear</i></a>'
                        ] ).draw(false).node();
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });

    // Modal Edit Area Show
    $(document).on('click', '.edit_area', function() {
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('edit_area')}}',
            data: {'id': id},
            success: function(data){
                console.log(data);
                $(".area_id").val(data[0].id);
                $(".area_name_first").val(data[0].name);
                $(".area_name_second").val(data[1].name);
                $('#edit_area').modal('open');
            }
        });
    });

    $('#update_area').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableArea').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('update_area')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#edit_area').modal('close');
                $(".area_name").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            data['data'][i].city_name,
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_area" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_area')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableArea"><i class="material-icons">clear</i></a>'
                        ] ).draw(false);
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });


    // ---------------------------------------------------------------------

    // Modal add Category Store
    $('#submit_category').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableCategory').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('add_category')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#add_category').modal('close');
                $(".category_name").val('test');
                $(".category_color").val('test');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            data['data'][i].color,
                            '<img class="materialboxed" width="60" src="' + '{{asset("")}}/' + data['data'][i].image + '">',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_category" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_category')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableCategory"><i class="material-icons">clear</i></a>'
                        ] ).draw(false).node();
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });

    // Modal Edit Category Show
    $(document).on('click', '.edit_category', function() {
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('edit_category')}}',
            data: {'id': id},
            success: function(data){
                console.log(data);
                $(".category_id").val(data[0].id);
                $(".old_image").val(data[0].image);
                $(".category_name_first").val(data[0].name);
                $(".category_name_second").val(data[1].name);
                $(".category_color").val(data[0].color);
                $('#edit_category').modal('open');
            }
        });
    });

    $('#update_category').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableCategory').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('update_category')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#edit_category').modal('close');
                $(".category_name").val('');
                $(".category_color").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            data['data'][i].color,
                            '<img class="materialboxed" width="60" src="' + '{{asset("")}}/' + data['data'][i].image + '">',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_category" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_category')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableCategory"><i class="material-icons">clear</i></a>'
                        ] ).draw(false);
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });


    // -----------------------------------------------------------------------


    // Modal add Brand Store
    $('#submit_brand').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableBrand').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('add_brand')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#add_brand').modal('close');
                $(".brand_name").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_brand" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_brand')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableBrand"><i class="material-icons">clear</i></a>'
                        ] ).draw(false).node();
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });

    // Modal Edit City Show
    $(document).on('click', '.edit_brand', function() {
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('edit_brand')}}',
            data: {'id': id},
            success: function(data){
                console.log(data);
                $(".brand_id").val(data[0].id);
                $(".brand_name_first").val(data[0].name);
                $(".brand_name_second").val(data[1].name);
                $('#edit_brand').modal('open');
            }
        });
    });

    $('#update_brand').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableBrand').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('update_brand')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#edit_brand').modal('close');
                $(".brand_name").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            data['data'][i].name,
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_brand" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_brand')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableBrand"><i class="material-icons">clear</i></a>'
                        ] ).draw(false);
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });


    //----------------------------------------------------------------------


    // Modal add Banner Store
    $('#submit_banner').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableBanner').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('add_banner')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#add_banner').modal('close');
                // $(".validate").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            '<img class="materialboxed" width="60" src="' + '{{asset("")}}/' + data['data'][i].image + '">',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_banner" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_brand')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableBanner"><i class="material-icons">clear</i></a>'
                        ] ).draw(false).node();
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });

    {{--// Modal Edit Banner Show--}}
    {{--$(document).on('click', '.edit_banner', function() {--}}
    {{--    var id = $(this).attr("data-id");--}}
    {{--    console.log(id);--}}
    {{--    $.ajax({--}}
    {{--        type: "POST",--}}
    {{--        dataType: "json",--}}
    {{--        url: '{{url('edit_banner')}}',--}}
    {{--        data: {'id': id},--}}
    {{--        success: function(data){--}}
    {{--            console.log(data);--}}
    {{--            $(".banner_id").val(data[0].id);--}}
    {{--            $('#edit_banner').modal('open');--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

    {{--$('#update_banner').on('submit', function(e) {--}}
    {{--    e.preventDefault();--}}
    {{--    var form_data = new FormData(this);--}}
    {{--    var datatable = $('.dataTableBanner').DataTable();--}}
    {{--    $.ajax({--}}
    {{--        type: "POST",--}}
    {{--        dataType: "json",--}}
    {{--        url: '{{url('update_banner')}}',--}}
    {{--        data: form_data,--}}
    {{--        cache:false,--}}
    {{--        processData: false,--}}
    {{--        contentType: false,--}}
    {{--        success: function(data){--}}
    {{--            console.log(data);--}}
    {{--            $('#edit_banner').modal('close');--}}
    {{--            // $(".validate").val('');--}}
    {{--            if(data['status'] == 1){--}}
    {{--                // console.log(data);--}}
    {{--                datatable.clear();--}}
    {{--                var i;--}}
    {{--                for (i = 0; i < data['data'].length; i++) {--}}
    {{--                    var trDOM = datatable.row.add( [--}}
    {{--                        i+1,--}}
    {{--                        '<img class="materialboxed" width="60" src="' + data['data'][i].image + '">',--}}
    {{--                        '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_banner" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',--}}
    {{--                        '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('admin/delete_banner')}}/" data-id="'+data['data'][i].id+'"><i class="material-icons">clear</i></a>'--}}
    {{--                    ] ).draw(false);--}}
    {{--                    $( trDOM ).addClass(''+data['data'][i].id);--}}
    {{--                }--}}
    {{--                swal("{{trans('admin.Inserted Successfully!')}}", "", "success");--}}
    {{--            } else {--}}
    {{--                swal("{{trans('admin.ERROR!')}}", data['message'], "error");--}}
    {{--            }--}}
    {{--        },--}}
    {{--        error: function(data){--}}
    {{--            swal("{{trans('admin.ERROR!')}}", data['message'], "error");--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}


    //----------------------------------------------------------------------


    // Modal add Image Store
    $('#submit_image').on('submit', function(e) {
        e.preventDefault();
        var form_data = new FormData(this);
        var datatable = $('.dataTableImage').DataTable();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('add_image')}}',
            data: form_data,
            cache:false,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                $('#add_image').modal('close');
                // $(".validate").val('');
                if(data['status'] == 1){
                    // console.log(data);
                    datatable.clear();
                    var i;
                    for (i = 0; i < data['data'].length; i++) {
                        var trDOM = datatable.row.add( [
                            i+1,
                            '<img class="materialboxed" width="60" src="' + '{{asset("")}}/' + data['data'][i].image + '">',
                            '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('delete_image')}}/" data-id="'+data['data'][i].id+'" data-table="dataTableImage"><i class="material-icons">clear</i></a>'
                        ] ).draw(false).node();
                        $( trDOM ).addClass(''+data['data'][i].id);
                    }
                    swal("{{trans('admin.Inserted Successfully!')}}", "", "success");
                } else {
                    swal("{{trans('admin.ERROR!')}}", data['message'], "error");
                }
            },
            error: function(data){
                swal("{{trans('admin.ERROR!')}}", data['message'], "error");
            }
        });
    });

    {{--// Modal Edit Image Show--}}
    {{--$(document).on('click', '.edit_image', function() {--}}
    {{--    var id = $(this).attr("data-id");--}}
    {{--    console.log(id);--}}
    {{--    $.ajax({--}}
    {{--        type: "POST",--}}
    {{--        dataType: "json",--}}
    {{--        url: '{{url('edit_image')}}',--}}
    {{--        data: {'id': id},--}}
    {{--        success: function(data){--}}
    {{--            console.log(data);--}}
    {{--            $(".image_id").val(data[0].id);--}}
    {{--            $('#edit_image').modal('open');--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

    {{--$('#update_image').on('submit', function(e) {--}}
    {{--    e.preventDefault();--}}
    {{--    var form_data = new FormData(this);--}}
    {{--    var datatable = $('.dataTableImage').DataTable();--}}
    {{--    $.ajax({--}}
    {{--        type: "POST",--}}
    {{--        dataType: "json",--}}
    {{--        url: '{{url('update_image')}}',--}}
    {{--        data: form_data,--}}
    {{--        cache:false,--}}
    {{--        processData: false,--}}
    {{--        contentType: false,--}}
    {{--        success: function(data){--}}
    {{--            console.log(data);--}}
    {{--            $('#edit_image').modal('close');--}}
    {{--            // $(".validate").val('');--}}
    {{--            if(data['status'] == 1){--}}
    {{--                // console.log(data);--}}
    {{--                datatable.clear();--}}
    {{--                var i;--}}
    {{--                for (i = 0; i < data['data'].length; i++) {--}}
    {{--                    var trDOM = datatable.row.add( [--}}
    {{--                        i+1,--}}
    {{--                        '<img class="materialboxed" width="60" src="' + '{{asset("")}}/' + data['data'][i].image + '">',--}}
    {{--                        data['data'][i].product_name,--}}
    {{--                        '<a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan edit_image" data-id="'+data['data'][i].id+'"><i class="material-icons">mode_edit</i></a>',--}}
    {{--                        '<a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="{{asset('admin/delete_image')}}/" data-id="'+data['data'][i].id+'"><i class="material-icons">clear</i></a>'--}}
    {{--                    ] ).draw(false);--}}
    {{--                    $( trDOM ).addClass(''+data['data'][i].id);--}}
    {{--                }--}}
    {{--                swal("{{trans('admin.Inserted Successfully!')}}", "", "success");--}}
    {{--            } else {--}}
    {{--                swal("{{trans('admin.ERROR!')}}", data['message'], "error");--}}
    {{--            }--}}
    {{--        },--}}
    {{--        error: function(data){--}}
    {{--            swal("{{trans('admin.ERROR!')}}", data['message'], "error");--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}


    //----------------------------------------------------------------------

    // $('.give_id').hover(
    //     function() {
    //         $( this ).addClass( "hover" );
    //     }, function() {
    //         $( this ).removeClass( "hover" );
    //     }
    // ).on('click', function () {
    //     var id = $(this).data("id");
    //     // $(this).toggleClass('hoverTwo');
    //     $('.get_edit').removeAttr('disabled').attr("data-id", id);
    // });

    // $('.get_edit').on('change', function () {
    //     if($('.give_id').hasClass('hoverTwo')){
    //         $(this).removeAttr('disabled').attr("data-id", id);
    //     } else {
    //         $(this).attr('disabled', 'disabled').attr("data-id", null);
    //     }
    // });



    // $('.give_id').on('click', function() {
    //     var id = $(this).data("id");
    //     // $(this);
    //
    //     console.log(id);
    //     $('.get_edit').removeAttr('disabled').attr("data-id", id);
    //
    // });



</script>
