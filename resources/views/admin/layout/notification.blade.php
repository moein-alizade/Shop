{{--    اگر داخل session مان یک ایندکس یا کلیدی به این اسم وجود داشت    --}}
@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        {{ session()->get('success') }}
    </div>
@endif
