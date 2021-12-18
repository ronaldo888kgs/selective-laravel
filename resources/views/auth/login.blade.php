@extends('dashboard')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    @if ($errors->has('login_fail'))
                        <span class="text-danger">{{ $errors->first('login_fail') }}</span>
                    @endif
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login.custom') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                            

                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Signin</button>
                            </div>
                            <div class="d-flex justify-content-between mx-auto" style="margin-top:16px;">
                                <div style="width:40%">
                                    <div class="d-flex justify-content-center">
                                        <img style="width:50%; border: solid" src="assets/apple_qr.jpg">
                                    </div>
                                    <div style="width:100%; margin-top:5px" class="d-flex justify-content-center">
                                        <a style="width:80%" href="https://apps.apple.com/us/app/selectivetradeschat/id1563422927">
                                            <img style="width:100%; height:60px" src="assets/down_app_store.png">
                                        </a>
                                    </div>
                                </div>
                                <div  style="width:40%">
                                    <div class="d-flex justify-content-center">
                                        <img style="width:50%; border: solid" src="assets/android_qr.jpg">
                                    </div>
                                    <div style="width:100%; margin-top:5px" class="d-flex justify-content-center">
                                        <a style="width:80%" href="https://play.google.com/store/apps/details?id=com.selectivetrades.chat">
                                            <img style="width:100%; height:60px" src="assets/down_play_store.png">
                                        </a>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection