@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-10">
            <!-- Display Validation Errors -->
            @include('common.errors')
            <!-- New Rates Form -->
            <form action="{{ url('/rates/add') }}" method="POST" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="date">Дата</label>
                    <input v-model="add_date" type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="rate">Курс</label>
                    <input type="number" required name="rate" min="0.000000000000000000001" value="0.001" step="any">
                </div>


                <!-- Add Rate Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-btn fa-plus"></i>Додати Курс
                    </button>
                </div>
            </form>
        </div>

        <div class="col-sm-10">
            <!-- Filter Form -->
            <form action="{{ url('/rates/filter') }}" method="POST" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="date">Дата</label>
                    <input type="date" id="date" name="date" value="{{ $date_from_filter }}" required>
                </div>
                <!-- Fiter Rate Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-btn fa-plus"></i>Знайти Курс
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@if(count($rates) > 0)
<div class="container">
    <div class="row">
        <br>
        <div class="card">
            <div class="card-header">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#schedule">
                    Показати графік
                </button>

                <!-- Modal -->
                <div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="schedule" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Графік курсу</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <canvas id="myChart" width="100" height="100"></canvas>

                                <script>
                                    const ctx = document.getElementById('myChart').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: <?php echo json_encode($pie_lables) ?>,
                                            datasets: [{
                                                label: '- Значень Курсів',
                                                data: <?php echo json_encode($pie_data) ?>,
                                                fill: false,
                                                borderColor: 'rgb(75, 192, 192)',
                                                tension: 0.1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Курс</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rates as $rate)
                        <tr>
                            <th scope="row">{{ $rate['id'] }}</th>
                            <td>{{ $rate['date'] }}</td>
                            <td>{{ $rate['rate'] }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@if($massege !=null)
<div class="container">
    <div class="row">
        <h3>{{$massege}}</h3>
    </div>
</div>

@endif
@endsection