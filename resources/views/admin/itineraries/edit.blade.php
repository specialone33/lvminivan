@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.itinerary.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.itineraries.update", [$itinerary->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="from">{{ trans('cruds.itinerary.fields.from') }}</label>
                <input class="form-control {{ $errors->has('from') ? 'is-invalid' : '' }}" type="text" name="from" id="from" value="{{ old('from', $itinerary->from) }}" required>
                @if($errors->has('from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.from_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="to">{{ trans('cruds.itinerary.fields.to') }}</label>
                <input class="form-control {{ $errors->has('to') ? 'is-invalid' : '' }}" type="text" name="to" id="to" value="{{ old('to', $itinerary->to) }}" required>
                @if($errors->has('to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.to_helper') }}</span>
            </div>
              <div class="form-group">
                <label for="datetime">{{ trans('cruds.itinerary.fields.datetime') }}</label>
                <input class="form-control datetime {{ $errors->has('datetime') ? 'is-invalid' : '' }}" type="text" name="datetime" id="datetime" value="{{ old('datetime', $itinerary->datetime) }}" inputmode='none'>
                @if($errors->has('datetime'))
                    <div class="invalid-feedback">
                        {{ $errors->first('datetime') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.datetime_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.itinerary.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $itinerary->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vehicle_id">{{ trans('cruds.itinerary.fields.vehicle') }}</label>
                <select class="form-control select2 {{ $errors->has('vehicle') ? 'is-invalid' : '' }}" name="vehicle_id" id="vehicle_id">
                    @foreach($vehicles as $id => $entry)
                        <option value="{{ $id }}" {{ (old('vehicle_id') ? old('vehicle_id') : $itinerary->vehicle->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('vehicle'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vehicle') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.vehicle_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="map_point">{{ trans('cruds.itinerary.fields.map_point') }}</label>
                <input class="form-control {{ $errors->has('map_point') ? 'is-invalid' : '' }}" type="text" name="map_point" id="map_point" value="{{ old('map_point', $itinerary->map_point) }}">
                @if($errors->has('map_point'))
                    <div class="invalid-feedback">
                        {{ $errors->first('map_point') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.map_point_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.itinerary.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $itinerary->price) }}" step="0.01" required>
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.price_helper') }}</span>
            </div>
              <div class="form-group">
                <label>{{ trans('cruds.itinerary.fields.canceled') }}</label>
                <select class="form-control {{ $errors->has('canceled') ? 'is-invalid' : '' }}" name="canceled" id="canceled">
                    <option value disabled {{ old('canceled', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Itinerary::CANCELED_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('canceled', $itinerary->canceled) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('canceled'))
                    <div class="invalid-feedback">
                        {{ $errors->first('canceled') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.canceled_helper') }}</span>
            </div>

             <div class="form-group">
                <label>{{ trans('cruds.itinerary.fields.complete') }}</label>
                <select class="form-control {{ $errors->has('complete') ? 'is-invalid' : '' }}" name="complete" id="complete">
                    <option value disabled {{ old('complete', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Itinerary::CANCELED_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('complete', $itinerary->complete) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('complete'))
                    <div class="invalid-feedback">
                        {{ $errors->first('complete') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.canceled_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.itinerary.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $itinerary->comments) }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itinerary.fields.comments_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection