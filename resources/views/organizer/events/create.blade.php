@extends('layouts.organizer')
@section('title', 'Buat Kegiatan')

@push('styles')
<style>
    :root {
        --color-navy: #1c3d72;
        --color-blue: #3b82f6;
        --color-blue-ghost: #eff6ff;
        --color-blue-mid: #bfdbfe;
        --color-ink: #1f2937;
        --color-ink-muted: #6b7280;
        --color-surface: #ffffff;
        --color-border: #e5e7eb;
        --color-bg: #f8fafc;
        --color-danger: #ef4444;
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-full: 9999px;
    }

    html {
        scroll-behavior: smooth;
    }

    .ef-page {
        max-width: 860px;
        margin-inline: auto;
        padding-block: 20px 64px;
        font-family: "Inter", sans-serif;
    }

    .ef-heading {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-navy);
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }
    .ef-subheading {
        font-size: 0.875rem;
        color: var(--color-blue);
        font-weight: 500;
        margin-bottom: 32px;
    }

    .ef-errors {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: var(--radius-sm);
        padding: 16px;
        margin-bottom: 32px;
    }
    .ef-errors__title { font-size: 0.875rem; font-weight: 600; color: #991b1b; margin-bottom: 8px; }
    .ef-errors__list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px; }
    .ef-errors__item { font-size: 0.8125rem; color: #b91c1c; display: flex; align-items: flex-start; gap: 6px; }

    .ef-steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
    }
    .ef-step {
        display: flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        text-decoration: none;
    }
    .ef-step__num {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--color-border); color: var(--color-ink-muted);
        font-size: 0.75rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
    }
    .ef-step__label {
        font-size: 0.8125rem; color: var(--color-ink-muted); font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.05em;
    }
    .ef-step-sep { flex-grow: 1; height: 1px; background: var(--color-border); margin: 0 16px; }

    .ef-card {
        background: var(--color-surface); border: 1px solid var(--color-border);
        border-radius: var(--radius-md); padding: 28px 32px; margin-bottom: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02); scroll-margin-top: 24px;
    }
    .ef-section-label { font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-ink); margin-bottom: 20px; border-b: 1px solid var(--color-border); padding-bottom: 12px; }
    .ef-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-ink); margin-bottom: 8px; }
    .ef-hint { font-size: 0.8125rem; color: var(--color-ink-muted); margin-bottom: 8px; margin-top: -4px; }
    .ef-input {
        width: 100%; height: 44px; padding: 0 14px; font-size: 0.875rem;
        color: var(--color-ink); background: var(--color-surface); border: 1px solid var(--color-border);
        border-radius: var(--radius-sm); outline: none; transition: all 0.2s ease;
    }
    .ef-input:focus { border-color: var(--color-blue); box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    textarea.ef-input { height: auto; padding: 12px 14px; resize: vertical; line-height: 1.6; }

    .ef-fields { display: flex; flex-direction: column; gap: 20px; }
    .ef-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .ef-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

    @media (max-width: 640px) {
        .ef-row-2, .ef-row-3 { grid-template-columns: 1fr; }
        .ef-steps { flex-direction: column; align-items: flex-start; gap: 12px; }
        .ef-step-sep { display: none; }
    }

    .ef-categories { display: flex; flex-wrap: wrap; gap: 10px; }
    .ef-cat-chip {
        display: flex; align-items: center; gap: 8px; padding: 8px 16px;
        border: 1px solid var(--color-border); border-radius: var(--radius-full);
        cursor: pointer; font-size: 0.875rem; font-weight: 500;
        color: var(--color-ink); background: var(--color-surface);
        transition: all 0.2s ease; user-select: none;
    }
    .ef-cat-chip input[type="checkbox"] { position: absolute; opacity: 0; pointer-events: none; }
    .ef-cat-chip:hover { border-color: var(--color-blue-mid); }
    .ef-cat-chip:has(input:checked) { border-color: var(--color-navy); background: var(--color-navy); color: #fff; }

    .ef-poster-current {
        display: flex; align-items: center; gap: 16px; padding: 12px;
        border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: var(--color-bg); margin-bottom: 16px;
    }
    .ef-poster-current img { width: 64px; height: 64px; object-fit: cover; border-radius: 6px; flex-shrink: 0; border: 1px solid var(--color-border); }
    .ef-poster-current__label { font-size: 0.875rem; font-weight: 600; color: var(--color-ink); }
    .ef-poster-current__sub { font-size: 0.8125rem; color: var(--color-ink-muted); }

    .ef-upload-zone {
        border: 1px dashed var(--color-border); border-radius: var(--radius-sm);
        padding: 24px 20px; text-align: center; cursor: pointer; transition: all 0.2s ease;
    }
    .ef-upload-zone:hover { border-color: var(--color-blue); background: var(--color-blue-ghost); }
    .ef-upload-zone__text { font-size: 0.875rem; font-weight: 600; color: var(--color-ink); text-decoration: underline; }
    .ef-upload-zone__meta { font-size: 0.8125rem; color: var(--color-ink-muted); margin-top: 4px; }
    .ef-btn-submit {
        width: 100%; height: 48px; background: var(--color-navy); color: #fff;
        border: none; border-radius: var(--radius-sm); font-size: 1rem; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        gap: 8px; transition: all 0.2s ease; margin-top: 16px;
    }
    .ef-btn-submit:hover { background: #152c55; box-shadow: 0 4px 12px rgba(28,61,114,0.2); }
</style>
@endpush

@section('content')
<div class="ef-page">

    <div class="reveal mb-6">
        <h1 class="ef-heading">Edit Kegiatan</h1>
        <p class="ef-subheading">Perubahan akan masuk ke antrian review admin sebelum dipublikasikan ulang.</p>
    </div>

    <div class="ef-steps reveal">
        <a href="#section-1" class="ef-step">
            <div class="ef-step__num" style="background:var(--color-navy); color:#fff;">1</div>
            <span class="ef-step__label" style="color:var(--color-navy);">Informasi Utama</span>
        </a>
        <div class="ef-step-sep"></div>
        <a href="#section-2" class="ef-step">
            <div class="ef-step__num">2</div>
            <span class="ef-step__label">Lokasi</span>
        </a>
        <div class="ef-step-sep"></div>
        <a href="#section-3" class="ef-step">
            <div class="ef-step__num">3</div>
            <span class="ef-step__label">Jadwal & Kuota</span>
        </a>
        <div class="ef-step-sep"></div>
        <a href="#section-4" class="ef-step">
            <div class="ef-step__num">4</div>
            <span class="ef-step__label">Kategori</span>
        </a>
        <div class="ef-step-sep"></div>
        <a href="#section-5" class="ef-step">
            <div class="ef-step__num">5</div>
            <span class="ef-step__label">Narahubung</span>
        </a>
    </div>

    @if($errors->any())
        <div class="ef-errors reveal">
            <p class="ef-errors__title">Perbaiki kesalahan berikut:</p>
            <ul class="ef-errors__list">
                @foreach($errors->all() as $error)
                    <li class="ef-errors__item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="flex-shrink:0; margin-top:2px;">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="1" fill="currentColor"/>
                        </svg>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="ef-card reveal" id="section-1">
            <h2 class="ef-section-label">1 — Informasi Utama</h2>
            
            <div class="ef-fields">
                <div>
                    <label class="ef-label">Judul Event <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="ef-input @error('title') border-red-400 @enderror">
                </div>

                <div>
                    <label class="ef-label">Deskripsi <span class="text-red-500">*</span></label>
                    <p class="ef-hint">Jelaskan tujuan, manfaat, dan gambaran kegiatan secara singkat.</p>
                    <textarea name="description" rows="4" class="ef-input @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="ef-label">Syarat Peserta</label>
                    <p class="ef-hint">Opsional. Isi jika ada ketentuan khusus untuk relawan yang bergabung.</p>
                    <textarea name="requirements" rows="3" class="ef-input">{{ old('requirements') }}</textarea>
                </div>
            </div>
        </div>

        <div class="ef-card reveal" id="section-2">
            <h2 class="ef-section-label">2 — Lokasi</h2>
            
            <div class="ef-fields">
                <div>
                    <label class="ef-label">Nama Tempat <span class="text-red-500">*</span></label>
                    <input type="text" name="location_name" value="{{ old('location_name') }}" class="ef-input @error('location_name') border-red-400 @enderror">
                </div>

                <div>
                    <label class="ef-label">Alamat Lengkap</label>
                    <input type="text" name="location_address" value="{{ old('location_address') }}" class="ef-input">
                </div>

                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Kota <span class="text-red-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city') }}" class="ef-input @error('city') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="ef-label">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="province" value="{{ old('province') }}" class="ef-input @error('province') border-red-400 @enderror">
                    </div>
                </div>
            </div>
        </div>

        <div class="ef-card reveal" id="section-3">
            <h2 class="ef-section-label">3 — Jadwal & Kuota</h2>
            
            <div class="ef-fields">
                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" class="ef-input @error('start_date') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="ef-label">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="ef-input @error('end_date') border-red-400 @enderror">
                    </div>
                </div>

                <div class="ef-row-3">
                    <div>
                        <label class="ef-label">Waktu Mulai</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Waktu Selesai</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Kuota <span class="text-red-500">*</span></label>
                        <input type="number" name="quota" value="{{ old('quota', 30) }}" min="1" class="ef-input @error('quota') border-red-400 @enderror">
                    </div>
                </div>
            </div>
        </div>

        <div class="ef-card reveal" id="section-4">
            <h2 class="ef-section-label" style="border:none; margin-bottom:4px;">4 — Kategori <span class="text-red-500">*</span></h2>
            <p class="ef-hint" style="margin-bottom: 20px;">Pilih satu atau lebih kategori yang sesuai dengan kegiatan ini.</p>

            <div class="ef-categories">
                @foreach($categories as $cat)
                    <label class="ef-cat-chip">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                               {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}>
                        <span>{{ $cat->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="ef-card reveal" id="section-5">
            <h2 class="ef-section-label">5 — Narahubung & Media</h2>

            <div class="ef-fields">
                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Nama Narahubung</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Nomor Telepon</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="08xxxxxxxxxx" class="ef-input">
                    </div>
                </div>

                <div>
                    <label class="ef-label">Poster Event</label>
                    
                    <div class="ef-poster-current">
                        <div class="w-16 h-16 bg-slate-200 rounded-lg flex items-center justify-center border border-slate-300 overflow-hidden flex-shrink-0">
                            <div id="poster-preview" class="hidden w-full h-full">
                                <img id="poster-img" src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <div id="poster-placeholder-icon" class="w-full h-full opacity-30 bg-[radial-gradient(#000_20%,transparent_20%)] [background-size:8px_8px]"></div>
                        </div>
                        <div>
                            <p class="ef-poster-current__label">Poster saat ini.</p>
                            <p class="ef-poster-current__sub">Upload file baru untuk ganti</p>
                        </div>
                    </div>

                    <div class="ef-upload-zone" onclick="document.getElementById('poster-input').click()">
                        <span class="ef-upload-zone__text">Klik untuk ganti poster.</span>
                        <p class="ef-upload-zone__meta">JPG, PNG, WEBP maks 2MB</p>
                        
                        <input type="file" id="poster-input" name="poster"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="hidden"
                               onchange="previewPoster(this)">
                    </div>
                </div>
            </div>
        </div>

        <div class="reveal pt-2">
            <button type="submit" class="ef-btn-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Draft
            </button>
        </div>
    </form>
</div>

<script>
function previewPoster(input) {
    const preview = document.getElementById('poster-preview');
    const placeholderIcon = document.getElementById('poster-placeholder-icon');
    const img = document.getElementById('poster-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            preview.classList.remove('hidden');
            placeholderIcon.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection