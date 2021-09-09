@extends('admin.layout.master')



@section('content')
    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <lable for="image">آپلود</lable>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @foreach($product->pictures as $picture)
            <div class="col-md-12 col-lg-3">
                <div class="card">
                    <img class="card-img-top img-responsive" src="../../images/card/img1.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        @endforeach
    </div>
@endsection
