@extends('admin.layout.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ایجاد محصول</h3>
                </div>
                <div class="box-body">
                    {{-- enctype="multipart/form-data" => for upload file and send to server  --}}
                    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <lable for="category_id">دسته بندی</lable>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" disabled selected>دسته بندی را انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group">
                            <lable for="brand_id">برند</lable>
                            <select name="brand_id" id="brand_id" class="form-control">
                                <option value="" disabled selected>برند را انتخاب کنید</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <lable for="name">نام</lable>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>


                        <div class="form-group">
                            <lable for="slug">اسلاگ</lable>
                            <input type="text" class="form-control" name="slug" id="slug">
                        </div>


                        <div class="form-group">
                            <lable for="cost">قیمت</lable>
                            <input type="number" class="form-control" name="cost" id="cost">
                        </div>


                        <div class="form-group">
                            <lable for="image">تصویر</lable>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>


                        <div class="form-group">
                            <lable for="description">توضیحات</lable>
                            <textarea name="description" id="description" class="form-control"></textarea>
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
