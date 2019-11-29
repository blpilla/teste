@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Reserva de Sala</div>
                    <div class="card-body">

                        <a href="{{ url('/reservation') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</button></a>
                        <a href="{{ url('/reservation/' . $reservation->id . '/edit') }}" title="Edit Reservation"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Alterar</button></a>

                        <form method="POST" action="{{ url('reservation' . '/' . $reservation->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Reservation" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Remover</button>
                        </form>
                        <br/>
                        <br/>

                        <?php
                            $user = App\User::find($reservation->user_id);
                            $room = App\Room::find($reservation->room_id);
                        ?>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>

                                    <tr><th> Usuário </th><td> {{ !empty($user->name) ? $user->name : '' }} </td></tr><tr><th> Sala </th><td> {{ !empty($room->number) ? $room->number : '' }} </td></tr><tr><th> Data da Reserva </th><td> {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y H:00')}}</td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
