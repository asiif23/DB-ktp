@extends( (Auth::user()->hasRole('Admin')) ? 'admin.dashboard' : 'user.dashboard')

@section(Auth::user()->hasRole('Admin') ? 'kontenUserAdmin' : 'kontenUserPengguna')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-10 m-auto">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Quick Example</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('ektp/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" value="{{ $data->nama }}"
                                        name="nama">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir"
                                            value="{{ $data->tempat_lahir }}" name="tempat_lahir">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir"
                                            value="{{ $data->tanggal_lahir }}" name="tanggal_lahir">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Jenis Kelamin</label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                            <option disabled selected value="{{ $data->jenis_kelamin }}">-- {{ $data->jenis_kelamin }} --</option>
                                            <option value="Laki-laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Foto</label>
                                        <div class="input-group">
                                            {{-- <img src="{{ asset('storage/' . $data->foto) }}" alt="{{ $data->nama }}" width="100px" class="m-1"> --}}
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="foto" name="foto">
                                                <label class="custom-file-label" for="foto" value="{{ $data->foto }}">{{ $data->foto }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
