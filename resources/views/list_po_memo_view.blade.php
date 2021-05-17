@extends('main.index')

@section('title','Memo - Purchase Order')

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

@section('container')
<div class="container">
    <div class="row">
        <div class="col-4 mt-3">
            @if(\Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 py-3">
            <form action="{{route('list_po.memo_submit',$kode)}}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea id="editor" class="form-control" name="editor" rows="10" cols="50">{!! $memo['memo'] !!}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">Edit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ),{
            toolbar: [ 'heading', '|', 'bold', 'italic','link', 'bulletedList', 'numberedList', 'blockQuote','undo','redo'],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' }
            ]
        }
        } )
        .then( editor => {
			window.editor = editor;
		} )
        .catch( error => {
            console.error( error );
        } );
</script>
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
$(document).ready( function () {
    $('#table').DataTable();
    $('.modal-content').delegate('.qty,.harga,.total','keyup',function(){
        var tr3 = $(this).parent();
        var tr2 = tr3.parent();
        var tr = tr2.parent();
        var qty = tr.find('.qty').val();
        var harga = tr.find('.harga').val();
        var total = (qty * harga);
        tr.find('.total').val(total);
    });
} );
</script>
@endsection