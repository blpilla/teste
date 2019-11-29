@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Reservas de Salas</div>
                    <div class="card-body">
                        <a href="{{ url('/reservation/create') }}" class="btn btn-success btn-sm" title="Add New Reservation">
                            <i class="fa fa-plus" aria-hidden="true"></i> Reservar
                        </a>

                        <form method="GET" action="{{ url('/reservation') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        @if(session('fail_message'))
                            <ul class="alert alert-danger">
                                {{ session('fail_message') }}
                            </ul>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Usuário</th><th>Sala</th><th>Data da Reserva</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($reservation as $item)
                                    <?php
                                    $user = App\User::find($item->user_id);
                                    $room = App\Room::find($item->room_id);
                                    ?>
                                    <tr>
                                        <td>{{ !empty($user->name) ? $user->name : '' }}</td>
                                        <td>{{ !empty($room->number) ? $room->number : '' }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y H:00')}}</td>
                                        <td>
                                            <a href="{{ url('/reservation/' . $item->id) }}" title="View Reservation"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                                            <a href="{{ url('/reservation/' . $item->id . '/edit') }}" title="Edit Reservation"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Alterar</button></a>

                                            <form method="POST" action="{{ url('/reservation' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Reservation" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Remover</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $reservation->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
