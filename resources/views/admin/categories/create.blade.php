@extends('admin.layout.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ایجاد دسته بندی</h3>
                </div>
                <div class="box-body">
                    <form action="{{route('categories.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <lable for="category_id">دسته والد</lable>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" disabled selected>دسته والد را انتخاب کنید ..</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <lable for="title">عنوان</lable>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>


                        <div class="form-group">
                            <lable>انتخاب گروه ویژگی ها</lable>
                            <div class="row">
                                @foreach($properties as $property)
                                    <label class="col-sm-2">
                                        <input style="opacity: 1 !important; position: static !important; left: 0; right: 0" type="checkbox" name="properties[]" value="{{$property->id}}">{{$property->title}}
                                    </label>
                                @endforeach
                            </div>
                        </div>


                        @include('admin.layout.errors')

                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
