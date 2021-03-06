@extends('master')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                    <li class="breadcrumb-item active">Uploaded Bukti</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Transaksi dengan bukti</h5>
                    </div>
                    <div class="card-body" style="overflow-x: auto;">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Kode</td>
                                    <td>User</td>
                                    <td>Tanggal</td>
                                    <td>No Asal</td>
                                    <td>Asal</td>
                                    <td>Nominal</td>
                                    <td>Bukti</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@push('custom-scripts')
<script>
    var t = $('#myTable').DataTable({
        'processing': true,
        'serverSide': true,
        'ajax': "{{ route('transaksi.data','bukti') }}",
        'dataType': 'json',
        'paging': true,
        'lengthChange': true,
        'columns': [
            { data: 'kode', name: 'kode' },
            { data: 'pengguna', name: 'pengguna' },
            { data: 'created_at', name: 'created_at' },
            { data: 'no_pengirim', name: 'no_pengirim' },
            { data: 'fintech_pengirim', name: 'fintech_pengirim' },
            { data: 'nominal', name: 'nominal' },
            { data: 'buktiImg', name: 'buktiImg' },
            { data: 'status', name: 'status' },
            { data: 'aksiBukti', name: 'aksiBukti', orderable: false, search: false },
        ],
        'info': true,
        'autoWidth': true
    });

    function setStatus(id, status) {
        var idUser = id;
        var statusTransaksi = status;
        $.ajax({
            data: {'_token': "{{ csrf_token() }}"},
            url: "{{ url('transaksi') }}" + "/" + idUser + "/status/" + statusTransaksi,
            type: "POST",
            dataType: 'json',
            success: function(data) {
                alert('Bukti telah di verivikasi');
                t.ajax.reload();
            },
            error: function(data) {
                alert('something went wrong');
            }
        });
    }
</script>
@endpush
@endsection