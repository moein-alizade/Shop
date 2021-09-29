@extends('admin.layout.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ویرایش اسلایدر</h3>
                </div>
                <div class="box-body">
                    {{-- enctype="multipart/form-data" => for upload file and send to server  --}}
                    <form action="{{route('sliders.update', $sliders)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <lable for="link">لینک</lable>
                            <input type="text" class="form-control" name="link" id="link" value="{{$sliders->link}}">
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <lable for="image">تصویر</lable>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{str_replace('public', '/storage', $sliders->image)}}" width="100" alt="">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>

            {{-- show errors --}}
            @if(count($errors->all()) > 0)
                <ul class="bg-danger">
                    @foreach($errors->all() as $error)
                        <li class="text-white">{{$error}}</li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>

@endsection
