@php($menu = $menu ?? null)

<div class="form-group">
    <label>Kategori</label>
    <select name="category_id" required class="form-control">
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (string) old('category_id', $menu->category_id ?? '') === (string) $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Nama Menu</label>
    <input type="text" name="name" value="{{ old('name', $menu->name ?? '') }}" required class="form-control">
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Deskripsi</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $menu->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Harga (Rp)</label>
    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
        <input type="number" step="0.01" name="price" value="{{ old('price', $menu->price ?? '') }}" required class="form-control">
    </div>
    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label>Gambar Menu</label>
    @if(!empty($menu?->image_url))
        <div class="mb-2">
            <img src="{{ $menu->image_url }}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">
        </div>
    @endif
    <div class="custom-file">
        <input type="file" name="image" accept="image/*" class="custom-file-input" id="imageInput">
        <label class="custom-file-label" for="imageInput">Pilih gambar...</label>
    </div>
    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group icheck-orange">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1"
               {{ old('is_available', $menu->is_available ?? true) ? 'checked' : '' }}>
        <label class="custom-control-label" for="is_available">Tersedia untuk dipesan</label>
    </div>
</div>

<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1"
               {{ old('is_featured', $menu->is_featured ?? false) ? 'checked' : '' }}>
        <label class="custom-control-label" for="is_featured">⭐ Jadikan Produk Pilihan</label>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('imageInput');
        if (input) {
            input.addEventListener('change', function (e) {
                var fileName = e.target.files[0]?.name || 'Pilih gambar...';
                var label = e.target.nextElementSibling;
                if (label) label.innerText = fileName;
            });
        }
    });
</script>
