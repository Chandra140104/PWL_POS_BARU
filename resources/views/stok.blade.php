<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>
    <h1>Data Supplier</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID Supplier</th>
            <th>Kode Supplier</th>
            <th>Nama Supplier</th>
            <th>Alamat Supplier</th>
        </tr>
        @foreach ($data as $supplier)
        <tr>
            <td>{{ $supplier->supplier_id }}</td>
            <td>{{ $supplier->supplier_kode }}</td>
            <td>{{ $supplier->supplier_nama }}</td>
            <td>{{ $supplier->supplier_alamat }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>