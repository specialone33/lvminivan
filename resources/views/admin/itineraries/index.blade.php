@extends('layouts.admin')
@section('content')
@can('itinerary_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.itineraries.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.itinerary.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.itinerary.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Itinerary">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.from') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.to') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.datetime') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.vehicle') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.map_point') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.comments') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.complete') }}
                        </th>
                        <th>
                            {{ trans('cruds.itinerary.fields.canceled') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itineraries as $key => $itinerary)
                        <tr data-entry-id="{{ $itinerary->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $itinerary->id ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->from ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->to ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->datetime ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->vehicle->title ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->map_point ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->price ?? '' }}
                            </td>
                            <td>
                                {{ $itinerary->comments ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Itinerary::COMPLETE_SELECT[$itinerary->complete] ?? '' }}
                            </td>
                             <td>
                                {{ App\Models\Itinerary::CANCELED_SELECT[$itinerary->canceled] ?? '' }}
                            </td>
                            <td>
                                @can('itinerary_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.itineraries.show', $itinerary->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('itinerary_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.itineraries.edit', $itinerary->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('itinerary_delete')
                                    <form action="{{ route('admin.itineraries.destroy', $itinerary->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('itinerary_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.itineraries.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Itinerary:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection