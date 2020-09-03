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
                    <li class="breadcrumb-item active">Selesai di proses</li>
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
                        <h5 class="m-0">Semua Transaksi yang telah di proses</h5>
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
                                    <td>No Tujuan</td>
                                    <td>Tujuan</td>
                                    <td>Nominal</td>
                                    <td>Bukti</td>
                                    <td>Status</td>
                                    <!-- <td>Aksi</td> -->
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
        'ajax': "{{ route('transaksi.data','done') }}",
        'dataType': 'json',
        'paging': true,
        'lengthChange': true,
        'columns': [
            {data: 'kode',name: 'kode'},
            {data: 'pengguna',name: 'pengguna'},
            {data: 'created_at',name: 'created_at'},
            {data: 'no_pengirim',name: 'no_pengirim'},
            {data: 'fintech_pengirim',name: 'fintech_pengirim'},
            {data: 'no_tujuan',name: 'no_tujuan'},
            {data: 'fintech_tujuan',name: 'fintech_tujuan'},
            {data: 'nominal',name: 'nominal'},
            {data: 'bukti',name: 'bukti'},
            {data: 'status',name: 'status'},
            // {data: 'aksi',name: 'aksi'},
        ],
        'info': true,
        'autoWidth': false
    });
</script>
@endpush
@endsection