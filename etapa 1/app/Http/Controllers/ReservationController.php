<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Reservation;
use Illuminate\Http\Request;
use App\User;
use App\Room;


class ReservationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $reservation = Reservation::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('room_id', 'LIKE', "%$keyword%")
                ->orWhere('date', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $reservation = Reservation::latest()->paginate($perPage);
        }

        return view('reservation.index', compact('reservation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'date' => 'required|date',
        ]);

        if($this->reservationRoomRule($request))
        {
            if($this->reservationUserRule($request))
            {
                $requestData['date'] = $this->minuteFilter($request->date);
                Reservation::create($requestData);

                return redirect('reservation')->with('flash_message', 'Reserva realizada!');
            }
            else
            {
                return redirect('reservation')->with('fail_message', 'Usuário já possui sala reservada neste horário!');
            }
        }
        else
        {
            return redirect('reservation')->with('fail_message', 'Sala já ocupada neste horário!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('reservation.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('reservation.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'date' => 'required|date',
        ]);

        if($this->reservationRoomRule($request, $id))
        {
            if($this->reservationUserRule($request, $id))
            {
                $requestData['date'] = $this->minuteFilter($request->date);
                $reservation = Reservation::findOrFail($id);
                $reservation->update($requestData);

                return redirect('reservation')->with('flash_message', 'Reserva alterada!');
            }
            else
            {
                return redirect('reservation')->with('fail_message', 'Usuário já possui sala reservada neste horário!');
            }
        }
        else
        {
            return redirect('reservation')->with('fail_message', 'Sala já ocupada neste horário!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Reservation::destroy($id);

        return redirect('reservation')->with('flash_message', 'Reservation deleted!');
    }

    public function minuteFilter($date)
    {
        $createDate = date_create($date);

        return date_format($createDate, 'Y-m-d H:00:00');
    }

    public function reservationRoomRule($request, $id = 0)
    {
        $date = $this->minuteFilter($request->date);
        $to = date("Y-m-d H:i:s", strtotime("$date +1 hour"));
        $test = Reservation::where('room_id', '=', "$request->room_id")
        ->whereBetween('date', [$date, $to])->where('id', '<>', $id)->get();

        return count($test) == 0;
    }

    public function reservationUserRule($request, $id = 0)
    {
        $date = $this->minuteFilter($request->date);
        $to = date("Y-m-d H:i:s", strtotime("$date +1 hour"));
        $test = Reservation::where('user_id', '=', "$request->user_id")
        ->whereBetween('date', [$date, $to])->where('id', '<>', $id)->get();

        return count($test) == 0;
    }
}
