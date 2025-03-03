<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Tambah Lokasi</h2>
    <form action="{{ route('location.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Number</label>
            <input type="number" name="number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">For</label>
            <select name="for" class="form-control" required>
                <option value="baris">Baris</option>
                <option value="rak">Rak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('location.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
