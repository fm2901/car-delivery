@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                https://www.positronx.io/laravel-datatables-example/
                <table class="table table-bordered table-responsive-sm">
                <tr>
                    <th>#</th>
                    <th>LOT</th>
                    <th>Sale date</th>
                    <th>Container</th>
                    <th>Marka model</th>
                    <th>VIN kod</th>
                    <th>Warehouse</th>
                    <th>Owner</th>
                    <th>Photos</th>
                    <th>Actions</th>
                </tr>
                @foreach($cars as $i=>$car)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$car->lot}}</td>
                        <td>{{$car->saledate}}</td>
                        <td>{{$car->container}}</td>
                        <td>{{$car->name}}</td>
                        <td>{{$car->vincode}}</td>
                        <td>{{$car->warehouse}}</td>
                        <td>{{$car->owner}}</td>
                        <td>
                            @foreach ($car->photos()->get() as $photo)
                                <img width="50%" src="public/cars/{{$photo->path}}" alt="{{$photo->name}}">
                            @endforeach
                        </td>
                        <td>
                            <form enctype="multipart/form-data" method="post" action="{{ route('addPhoto') }}">
                                @csrf
                                <input type="file" onchange="this.form.submit()" name="carPhoto[]" multiple>
                                <input type="hidden" name="car_id" value="{{ $car->vincode }}">
                            </form>
                            <a href="{{ route('cars.edit',   $car->vincode) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection