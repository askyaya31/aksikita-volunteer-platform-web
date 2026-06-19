@extends('layouts.organizer')
@section('title', 'Buat Event Baru')

@push('styles')
<style>
    /* ─── PAGE ───────────────────────────────────────────────────── */
    .cr-page {
        max-width: 780px;
        margin-inline: auto;
        padding: 32px 24px 64px;
    }

    /* ─── HEADER ─────────────────────────────────────────────────── */
    .cr-title {
        font-family: 'Sora', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0F2057;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }
    .cr-subtitle {
        font-size: 0.8rem;
        color: #3B82F6;
        font-weight: 500;
        margin-bottom: 28px;
    }

    /* ─── STEPPER ────────────────────────────────────────────────── */
    .cr-stepper {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 28px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .cr-step {
        display: flex;
        align-items: center;
        gap: 7px;
        flex: 1;
        position: relative;
    }
    .cr-step::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #E5E7EB;
        margin: 0 6px;
    }
    .cr-step:last-child::after { display: none; }

    .cr-step__num {
        width: 22px; height: 22px;
        border-radius: 50%;
        background: #E5E7EB;
        color: #9CA3AF;
        font-size: 0.65rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cr-step__label {
        font-size: 0.62rem;
        font-weight: 600;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }

    /* ─── ERROR BANNER ───────────────────────────────────────────── */
    .cr-errors {
        background: #FFF5F5;
        border: 1px solid #FECACA;
        border-left: 3px solid #EF4444;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 20px;
    }
    .cr-errors__title { font-size: 0.8rem; font-weight: 700; color: #991B1B; margin-bottom: 8px; }
    .cr-errors__item {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        font-size: 0.78rem;
        color: #B91C1C;
        margin-bottom: 4px;
    }

    /* ─── SECTION CARD ───────────────────────────────────────────── */
    .cr-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 16px;
    }
    .cr-card-title {
        font-family: 'Sora', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        color: #1F2937;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding-bottom: 14px;
        border-bottom: 1px solid #F1F5F9;
        margin-bottom: 20px;
    }

    /* ─── FORM ELEMENTS ──────────────────────────────────────────── */
    .cr-field { margin-bottom: 18px; }
    .cr-field:last-child { margin-bottom: 0; }

    .cr-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 5px;
    }
    .cr-label-hint {
        display: block;
        font-size: 0.72rem;
        color: #6B7280;
        font-weight: 400;
        margin-bottom: 7px;
        margin-top: -2px;
    }
    .cr-required { color: #EF4444; }

    .cr-input,
    .cr-textarea {
        width: 100%;
        padding: 11px 16px;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        color: #1F2937;
        background: #FFFFFF;
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
    }
    .cr-input::placeholder,
    .cr-textarea::placeholder { color: #C4CADA; }
    .cr-input:focus,
    .cr-textarea:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .cr-input.is-error,
    .cr-textarea.is-error { border-color: #F87171; }
    .cr-textarea { resize: none; line-height: 1.65; }

    .cr-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .cr-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
    @media (max-width: 560px) {
        .cr-grid-2, .cr-grid-3 { grid-template-columns: 1fr; }
    }

    /* ─── CATEGORY PILLS ─────────────────────────────────────────── */
    .cr-cat-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .cr-cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 99px;
        border: 1.5px solid #E5E7EB;
        cursor: pointer;
        transition: all 0.15s;
        font-size: 0.78rem;
        font-weight: 500;
        color: #6B7280;
        background: #FFFFFF;
        user-select: none;
    }
    .cr-cat-pill:hover { border-color: #3B82F6; color: #1D4ED8; }
    .cr-cat-pill input[type="checkbox"] { display: none; }
    .cr-cat-pill__check {
        width: 14px; height: 14px;
        border-radius: 50%;
        background: #0F2057;
        display: none;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cr-cat-pill:has(input:checked) {
        border-color: #0F2057;
        background: #0F2057;
        color: #FFFFFF;
        font-weight: 600;
    }
    .cr-cat-pill:has(input:checked) .cr-cat-pill__check { display: inline-flex; }

    /* ─── POSTER UPLOAD ──────────────────────────────────────────── */
    .cr-poster-drop {
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        padding: 36px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        background: #FAFBFC;
    }
    .cr-poster-drop:hover { border-color: #3B82F6; background: #F8FBFF; }
    .cr-poster-drop__link { font-size: 0.82rem; font-weight: 600; color: #1D4ED8; text-decoration: underline; text-underline-offset: 2px; }
    .cr-poster-drop__hint { font-size: 0.72rem; color: #9CA3AF; margin-top: 4px; }
    #cr-poster-preview { display: none; margin-bottom: 12px; }
    #cr-poster-preview img { max-height: 160px; margin: 0 auto; border-radius: 10px; object-fit: cover; display: block; }

    /* ─── ACTION BUTTONS ─────────────────────────────────────────── */
    .cr-actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }
    .cr-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 46px;
        padding: 0 24px;
        border-radius: 10px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        border: none;
    }
    .cr-btn--primary {
        flex: 1;
        background: #0F2057;
        color: #FFFFFF;
    }
    .cr-btn--primary:hover { background: #1a3070; color: #FFFFFF; }
    .cr-btn--cancel {
        background: #EF4444;
        color: #FFFFFF;
        padding: 0 32px;
    }
    .cr-btn--cancel:hover { background: #DC2626; color: #FFFFFF; }
</style>
@endpush

@section('content')

<div class="cr-page">

    {{-- Header --}}
    <h1 class="cr-title">Buat Event Baru</h1>
    <p class="cr-subtitle">Event akan masuk ke antrian review admin sebelum dipublikasikan.</p>

    {{-- Stepper --}}
    <div class="cr-stepper">
        <div class="cr-step">
            <div class="cr-step__num">1</div>
            <span class="cr-step__label">Informasi Utama</span>
        </div>
        <div class="cr-step">
            <div class="cr-step__num">2</div>
            <span class="cr-step__label">Lokasi</span>
        </div>
        <div class="cr-step">
            <div class="cr-step__num">3</div>
            <span class="cr-step__label">Jadwal &amp; Kuota</span>
        </div>
        <div class="cr-step">
            <div class="cr-step__num">4</div>
            <span class="cr-step__label">Kategori</span>
        </div>
        <div class="cr-step">
            <div class="cr-step__num">5</div>
            <span class="cr-step__label">Narahubung &amp; Media</span>
        </div>
    </div>

    {{-- Error banner --}}
    @if($errors->any())
        <div class="cr-errors">
            <p class="cr-errors__title">Perbaiki kesalahan berikut:</p>
            @foreach($errors->all() as $error)
                <div class="cr-errors__item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ── 1. Informasi Utama ── --}}
        <div class="cr-card">
            <p class="cr-card-title">Informasi Utama</p>

            <div class="cr-field">
                <label class="cr-label">Judul Event <span class="cr-required">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="Contoh: Bersih Pantai..."
                       class="cr-input {{ $errors->has('title') ? 'is-error' : '' }}">
            </div>

            <div class="cr-field">
                <label class="cr-label">Deskripsi <span class="cr-required">*</span></label>
                <span class="cr-label-hint">Jelaskan tujuan, manfaat, dan gambaran kegiatan secara singkat.</span>
                <textarea name="description" rows="5"
                          placeholder="Ceritakan mengenai kegiatan ini, tujuannya, kegiatannya, dampak yang ingin dicapai."
                          class="cr-textarea {{ $errors->has('description') ? 'is-error' : '' }}">{{ old('description') }}</textarea>
            </div>

            <div class="cr-field">
                <label class="cr-label">Syarat Peserta</label>
                <span class="cr-label-hint">Opsional. Isi jika ada ketentuan khusus untuk relawan yang bergabung.</span>
                <textarea name="requirements" rows="3"
                          placeholder="Contoh: Usia minimal 17 tahun. Membawa peralatan sendiri."
                          class="cr-textarea">{{ old('requirements') }}</textarea>
            </div>
        </div>

        {{-- ── 2. Lokasi ── --}}
        <div class="cr-card">
            <p class="cr-card-title">Lokasi</p>

            <div class="cr-field">
                <label class="cr-label">Nama Tempat <span class="cr-required">*</span></label>
                <input type="text" name="location_name" value="{{ old('location_name') }}"
                       placeholder="Contoh: Taman Nasional"
                       class="cr-input {{ $errors->has('location_name') ? 'is-error' : '' }}">
            </div>

            <div class="cr-field">
                <label class="cr-label">Alamat Lengkap</label>
                <input type="text" name="location_address" value="{{ old('location_address') }}"
                       placeholder="Jalan, Kelurahan, Kecamatan"
                       class="cr-input">
            </div>

            <div class="cr-grid-2">
                <div class="cr-field">
                    <label class="cr-label">Kota <span class="cr-required">*</span></label>
                    <input type="text" name="city" value="{{ old('city') }}"
                           class="cr-input {{ $errors->has('city') ? 'is-error' : '' }}">
                </div>
                <div class="cr-field">
                    <label class="cr-label">Provinsi <span class="cr-required">*</span></label>
                    <input type="text" name="province" value="{{ old('province') }}"
                           class="cr-input {{ $errors->has('province') ? 'is-error' : '' }}">
                </div>
            </div>
        </div>

        {{-- ── 3. Jadwal & Kuota ── --}}
        <div class="cr-card">
            <p class="cr-card-title">Jadwal &amp; Kuota</p>

            <div class="cr-grid-2 cr-field">
                <div>
                    <label class="cr-label">Tanggal Mulai <span class="cr-required">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                           min="{{ date('Y-m-d') }}"
                           class="cr-input {{ $errors->has('start_date') ? 'is-error' : '' }}">
                </div>
                <div>
                    <label class="cr-label">Tanggal Selesai <span class="cr-required">*</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                           class="cr-input {{ $errors->has('end_date') ? 'is-error' : '' }}">
                </div>
            </div>

            <div class="cr-grid-3">
                <div class="cr-field">
                    <label class="cr-label">Waktu Mulai</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="cr-input">
                </div>
                <div class="cr-field">
                    <label class="cr-label">Waktu Selesai</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="cr-input">
                </div>
                <div class="cr-field">
                    <label class="cr-label">Kuota <span class="cr-required">*</span></label>
                    <input type="number" name="quota" value="{{ old('quota', 30) }}" min="1"
                           class="cr-input {{ $errors->has('quota') ? 'is-error' : '' }}">
                </div>
            </div>
        </div>

        {{-- ── 4. Kategori ── --}}
        <div class="cr-card">
            <p class="cr-card-title">Kategori</p>
            <p style="font-size:0.78rem;color:#6B7280;margin-top:-12px;margin-bottom:16px;">Pilih satu atau lebih kategori yang sesuai dengan kegiatan ini.</p>

            <div class="cr-cat-wrap">
                @foreach($categories as $cat)
                    <label class="cr-cat-pill">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                               {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}>
                        <span class="cr-cat-pill__check">
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- ── 5. Narahubung & Media ── --}}
        <div class="cr-card">
            <p class="cr-card-title">Narahubung &amp; Media</p>

            <div class="cr-grid-2 cr-field">
                <div>
                    <label class="cr-label">Nama Narahubung</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="cr-input">
                </div>
                <div>
                    <label class="cr-label">Nomor Telepon</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                           placeholder="08xxxxxxxxxx" class="cr-input">
                </div>
            </div>

            <div class="cr-field">
                <label class="cr-label">Poster Event</label>
                <div class="cr-poster-drop" onclick="document.getElementById('cr-poster-input').click()">
                    <div id="cr-poster-preview">
                        <img id="cr-poster-img" src="" alt="Preview poster">
                    </div>
                    <div id="cr-poster-placeholder">
                        <p class="cr-poster-drop__link">Klik untuk ganti poster.</p>
                        <p class="cr-poster-drop__hint">JPG, PNG, WEBP maks 2MB</p>
                    </div>
                    <input type="file" id="cr-poster-input" name="poster"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           style="display:none;"
                           onchange="crPreviewPoster(this)">
                </div>
            </div>
        </div>

        {{-- ── Actions ── --}}
        <div class="cr-actions">
            <button type="submit" class="cr-btn cr-btn--primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="9 9 12 6 15 9"/><line x1="12" y1="6" x2="12" y2="18"/>
                </svg>
                Buat Event &amp; Ajukan Review
            </button>
            <a href="{{ route('organizer.events') }}" class="cr-btn cr-btn--cancel">Batal</a>
        </div>

    </form>
</div>

<script>
function crPreviewPoster(input) {
    const preview     = document.getElementById('cr-poster-preview');
    const placeholder = document.getElementById('cr-poster-placeholder');
    const img         = document.getElementById('cr-poster-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection