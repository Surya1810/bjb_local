<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Lokasi</h2>
    <form action="{{ route('location.update', $location->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Number</label>
            <input type="number" name="number" class="form-control" value="{{ $location->number }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">For</label>
            <select name="for" class="form-control" required>
                <option value="baris" {{ $location->for == 'baris' ? 'selected' : '' }}>Baris</option>
                <option value="rak" {{ $location->for == 'rak' ? 'selected' : '' }}>Rak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('location.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
