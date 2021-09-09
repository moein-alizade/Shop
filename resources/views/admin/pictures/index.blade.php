@extends('admin.layout.master')



@section('content')
    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('products.pictures.store', $product)}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <lable for="image">آپلود</lable>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-sm btn-primary" value="آپلود">
                        </div>

                    </form>
                </div>
            </div>
        </div>
        @foreach($product->pictures as $picture)
            <div class="col-md-12 col-lg-3">
                <div class="card">
                    <img class="card-img-top img-responsive" src="{{str_replace('public', '/storage', $picture->path)}}" alt="Card image cap">
                    <div class="card-body">
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        @endforeach
    </div>
@endsection
