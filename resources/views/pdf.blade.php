<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie-edge">
	<title>Data PDF</title>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>Hobi</th>
                <th>Gambar</th>
			</tr>
		</thead>
		<tbody>
			@foreach($siswa as $data)
			<tr>
				<td>{{$data->id}}</td>
				<td>{{$data->Nama_Siswa}}</td>
				<td>{{$data->Jenis_Kelamin}}</td>
				<td>{{$data->Tanggal_Lahir}}</td>
				<td>{{$data->Jurusan}}</td>
				<td>{{$data->Kelas}}</td>
				<td>{{$data->Alamat}}</td>
				<td>{{$data->Hobi}}</td>
				<td>{{$data->Foto}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>