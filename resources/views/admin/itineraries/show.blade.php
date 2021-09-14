@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.itinerary.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.itineraries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.id') }}
                        </th>
                        <td>
                            {{ $itinerary->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.from') }}
                        </th>
                        <td>
                            {{ $itinerary->from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.to') }}
                        </th>
                        <td>
                            {{ $itinerary->to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.datetime') }}
                        </th>
                        <td>
                            {{ $itinerary->datetime }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.user') }}
                        </th>
                        <td>
                            {{ $itinerary->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.vehicle') }}
                        </th>
                        <td>
                            {{ $itinerary->vehicle->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.map_point') }}
                        </th>
                        <td>
                            {{ $itinerary->map_point }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.price') }}
                        </th>
                        <td>
                            {{ $itinerary->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.comments') }}
                        </th>
                        <td>
                            {{ $itinerary->comments }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itinerary.fields.canceled') }}
                        </th>
                        <td>
                            {{ App\Models\Itinerary::CANCELED_SELECT[$itinerary->canceled] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.itineraries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection