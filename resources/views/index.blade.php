<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body>
  <div class="container">
    @if(Session::has('success'))
    <div class="alert alert-success">
      {{Session::get('success')}}
    </div>
    @endif
    <h2>Danh sách xe</h2>
    <p>Tổng hợp xe đời mới của công ty tnhh TLV</p>
    <a href="{{route('cars.create')}}">Add new car</a>
    <table class="table table-borderless">
      <thead>
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Description</th>
        <th>Model</th>
        <th>Nhà sản xuất</th>
        <th>Produced_on</th>
        <th>Chức năng</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($cars as $car)
          <tr>
            <form method="post" action="{{route('cars.destroy', $car->id)}}">
              @csrf
              @method('delete')
              <td>{{$car->id }}</td>
              <td><img src="/image/{{$car->img }}" style="width:250px" alt=""></td>
              <td>{{$car->des }}</td>
              <td>{{$car->model}}</td>
              <td>{{$car->mf->name}}</td>
              <td>{{$car->pro_on }}</td>
              {{-- <td>{{$mf->name}}</td> --}}
              <td class="d-flex">
                <button type="button" class="btn btn-danger me-3" onclick="window.location='{{ route('cars.edit', $car->id ) }}'">
                  <i class="bi bi-pen-fill"></i>
                </button>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Cos chắc bạn muốn xóa???')">
                  <i class="bi bi-trash3-fill"></i>
                </button>
              </td>
          </form>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
