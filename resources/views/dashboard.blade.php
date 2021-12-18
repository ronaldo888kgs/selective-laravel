<!DOCTYPE html>
<html>
<head>
    <title>Record Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="/multiselect-master/styles/multiselect.css" rel="stylesheet"/>
    <script src="/multiselect-master/scripts/multiselect.js"></script>
    <script src="/multiselect-master/scripts/multiselect.core.js"></script>
    <script src="/multiselect-master/scripts/helper.js"></script>
    

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar" style="background-color: #e3f2fd;">
        <div style=" margin-left:10px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav m-auto">
                    
                    @guest
                    <li class="nav-item active">
                        <a class="nav-link {{ \Request::route()->getName() == 'login' ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ \Request::route()->getName() == 'register-user' ? 'active' : '' }}" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    @if (Auth::user()->is_admin)
                        <li class="nav-item ">
                            <a class="nav-link  {{ \Request::route()->getName() == 'adminpage.home' ? 'active' : '' }}" href="{{ route('adminpage.home') }}">AdminPage</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ \Request::route()->getName() == 'txt_convert' ? 'active' : '' }}" href="{{ route('txt_convert') }}">Text Convert</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ \Request::route()->getName() == 'add_data' ? 'active' : '' }}" href="{{ route('add_data') }}">Add Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ \Request::route()->getName() == 'open_status' ? 'active' : '' }}" href="{{ route('open_status') }}">Open Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ \Request::route()->getName() == 'erdata' ? 'active' : '' }}" href="{{ route('erdata') }}">ERData</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ \Request::route()->getName() == 'signout' ? 'active' : '' }}" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    
    
    
    <script type="text/javascript">
        jQuery(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

    </script>

</body>

</html>