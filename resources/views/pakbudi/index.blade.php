@extends('layouts.template')
@section('content')

{{-- Start Delete Record Modal --}}
<div id="delete_record" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="delete_recordLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header modal-colored-header bg-primary">
      <h4 class="modal-title" id="delete_recordLabel">Hapus Data
      </h4>
      <button type="button" class="close" data-dismiss="modal"
      aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
      <form action="{{ route('transactions.delete') }}" method="POST">
        @csrf
        <h5><strong>Yakin ingin menghapus?</strong></h5>
        <input type="hidden" name="transaction_id" id="transaction_id" value="">
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-danger btn-sm' id=''><i class="fas fa-trash"></i> Hapus</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- End Delete Record Modal --}}

@if (session('record-add-successful'))
<div class="alert alert-success" role="alert">
  <strong>Sukses - </strong> {{ session('record-add-successful') }}
</div>  
@endif
@if (session('record-update-successful'))
<div class="alert alert-success" role="alert">
  <strong>Sukses - </strong> {{ session('record-update-successful') }}
</div>  
@endif
@if (session('record-delete-successful'))
<div class="alert alert-success" role="alert">
  <strong>Sukses - </strong> {{ session('record-delete-successful') }}
</div>  
@endif

    <div>
        <button class="btn btn-primary" data-toggle='modal' data-target='#add-record'><i class="fas fa-plus"></i>&nbsp; Tambah Catatan Keuangan</button>
    </div>
    <div class="card">
        <div class="card-header card-title" style="font-size: 24px">
            Dashboard
        </div>
        {{-- <div class="card-header card-subtitle"><strong>Balance: Rp. {{ number_format($balance, 2, ",", ".") }}</strong></div> --}}
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>Rp. {{ number_format($t->amount, 2, ",", ".") }}</td>
                        <td>{{ $t->info }}</td>
                        <td>
                            @if ($t->category->category == "income")
                                Pemasukan
                            @else
                                Pengeluaran
                            @endif
                            ({{ $t->category->name }})
                        </td>
                        <td>{{ date('D, j M Y G:i:s', strtotime($t->created_at)) }}</td>
                        <td>
                          @if ($t->status == "1")
                              <i class="fas fa-check-circle" data-toggle="tooltip" title="Sudah diverifikasi"></i>
                          @else
                              <i class="fas fa-hourglass-half" data-toggle="tooltip" title="Menunggu verifikasi"></i>
                          @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit_record_{{ $t->id }}"><i class="fas fa-pencil-alt"></i> Ubah</button>
                            <button class="btn btn-sm btn-danger OpenDeleteModal" data-id='{{ $t->id }}' data-toggle="modal" data-target="#delete_record"><i class="fas fa-trash"></i> Hapus</button>
                        </td>
                    </tr>

                    {{-- Start Edit Record Modal --}}
                    <div id="edit_record_{{ $t->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="edit_record_{{ $t->id }}Label" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title" id="edit_record_{{ $t->id }}Label">Ubah Data
                        </h4>
                        <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('transactions.update', $t->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="mb-3">
                                <label for="amount" class="form-label">Nominal</label>
                                <input type="number" data-symbol="Rp " data-thousands="." class="form-control" min=0 name='amount' required value={{ $t->amount }}>
                            </div>
                            <div class="mb-3">
                            <label for="info" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="info" name='info' required value={{ $t->info }}>
                            </div>
                            <div class="mb-3">
                                <label for="category_id">Kategori</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Sebagai Berikut--</option>
                                    @foreach ($categories->where('category', 'income') as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                    <option value="" disabled>--------------</option>
                                    @foreach ($categories->where('category', 'expense') as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                            <button type="submit" class='btn btn-primary btn-sm' id=''><i class="fas fa-save"></i> Simpan</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    {{-- End Edit Record Modal --}}
                    @endforeach
                </tbody>
            </table>
            <div>
                <h3><strong>Balance: Rp. {{ number_format($balance, 2, ",", ".") }}</strong></h3>
            </div>
        </div>
    </div>

{{-- Start Add Record Modal --}}
<div id="add-record" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="add-recordLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header modal-colored-header bg-primary">
      <h4 class="modal-title" id="add-recordLabel">Tambah Data
      </h4>
      <button type="button" class="close" data-dismiss="modal"
      aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
      <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Nominal</label>
            <input type="number" data-symbol="Rp " data-thousands="." class="form-control" min=0 name='amount' required>
        </div>
        <div class="mb-3">
          <label for="info" class="form-label">Keterangan</label>
          <input type="text" class="form-control" id="info" name='info' required>
        </div>
        <div class="mb-3">
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="" selected disabled>-- Pilih Sebagai Berikut--</option>
                @foreach ($categories->where('category', 'income') as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
                <option value="" disabled>--------------</option>
                @foreach ($categories->where('category', 'expense') as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary btn-sm' id=''><i class="fas fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- End Add Record Modal --}}
@endsection
@section('script')
<script>
    $(document).ready( function () {
        $('.table').DataTable();
    });

    $(document).on('click', '.OpenDeleteModal', function() {
           var id = $(this).data('id');
           $(".modal-body #transaction_id").val(id);
        //    var value = $(".modal-body #target_id").val();
        //    alert(value);
    });
</script>
@endsection