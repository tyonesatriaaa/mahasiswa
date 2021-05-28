@extends('mahasiswas.layout') 
@section('content') 
        <div class="row"> 
            <div class="col-lg-12 margin-tb"> 
                <div class="pull-left mt-2"> 
                    <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2> 
        </div> 
        <div class="float-right my-2"> 
            <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a> 
        </div> 
    </div> 
</div> 
@if ($message = Session::get('success')) 
    <div class="alert alert-success"> 
        <p>{{ $message }}</p>
    </div> 
@endif

<form method="get" action="/search" id="myForm">
    <div class="float-right my-2">
    <input type="cari" name="cari" class="form-control" id="cari" placeholder="Search" aria-describedby="cari" >
    </div>

    <div class="float-right my-2" style="margin-left:20px;">
        <button type="submit" class="btn btn-primary"> Search </button>
    </div>
</form>

<table class="table table-bordered"> 
        <tr> 
            <th>Nim</th> 
            <th>Nama</th> 
            <th>Kelas</th> 
            <th>Jurusan</th> 
            <!-- <th>No_Handphone</th> 
            <th>Email</th>
            <th>Tanggal Lahir</th> -->
            <th width="280px">Action</th> 
        </tr> @foreach ($paginate as $Mahasiswa) <tr> 
            <td>{{ $Mahasiswa->Nim }}</td> 
            <td>{{ $Mahasiswa->Nama }}</td> 
            <td>{{ $Mahasiswa->kelas->nama_kelas }}</td> 
            <td>{{ $Mahasiswa->Jurusan }}</td> 
            <!-- <td>{{ $Mahasiswa->No_Handphone }}</td>
            <td>{{ $Mahasiswa->email }}</td> 
            <td>{{ $Mahasiswa->tgl_lahir }}</td> -->
            <td> <form action="{{ route('mahasiswas.destroy',$Mahasiswa->Nim) }}" method="POST"> 
            <a class="btn btn-info" href="{{ route('mahasiswas.show',$Mahasiswa->Nim) }}">Show</a> 
            <a class="btn btn-primary" href="{{ route('mahasiswas.edit',$Mahasiswa->Nim) }}">Edit</a> 
            @csrf 
            @method('DELETE') 
            <button type="submit" class="btn btn-danger">Delete</button> 
        </form> 

    </td> 
</tr> 

@endforeach 

</table> 

@endsection