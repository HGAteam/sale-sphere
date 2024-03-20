@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
@endsection

@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = 'Cash Register'),
        ($modalLink = '#addCashRegister'),
        ($modalName = 'Add Cash Register'),
        ($href = ''),
    ])

<div class="row">
<div class="col-xl-12 col-lg-12">
    <div class="ec-cat-list card card-default">
        <div class="card-body">
            <div class="table-responsive">
                <table id="cash_registers-data-table" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width:100px">{{__('Warehouse')}}</th>
                            <th style="min-width:150px">{{__('User')}}</th>
                            <th style="min-width:100px">{{__('Name')}}</th>
                            <th style="min-width:100px">{{__('Status')}}</th>
                            <th style="min-width:100px">{{__('Balance')}}</th>
                            <th style="min-width:100px">{{__('Opening Balance')}}</th>
                            <th style="min-width:100px">{{__('Closing Balance')}}</th>
                            <th style="min-width:100px">{{__('Created On')}}</th>
                            <th style="min-width:150px">{{__('Updated On')}}</th>
                            <th style="min-width:100px" class="text-end">{{__('Action')}}</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/cash_registers/table.js') }}"></script>
@endsection
