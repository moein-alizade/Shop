@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ویژگی های محصول {{$product->name}}</h3>
                </div>


                @php
                    $propertyGroups = $product->category->propertyGroups
                @endphp



                <div class="box-body">
                    {{-- enctype="multipart/form-data" => for upload file and send to server  --}}
                    <form action="{{route('products.properties.store', $product)}}" method="post" enctype="multipart/form-data">
                        @csrf

                        @foreach($propertyGroups as $group)
                            <h3>{{$group->title}}</h3>
                            <div class="row">
                                @foreach($group->properties as $property)
                                    <div class="form-group col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <lable for="name">{{$property->title}}</lable>
                                            </div>
                                            <div class="col-sm-10">
                                                {{-- properties[{{ آیدی ویژگی مدنظر }}][name or key] => آرایه دو بعدی --}}
                                                {{-- key = اسم فیلد مجزای ما --}}
                                                {{-- در این حالت ما یک فیلد مجزا داریم، یک فیلدی که جدا از رابطه چند به جند باید اونم مقداردهی شود --}}
                                                <input type="text" class="form-control" name="properties[{{ $property->id }}][value]" value="{{ $property->getValueForProduct($product) }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach



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
