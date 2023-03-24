@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header card-title" style="font-size: 24px">
            Riwayat
        </div>
        <div class="card-body">
            <div>
                <form action="{{ route('transactions.history') }}" method="get">
                    @csrf
                    <select name="selectYear" id="selectYear" class="form-control">
                        {{-- <option value="">-- Tahun --</option> --}}
                    </select>
                    <button type="submit" id='btnSelYear' class="btn btn-sm btn-info"><i class="fas fa-filter"></i>&nbsp; Filter</button>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $t)
                    @if ($t->category->category == "income")
                    <tr class="table-success">
                        <td>{{ $loop->iteration }}</td>
                        <td>Rp. {{ number_format($t->amount, 2, ",", ".") }}</td>
                        <td>{{ $t->info }}</td>
                        <td>Pemasukan ({{ $t->category->name }})
                        </td>
                        <td>{{ date('D, j M Y G:i:s', strtotime($t->created_at)) }}</td>
                    </tr>
                    @else
                    <tr class="table-danger">
                        <td>{{ $loop->iteration }}</td>
                        <td>Rp. {{ number_format($t->amount, 2, ",", ".") }}</td>
                        <td>{{ $t->info }}</td>
                        <td>Pemasukan ({{ $t->category->name }})
                        </td>
                        <td>{{ date('D, j M Y G:i:s', strtotime($t->created_at)) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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

    var currentYear = new Date().getFullYear();
    var earliestYear = 2020;
    var yearDropdown = document.getElementById('selectYear');
    while(currentYear >= earliestYear) {
        var yearOption = document.createElement('option');
        yearOption.text = currentYear;
        yearOption.value = currentYear;
        yearDropdown.add(yearOption);
        currentYear -= 1;
    }
</script>
@endsection