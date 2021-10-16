@extends('admin.layout.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ایجاد اسلایدر</h3>
                </div>
                <div class="box-body">
                    {{-- enctype="multipart/form-data" => for upload file and send to server  --}}
                    <form action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <lable for="link">لینک</lable>
                            <input type="text" class="form-control" name="link" id="link">
                        </div>


                        <div class="form-group">
                            <lable for="image">تصویر</lable>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>


                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>

            @include('admin.layout.errors')

        </div>
    </div>

@endsection
