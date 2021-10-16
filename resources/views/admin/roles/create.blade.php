@extends('admin.layout.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ایجاد نقش</h3>
                </div>
                <div class="box-body">
                    <form action="{{route('roles.store')}}" method="post">
                        @csrf

                        <div class="form-group">
                            <lable for="title">عنوان</lable>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>


                        <div class="form-group">
                            <lable>انتخاب دسترسی ها</lable>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <label class="col-sm-2">
                                        <input style="opacity: 1 !important; position: static !important; left: 0; right: 0" type="checkbox" name="permissions[]" value="{{$permission->id}}">{{$permission->label}}
                                    </label>
                                @endforeach
                            </div>
                        </div>


                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                        </div>
                    </form>

                    @include('admin.layout.errors')

                </div>
            </div>
        </div>
    </div>

@endsection
