@extends('layouts.main')

<style>
    .text-center {
        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
        margin-top: 15px;
    }

    tr.ini {
        background-color: #193333;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .2);
    }

</style>

@section('main')
    <p class="text-center">DAFTAR MAHASISWA</p>

    <button type="button" class="btn btn-light" data-bs-toggle="modal"
            data-bs-target="#popUpTambahMahasiswa" style="margin-left:80px;margin-bottom: 15px;">
        Tambah
    </button>

    <div class="modal fade" id="popUpTambahMahasiswa" tabindex="-1"
         aria-labelledby="popupFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFormLabel">
                        FORM TAMBAH MAHASISWA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahMahasiswa" method="post"
                          action="/mahasiswa/tambah">
                        @csrf
                        <div class="mb-3">
                            <label for="nim_mahasiswa"
                                   class="form-label">NIM</label>
                            <input type="text" class="form-control"
                                   id="nim_mahasiswa"
                                   name="nim_mahasiswa"
                                   placeholder="xxxxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label for="nama_mahasiswa"
                                   class="form-label">Nama</label>
                            <input type="text" class="form-control"
                                   id="nama_mahasiswa"
                                   name="nama_mahasiswa"
                                   placeholder="nama mahasiswa">
                        </div>
                        <div class="mb-3">
                            <label for="prodi_dropdown" class="form-label">Program Studi</label>
{{--                            <input type="password" class="form-control"--}}
{{--                                   id="password_akun"--}}
{{--                                   name="password_akun"--}}
{{--                                   placeholder="xxxxx">--}}
                            <select name="prodi_dropdown">
                                <option value="">Pilih Prodi</option>
                                @php
                                    $columnName = 'prodi';
    $tableName = 'mahasiswas';

    $query = "SHOW COLUMNS FROM $tableName WHERE Field = :columnName";
    $bindings = [':columnName' => $columnName];

    $pdo = DB::connection()->getPdo();
    $statement = $pdo->prepare($query);
    $statement->execute($bindings);

    $results = $statement->fetch(PDO::FETCH_OBJ);

    preg_match('/^enum\((.*)\)$/', $results->Type, $matches);
    $enumValues = explode(',', $matches[1]);

    $enumValues = array_map(function ($value) {
        return trim($value, "'");
    }, $enumValues);

    $selectedOption = $enumValues[0];


                                @endphp
                                @foreach($enumValues as $daftarProdi)
                                    <option
                                        value="{{$daftarProdi}}" {{$selectedOption == $daftarProdi ? '$selected' : ''}}> {{$daftarProdi}}
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" form="formTambahMahasiswa"
                            class="btn btn-warning">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr class="ini">
                <th>NO</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>AKSI</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody style="background-color: #214242">
            @foreach($data as $mahasiswa)
                <tr>
                    <td>{{$mahasiswa['id']}}</td>
                    <td>{{$mahasiswa['nim']}}</td>
                    <td>{{$mahasiswa['nama']}}</td>
                    <td>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#popupFormHapusAkun{{$mahasiswa['id']}}">
                            <img src="{{asset('images/svg/trash3-fill.svg')}}" alt="delete" width="20">
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="popupFormHapusAkun{{$mahasiswa['id']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel{{$mahasiswa['id']}}">
                                            Hapus {{$mahasiswa['nama']}}?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formHapusAkun{{$mahasiswa['id']}}" method="post"
                                              action="/mahasiswa/hapus{{$mahasiswa['nim']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                Apakah anda yakin ingin hapus Mahasiswa {{$mahasiswa['nama']}}
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>
                                        <button type="submit" form="formHapusAkun{{$mahasiswa['id']}}"
                                                class="btn btn-danger">Ya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="ini">
                <th>NO</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>AKSI</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>

@endsection
