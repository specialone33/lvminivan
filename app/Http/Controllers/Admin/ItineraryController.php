<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyItineraryRequest;
use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Itinerary;
use App\Models\User;
use App\Models\Vehicle;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('itinerary_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itineraries = Itinerary::with(['user', 'vehicle'])->get();

        return view('admin.itineraries.index', compact('itineraries'));
    }

    public function create()
    {
        abort_if(Gate::denies('itinerary_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicles = Vehicle::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.itineraries.create', compact('users', 'vehicles'));
    }
    

    public function store(StoreItineraryRequest $request)
    {
        $itinerary = Itinerary::create($request->all());
       
        $this->notify("Νέο δρομολόγιο: {$request->from} - {$request->to}");
        
        return redirect()->route('admin.itineraries.index');
    }

    public function edit(Itinerary $itinerary)
    {
        abort_if(Gate::denies('itinerary_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicles = Vehicle::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $itinerary->load('user', 'vehicle');

        return view('admin.itineraries.edit', compact('users', 'vehicles', 'itinerary'));
    }

    public function update(UpdateItineraryRequest $request, Itinerary $itinerary)
    {
        $itinerary->update($request->all());

        return redirect()->route('admin.itineraries.index');
    }

    public function show(Itinerary $itinerary)
    {
        abort_if(Gate::denies('itinerary_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itinerary->load('user', 'vehicle');

        return view('admin.itineraries.show', compact('itinerary'));
    }

    public function destroy(Itinerary $itinerary)
    {
        abort_if(Gate::denies('itinerary_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itinerary->delete();

        return back();
    }

    public function massDestroy(MassDestroyItineraryRequest $request)
    {
        Itinerary::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function accept($id)
    {
        $itinerary = Itinerary::where('id', $id)->first();
        
        //Auth::user()->itineraries()->attach($id);
        Itinerary::where('id', $id)->update(['user_id' => Auth::user()->id]);
        //User::find(1)->itineraries()->attach(1);
        
        $name = Auth::user()->name;
        
        $this->notify("Ο οδηγός $name αποδέχτηκε το δρομολόγιο: {$itinerary->from} - {$itinerary->to}");

        return back();
    }
    public function cancel($id)
    {
        $itinerary = Itinerary::where('id', $id)->first();
        //Auth::user()->itineraries()->attach($id);
        Itinerary::where('id', $id)->update(['user_id' => NULL]);
        
        $name = Auth::user()->name;
        //User::find(1)->itineraries()->attach(1);
        $this->notify("Ο οδηγός $name ακύρωσε το δρομολόγιο: {$itinerary->from} - {$itinerary->to}");

        return back();
    }
    public function complete($id)
    {
        $itinerary = Itinerary::where('id', $id)->first();
       
        //Auth::user()->itineraries()->attach($id);
        Itinerary::where('id', $id)->update(['complete' => 'yes']);
        //User::find(1)->itineraries()->attach(1);
        $name = Auth::user()->name;
        $this->notify("Ο οδηγός $name ολοκλήρωσε το δρομολόγιο: {$itinerary->from} - {$itinerary->to}");
        return back();
    }
    
    private function notify($message){
       $content = [
            "en" => $message
        ];
        $hashes_array = [];
        array_push($hashes_array, [
            "id" => "like-button",
            "text" => "Προβολή",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://lvminivan.eu/admin"
        ]);

        $fields = [
            'app_id' => "6d6042b4-0894-4d7f-8d45-15a478a526b4",
            'included_segments' => [
                'Subscribed Users'
            ],
            'data' => [
                "foo" => "bar"
            ],
            'contents' => $content,
            'web_buttons' => $hashes_array
        ];

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZmFlZmU4OTAtZDVlYS00YzVlLWI1OTYtNTA5MWQ0YTAwYmNi'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
    
        //return $response;

    }
}

