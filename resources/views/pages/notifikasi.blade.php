@extends('layouts.master')
@section('css')
@endsection
@section('page-header')

@endsection
@section('content')
    @livewire('wirenotifikasi')

    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>

    <script>
        window.addEventListener('openModal', event => {
            $("#user-form-modal").modal('show');

        });
        window.addEventListener('closeModal', event => {
            $("#user-form-modal").modal('hide');

        });

        window.addEventListener('openModalSearch', event => {
            $("#search-form-modal").modal('show');

        });
        window.addEventListener('closeModalSearch', event => {
            $("#search-form-modal").modal('hide');

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#user-form-modal").on('hidden.bs.modal', function() {
                livewire.emit('forceCloseModal');
            });


        });
    </script>

    <script>
        $('#appointmentDate').datetimepicker({
            // format: 'L',
            format: 'YYYY/MM/DD'
        });

        $('#appointmentDate').on("change.datetimepicker", function(e) {
            let date = $(this).data('appointmentdate');
            eval(date).set('tgl_perlakuan', $('#appointmentDateInput').val());

        });
        $('#appointmentDateStart').datetimepicker({
            // format: 'L',
            format: 'YYYY-MM-DD'
        });
        $('#appointmentDateStart').on("change.datetimepicker", function(e) {
            let date = $(this).data('appointmentdatestart');
            eval(date).set('startDate', $('#appointmentDateStartInput').val());

        });
        $('#appointmentDateEnd').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#appointmentDateEnd').on("change.datetimepicker", function(e) {
            let date = $(this).data('appointmentdateend');
            eval(date).set('endDate', $('#appointmentDateEndInput').val());
        });
    </script>
@endsection
