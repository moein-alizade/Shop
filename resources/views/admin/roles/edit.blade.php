@extends('admin.layout.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> ویرایش نقش {{$role->title}} </h3>
                </div>
                <div class="box-body">
                    <form action="{{route('roles.update', $role)}}" method="POST">
                        @csrf
                        @method('patch')
                        <h2>عنوان</h2>
                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{$role->title}}"/>
                        </div>

                        <div class="from-group">
                            <lable>انتخاب دسترسی ها</lable>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <lable class="col-sm-2">
                                        <input style="opacity: 1 !important; position: static !important; left: 0; right: 0"
                                               @if($role->hasPermission($permission->title))
                                               checked
                                               @endif
                                               type="checkbox" name="permissions[]" value="{{$permission->id}}">{{$permission->title}}
                                    </lable>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary mt-2">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
