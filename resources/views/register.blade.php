@extends('main.index')

@section('title','Register')

@section('css')
<style>
.dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>a:after {
        content: "\f0da";
        float: right;
        border: none;
        font-family: 'FontAwesome';
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: 0px;
        margin-left: 0px;
    }
:root {
--input-padding-x: 1.5rem;
--input-padding-y: .75rem;
}

body {
background: #007bff;
background: linear-gradient(to right, #0062E6, #33AEFF);
}

.card-signin {
border: 0;
border-radius: 1rem;
box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.card-signin .card-title {
margin-bottom: 2rem;
font-weight: 300;
font-size: 1.5rem;
}

.card-signin .card-body {
padding: 2rem;
}

.form-signin {
width: 100%;
}

.form-signin .btn {
font-size: 80%;
border-radius: 5rem;
letter-spacing: .1rem;
font-weight: bold;
padding: 1rem;
transition: all 0.2s;
}

.form-label-group {
position: relative;
margin-bottom: 1rem;
}

.form-label-group input {
height: auto;
border-radius: 2rem;
}

.form-label-group>input,
.form-label-group>label {
padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group>label {
position: absolute;
top: 0;
left: 0;
display: block;
width: 100%;
margin-bottom: 0;
/* Override default `<label>` margin */
line-height: 1.5;
color: #495057;
border: 1px solid transparent;
border-radius: .25rem;
transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
color: transparent;
}

.form-label-group input:-ms-input-placeholder {
color: transparent;
}

.form-label-group input::-ms-input-placeholder {
color: transparent;
}

.form-label-group input::-moz-placeholder {
color: transparent;
}

.form-label-group input::placeholder {
color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
padding-top: calc(var(--input-padding-y) / 3);
padding-bottom: calc(var(--input-padding-y) / 3);
font-size: 12px;
color: #777;
}

.btn-google {
color: white;
background-color: #ea4335;
}

.btn-facebook {
color: white;
background-color: #3b5998;
}

/* Fallback for Edge
-------------------------------------------------- */

@supports (-ms-ime-align: auto) {
.form-label-group>label {
display: none;
}
.form-label-group input::-ms-input-placeholder {
color: #777;
}
}

/* Fallback for IE
-------------------------------------------------- */

@media all and (-ms-high-contrast: none),
(-ms-high-contrast: active) {
.form-label-group>label {
display: none;
}
.form-label-group input:-ms-input-placeholder {
color: #777;
}
}
</style>
@endsection

@section('container')
    <div class="container">
        <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
            <div class="card-body">
                <h5 class="card-title text-center">Register</h5>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(\Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <form class="form-signin" action="/register/submit" method="post">
                @csrf
                <div class="form-label-group">
                    <select name="role" id="role" class="form-control" style="border-radius:2rem;" autofocus required>
                        <option value="1">Supervisor</option>
                        <option value="2">Sales</option>
                        <option value="3">Admin</option>
                    </select>
                </div>
                <div class="form-label-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>

                <div class="form-label-group">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Password</label>
                </div>
                <div class="form-label-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    <label for="password_confirmation">Confirm Password</label>
                </div>

                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Daftar</button>
                <hr class="my-4">
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(function() {
  // ------------------------------------------------------- //
  // Multi Level dropdowns
  // ------------------------------------------------------ //
    $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).siblings().toggleClass("show");
        if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
        });
    });
    });
</script>
@endsection