@php $product = $product ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $product?->name) }}" required
           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
    <select name="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">— No Category —</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', $product?->category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
    <textarea name="description" rows="4" required
              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none @error('description') border-red-300 @enderror">{{ old('description', $product?->description) }}</textarea>
    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (USD) <span class="text-red-500">*</span></label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
            <input type="number" name="price" value="{{ old('price', $product?->price) }}" step="0.01" min="0" required
                   class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('price') border-red-300 @enderror">
        </div>
        @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity <span class="text-red-500">*</span></label>
        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product?->stock_quantity ?? 0) }}" min="0" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('stock_quantity') border-red-300 @enderror">
        @error('stock_quantity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

{{-- ── Product Image ──────────────────────────────────────────────────── --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Image</label>

    {{-- Size guidance --}}
    <p class="text-xs text-gray-500 mb-3 flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Recommended: <strong>800 × 800 px</strong>, square crop · JPG / PNG / WebP · max <strong>2 MB</strong>
    </p>

    {{-- Tab switcher --}}
    <div class="flex rounded-xl border border-gray-200 overflow-hidden mb-3 w-fit text-sm font-medium">
        <button type="button" id="tab-upload"
                onclick="switchTab('upload')"
                class="tab-btn px-4 py-2 bg-indigo-600 text-white transition-colors">
            📁 Upload from device
        </button>
        <button type="button" id="tab-url"
                onclick="switchTab('url')"
                class="tab-btn px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 transition-colors">
            🔗 Paste URL
        </button>
    </div>

    {{-- Upload panel --}}
    <div id="panel-upload">
        <label id="drop-zone"
               class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-400 transition-colors">
            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm text-gray-500">Click to browse or drag & drop</span>
            <span class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — max 2 MB</span>
            <input type="file" name="image_file" id="image_file" accept="image/jpeg,image/png,image/webp"
                   class="hidden" onchange="onFileSelected(this)">
        </label>
        @error('image_file')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- URL panel --}}
    <div id="panel-url" class="hidden">
        <input type="url" name="image_url" id="image_url_input"
               value="{{ old('image_url', $product?->image_url) }}"
               placeholder="https://example.com/product.jpg"
               oninput="onUrlInput(this.value)"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('image_url') border-red-300 @enderror">
        @error('image_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Live preview --}}
    <div id="img-preview-wrap" class="{{ ($product?->image_url && !old('image_file')) ? '' : 'hidden' }} mt-4 flex items-start gap-4">
        <div class="relative">
            <img id="img-preview"
                 src="{{ old('image_url', $product?->image_url) }}"
                 alt="Preview"
                 class="w-32 h-32 object-cover rounded-xl border border-gray-200 shadow-sm">
            <button type="button" onclick="clearImage()"
                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 shadow">
                ✕
            </button>
        </div>
        <div class="text-xs text-gray-500 pt-1">
            <p class="font-medium text-gray-700 mb-0.5">Preview</p>
            <p id="img-preview-info"></p>
        </div>
    </div>
</div>

<div class="flex items-center gap-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" id="is_active" name="is_active" value="1"
           {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}
           class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
    <label for="is_active" class="text-sm font-medium text-gray-700">Active (visible on shop)</label>
</div>

<script>
function switchTab(tab) {
    const isUpload = tab === 'upload';
    document.getElementById('panel-upload').classList.toggle('hidden', !isUpload);
    document.getElementById('panel-url').classList.toggle('hidden', isUpload);
    document.getElementById('tab-upload').className = 'tab-btn px-4 py-2 transition-colors ' + (isUpload ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50');
    document.getElementById('tab-url').className   = 'tab-btn px-4 py-2 transition-colors ' + (!isUpload ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50');
    if (isUpload) document.getElementById('image_url_input').value = '';
    else {
        const fi = document.getElementById('image_file');
        fi.value = ''; clearPreview();
    }
}

function onFileSelected(input) {
    const file = input.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    showPreview(url, file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)');
}

function onUrlInput(val) {
    if (val.match(/^https?:\/\/.+\.(jpg|jpeg|png|webp|gif)(\?.*)?$/i)) showPreview(val, '');
    else clearPreview();
}

function showPreview(src, info) {
    document.getElementById('img-preview').src = src;
    document.getElementById('img-preview-info').textContent = info;
    document.getElementById('img-preview-wrap').classList.remove('hidden');
}

function clearPreview() {
    document.getElementById('img-preview-wrap').classList.add('hidden');
    document.getElementById('img-preview').src = '';
}

function clearImage() {
    clearPreview();
    document.getElementById('image_file').value = '';
    document.getElementById('image_url_input').value = '';
}

// On load: if there's an existing URL, stay on URL tab
document.addEventListener('DOMContentLoaded', function () {
    const existingUrl = document.getElementById('image_url_input').value;
    if (existingUrl) {
        switchTab('url');
        showPreview(existingUrl, '');
    }
});
</script>
