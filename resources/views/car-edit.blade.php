<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Car</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
 
<div class="container">
    <h2>Edit car information</h2>
    <a href="{{route('cars.index')}}">Go back to car list</a>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('cars.update', $car->id)}}" class="was-validated" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
        <label for="model">Model:</label>
        <input type="text" class="form-control" id="" placeholder="Enter model" name="model" value="{{isset($car)?  $car->model:''}}" required>
        <div class="valid-feedback"></div>
        <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
        <label for="image">Image:</label>
        <img src="/image/{{isset($car)? $car->img:''}}" id="preview-img"style="height:300px" class="img-thumbnail" alt="">
        <input type="file" class="form-control" name="image" onchange="changeImage(event)" required>
        <div class="valid-feedback"></div>
        <div class="invalid-feedback"></div>
        </div>
        <script>
            const changeImage = (e) => {
                const preImg = document.getElementById("preview-img")
                const file = e.target.files[0]
                preImg.src = URL.createObjectURL(file)
                preImg.onload = () => {
                    URL.revokeObjectURL(preImg.src)
                }
            }
        </script>
        <div class="form-group">
            <label for="des">Description:</label>
            <input type="text" class="form-control" id="" placeholder="Enter description" name="des" value="{{isset($car)? $car -> des:''}}" required>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="des">Manufacturer:</label>
            <select name="mf_id" id="" >
                @foreach($mfs as $mf)
                    <option value="{{ $mf->id }}" {{ $car->mf->id == $mf->id?  "selected" :"" }}>{{$mf->name}}</option>
                @endforeach
            </select>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="pro_on">Produced_on:</label>
            <input type="date" class="form-control" id="" placeholder="Enter date" name="pro_on" value="{{isset($car)?  $car -> pro_on:''}}" required>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback"></div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</body>
</html>
