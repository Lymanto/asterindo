@extends('main.index')

@section('title','Home')

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
    @media screen and (max-width: 992px) {
        .judul {
            display:none;
        }
    }
    @media screen and (min-width: 992px) {
        .judul-mobile {
            display:none;
        }
        .judul{
            display:block;
        }
    }
    </style>
@endsection

@section('peta-lokasi')
<li class="nav-item">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Peta lokasi
    </a>
</li>
@endsection
@section('wsb')
<li class="nav-item">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Klik WSB - Up to date - TGL
    </a>
</li>
@endsection
@section('judul_mobile')
<h3 class="mx-auto judul-mobile" style="background-color:#fddb3a;color:#fff;border-radius:3px;padding:0px 10px;"><i>Asterindo Group</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#fddb3a;color:#fff;border-radius:3px;padding:0px 10px;"><i>Asterindo Group</i></h3>
@endsection
@section('container')
@endsection
@section('js')
<script>
    $(document).ready(function(){
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