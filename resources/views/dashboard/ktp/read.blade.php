@extends( (Auth::user()->hasRole('Admin')) ? 'admin.dashboard' : 'user.dashboard')

@section(Auth::user()->hasRole('Admin') ? 'kontenUserAdmin' : 'kontenUserPengguna')
    @if (Auth::user()->hasRole('Admin'))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data E-KTP</h3>
            </div>
            <div class="row ms-5">
                <div class="col-md-6">
                    <a href="{{ route('export.ktp') }}" class="btn btn-warning">Export Data</a>
                </div>
                <div class="col-md-5">
                    <form action="/ektp">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" placeholder="Cari Data" name="search">
                            <button class="btn btn-warning" type="submit" id="search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-sm text-center">
                Halaman : {{ $dataAll->currentPage() }} <br />
                Jumlah Data : {{ $dataAll->total() }} <br />
                Data Per Halaman : {{ $dataAll->perPage() }} <br />
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            {{-- <th>Tempat Lahir</th> --}}
                            <th>Tanggal Lahir</th>
                            {{-- <th>jenis_kelamin</th> --}}
                            <th>Usia</th>
                            <th>Foto</th>
                            <th colspan="3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($dataAll as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->nama }}</td>
                                {{-- <td>{{ $data->tempat_lahir }}</td> --}}
                                <td>{{ $data->tanggal_lahir }}</td>
                                {{-- <td>{{ $data->jenis_kelamin }}</td> --}}
                                <td>
                                    @php
                                        $birthday = new DateTime($data->tanggal_lahir);
                                        $today = new DateTime('today');
                                        $age = $today->diff($birthday)->y;
                                    @endphp
                                    {{ $age . ' Tahun' }}
                                </td>
                                <td>
                                    <img src="{{ url('storage/' . $data->foto) }}" alt="{{ $data->nama }}"
                                        width="100px">
                                </td>
                                <td>
                                    <a type="button" id="selectmodal" class="btn btn-sm btn-success" 
                                    data-toggle="modal" 
                                    data-target="#myModal" 
                                    data-usia="{{ $age }}" 
                                    data-nama="{{ $data->nama }}" 
                                    data-nik="{{ $data->id }}" 
                                    data-alamat="{{ $data->alamat }}"
                                    data-tempat_lahir="{{ $data->tempat_lahir }}"
                                    data-tanggal_lahir="{{ $data->tanggal_lahir }}"
                                    data-jenis_kelamin="{{ $data->jenis_kelamin }}">Lihat</a>
                                </td>
                                <td>
                                    <a href="{{ url('/ektp/edit/' . $data->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <a href="{{ url('/ektp/delete/' . $data->id) }}"
                                        class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dataAll->links() }}
            </div>
        </div>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Data <b><span id="nama"></span></b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-bordered no-margin">
                            <tbody>
                                <tr>
                                    <th style="">NIK</th>
                                    <td><span id="nik"></span></td>
                                </tr>
                                <tr>
                                    <th style="">Umur</th>
                                    <td><span id="usia"></span> Tahun</td>
                                </tr>
                                <tr>
                                    <th style="">Tempat Lahir</th>
                                    <td><span id="tempat_lahir"></span></td>
                                </tr>
                                <tr>
                                    <th style="">Tanggal Lahir</th>
                                    <td><span id="tanggal_lahir"></span></td>
                                </tr>
                                <tr>
                                    <th style="">Jenis Kelamin</th>
                                    <td><span id="jenis_kelamin"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data E-KTP</h3>
            </div>
            <div class="row ms-5">
                <div class="col-md-6">
                    <a href="{{ route('export.ktp') }}" class="btn btn-warning">Export Data</a>
                </div>
                <div class="col-md-5">
                    <form action="/ektp">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" placeholder="Cari Data" name="search">
                            <button class="btn btn-warning" type="submit" id="search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-sm text-center">
                Halaman : {{ $dataAll->currentPage() }} <br />
                Jumlah Data : {{ $dataAll->total() }} <br />
                Data Per Halaman : {{ $dataAll->perPage() }} <br />
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Usia</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($dataAll as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->tempat_lahir }}</td>
                                <td>{{ $data->tanggal_lahir }}</td>
                                <td>{{ $data->jenis_kelamin }}</td>
                                <td>
                                    @php
                                        $birthday = new DateTime($data->tanggal_lahir);
                                        $today = new DateTime('today');
                                        $age = $today->diff($birthday)->y;
                                    @endphp
                                    {{ $age . ' Tahun' }}
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $data->foto) }}" alt="{{ $data->nama }}"
                                        width="100px">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dataAll->links() }}
            </div>
        </div>
    @endif
@endsection
