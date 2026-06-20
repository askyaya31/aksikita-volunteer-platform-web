@extends('layouts.organizer')
@section('title', 'Edit Event')

@push('styles')
<style>
    :root {
        --color-navy: #1c3d72; 
        --color-blue: #3b82f6;
        --color-blue-ghost: #eff6ff;
        --color-blue-mid: #bfdbfe;
        --color-ink: #1f2937;
        --color-ink-muted: #6b7280;
        --color-ink-soft: #9ca3af;
        --color-surface: #ffffff;
        --color-border: #e5e7eb;
        --color-bg: #f8fafc;
        --color-danger: #ef4444;
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-full: 9999px;
        --font-display: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        --font-body: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    html {
        scroll-behavior: smooth;
    }

    .ef-page {
        max-width: 860px;
        margin-inline: auto;
        padding-block: 40px 64px;
        font-family: var(--font-body);
    }

    .ef-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--color-ink-muted);
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.15s;
    }
    .ef-back:hover { color: var(--color-navy); }

    .ef-heading {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-navy);
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }
    .ef-subheading {
        font-size: 0.875rem;
        color: var(--color-ink-muted);
        margin-bottom: 32px;
    }

    .ef-alert-rejected, .ef-errors {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: var(--radius-sm);
        padding: 16px;
        margin-bottom: 24px;
    }
    .ef-alert-rejected { border-left: 4px solid var(--color-danger); display: flex; gap: 12px; }
    .ef-alert-rejected__icon { width: 32px; height: 32px; border-radius: 8px; background: #fee2e2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ef-alert-rejected__title { font-size: 0.875rem; font-weight: 600; color: #991b1b; margin-bottom: 4px; }
    .ef-alert-rejected__reason { font-size: 0.875rem; color: #b91c1c; line-height: 1.5; }
    .ef-alert-rejected__note { font-size: 0.75rem; color: #ef4444; margin-top: 8px; }
    
    .ef-errors__title { font-size: 0.875rem; font-weight: 600; color: #991b1b; margin-bottom: 8px; }
    .ef-errors__list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px; }
    .ef-errors__item { font-size: 0.8125rem; color: #b91c1c; display: flex; align-items: flex-start; gap: 6px; }

    .ef-steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }
    .ef-step {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--color-bg);
        z-index: 1;
        padding-right: 12px;
        text-decoration: none; 
        transition: opacity 0.2s;
    }
    .ef-step:hover {
        opacity: 0.8;
    }
    .ef-step__num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--color-border);
        color: var(--color-ink-muted);
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, color 0.2s;
    }
    .ef-step__label {
        font-size: 0.8125rem;
        color: var(--color-ink-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.2s;
    }
    .ef-step-sep {
        flex-grow: 1;
        height: 1px;
        background: var(--color-border);
        margin: 0 16px;
    }

    .ef-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        scroll-margin-top: 100px; 
    }

    .ef-section-label {
        font-size: 0.8125rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--color-ink);
        margin-bottom: 20px;
    }

    .ef-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-ink);
        margin-bottom: 8px;
    }
    .ef-label .req { color: var(--color-danger); margin-left: 2px; }
    .ef-hint {
        font-size: 0.8125rem;
        color: var(--color-ink-muted);
        margin-bottom: 8px;
        margin-top: -4px;
    }

    .ef-input {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        font-size: 0.875rem;
        font-family: var(--font-body);
        color: var(--color-ink);
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        outline: none;
        transition: all 0.2s ease;
    }
    .ef-input:focus {
        border-color: var(--color-blue);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .ef-input.is-error { border-color: var(--color-danger); }
    textarea.ef-input { height: auto; padding: 12px 14px; resize: vertical; line-height: 1.6; }

    .ef-fields { display: flex; flex-direction: column; gap: 20px; }
    .ef-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .ef-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

    @media (max-width: 640px) {
        .ef-row-2, .ef-row-3 { grid-template-columns: 1fr; }
        .ef-steps { flex-direction: column; align-items: flex-start; gap: 12px; }
        .ef-step-sep { display: none; }
    }

    .ef-categories { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
    .ef-cat-chip {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 16px;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-full);
        cursor: pointer;
        font-size: 0.875rem; font-weight: 500;
        color: var(--color-ink); background: var(--color-surface);
        transition: all 0.2s ease; user-select: none;
    }
    .ef-cat-chip input[type="checkbox"] { position: absolute; opacity: 0; pointer-events: none; }
    .ef-cat-chip:hover { border-color: var(--color-blue-mid); }
    .ef-cat-chip:has(input:checked) {
        border-color: var(--color-navy); background: var(--color-navy); color: #fff;
    }
    .ef-cat-chip__check {
        width: 14px; height: 14px; display: none;
    }
    .ef-cat-chip:has(input:checked) .ef-cat-chip__check { display: block; }

    .ef-poster-current {
        display: flex; align-items: center; gap: 16px;
        padding: 12px; border: 1px solid var(--color-border);
        border-radius: var(--radius-sm); margin-bottom: 16px;
    }
    .ef-poster-current img { width: 80px; height: 56px; object-fit: cover; border-radius: 6px; flex-shrink: 0; }
    .ef-poster-current__label { font-size: 0.875rem; font-weight: 600; color: var(--color-ink); }
    .ef-poster-current__sub { font-size: 0.8125rem; color: var(--color-ink-muted); margin-top: 2px; }

    .ef-upload-zone {
        border: 2px dashed var(--color-border);
        border-radius: var(--radius-sm);
        padding: 32px 20px; text-align: center; cursor: pointer;
        transition: all 0.2s ease;
    }
    .ef-upload-zone:hover { border-color: var(--color-blue); background: var(--color-blue-ghost); }
    .ef-upload-zone__icon {
        width: 48px; height: 48px; border-radius: 12px; background: var(--color-blue-ghost);
        display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;
    }
    .ef-upload-zone__icon svg { color: var(--color-navy); }
    .ef-upload-zone__text { font-size: 0.875rem; font-weight: 600; color: var(--color-navy); margin-bottom: 4px; }
    .ef-upload-zone__meta { font-size: 0.8125rem; color: var(--color-ink-muted); }
    #ef-poster-preview-img { max-height: 160px; width: auto; margin: 0 auto 12px; display: block; border-radius: 8px; object-fit: cover; }

    .ef-actions {
        display: flex; gap: 16px; align-items: center; margin-top: 32px;
    }
    .ef-btn-submit {
        flex: 1; height: 48px; padding: 0 24px;
        background: var(--color-navy); color: #fff;
        border: none; border-radius: var(--radius-sm);
        font-family: var(--font-body); font-size: 1rem; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.2s ease;
    }
    .ef-btn-submit:hover { background: #152c55; box-shadow: 0 4px 12px rgba(28,61,114,0.2); }
    
    .ef-btn-cancel {
        height: 48px; padding: 0 24px;
        background: transparent; color: var(--color-ink);
        border: 1px solid var(--color-border); border-radius: var(--radius-sm);
        font-family: var(--font-body); font-size: 1rem; font-weight: 600;
        cursor: pointer; text-decoration: none; display: flex; align-items: center;
        transition: all 0.2s ease;
    }
    .ef-btn-cancel:hover { background: var(--color-border-soft); }
</style>
@endpush

@section('content')
<div class="ef-page">
    <a href="{{ route('organizer.events.show', $event->id) }}" class="ef-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali ke detail event
    </a>
    
    <div style="margin-bottom: 24px;">
        <h1 class="ef-heading">Edit Kegiatan</h1>
        <p class="ef-subheading">Perubahan akan masuk ke antrian review admin sebelum dipublikasikan ulang.</p>
    </div>

    @if($event->status === 'rejected' && $event->rejection_reason)
        <div class="ef-alert-rejected">
            <div class="ef-alert-rejected__icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <p class="ef-alert-rejected__title">Event ditolak oleh admin</p>
                <p class="ef-alert-rejected__reason">{{ $event->rejection_reason }}</p>
                <p class="ef-alert-rejected__note">Perbaiki sesuai catatan di atas, lalu simpan untuk mengajukan ulang.</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="ef-errors">
            <p class="ef-errors__title">Perbaiki kesalahan berikut:</p>
            <ul class="ef-errors__list">
                @foreach($errors->all() as $error)
                    <li class="ef-errors__item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="1" fill="currentColor"/>
                        </svg>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ef-steps">
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
            <span class="ef-step__label">Media</span>
        </a>
    </div>

    <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="ef-card" id="section-1">
            <p class="ef-section-label">1 — Informasi Utama</p>
            <div class="ef-fields">
                <div>
                    <label class="ef-label">Judul Event <span class="req">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" placeholder="Contoh: Aksi Bersih Pantai Parangtritis" class="ef-input @error('title') is-error @enderror">
                </div>
                <div>
                    <label class="ef-label">Deskripsi <span class="req">*</span></label>
                    <p class="ef-hint">Jelaskan tujuan, manfaat, dan gambaran kegiatan secara singkat.</p>
                    <textarea name="description" rows="4" placeholder="Deskripsikan kegiatan ini..." class="ef-input @error('description') is-error @enderror">{{ old('description', $event->description) }}</textarea>
                </div>
                <div>
                    <label class="ef-label">Syarat Peserta</label>
                    <p class="ef-hint">Opsional. Isi jika ada ketentuan khusus untuk relawan yang bergabung.</p>
                    <textarea name="requirements" rows="2" placeholder="Contoh: Usia minimal 17 tahun, membawa perlengkapan pribadi." class="ef-input">{{ old('requirements', $event->requirements) }}</textarea>
                </div>
            </div>
        </div>

        <div class="ef-card" id="section-2">
            <p class="ef-section-label">2 — Lokasi</p>
            <div class="ef-fields">
                <div>
                    <label class="ef-label">Nama Tempat <span class="req">*</span></label>
                    <input type="text" name="location_name" value="{{ old('location_name', $event->location_name) }}" placeholder="Contoh: Pantai Parangtritis" class="ef-input @error('location_name') is-error @enderror">
                </div>
                <div>
                    <label class="ef-label">Alamat Lengkap</label>
                    <input type="text" name="location_address" value="{{ old('location_address', $event->location_address) }}" placeholder="Jl. Parangtritis km 28, Bantul" class="ef-input">
                </div>
                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Kota <span class="req">*</span></label>
                        <input type="text" name="city" value="{{ old('city', $event->city) }}" placeholder="Yogyakarta" class="ef-input @error('city') is-error @enderror">
                    </div>
                    <div>
                        <label class="ef-label">Provinsi <span class="req">*</span></label>
                        <input type="text" name="province" value="{{ old('province', $event->province) }}" placeholder="DI Yogyakarta" class="ef-input @error('province') is-error @enderror">
                    </div>
                </div>
            </div>
        </div>

        <div class="ef-card" id="section-3">
            <p class="ef-section-label">3 — Jadwal & Kuota</p>
            <div class="ef-fields">
                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" class="ef-input @error('start_date') is-error @enderror">
                    </div>
                    <div>
                        <label class="ef-label">Tanggal Selesai <span class="req">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" class="ef-input @error('end_date') is-error @enderror">
                    </div>
                </div>
                <div class="ef-row-3">
                    <div>
                        <label class="ef-label">Jam Mulai</label>
                        <input type="time" name="start_time" value="{{ old('start_time', $event->start_time) }}" class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Jam Selesai</label>
                        <input type="time" name="end_time" value="{{ old('end_time', $event->end_time) }}" class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Kuota <span class="req">*</span></label>
                        <input type="number" name="quota" value="{{ old('quota', $event->quota) }}" min="1" placeholder="50" class="ef-input @error('quota') is-error @enderror">
                    </div>
                </div>
            </div>
        </div>

        <div class="ef-card" id="section-4">
            <p class="ef-section-label">4 — Kategori <span class="req">*</span></p>
            <p class="ef-hint" style="margin-bottom: 16px;">Pilih satu atau lebih kategori yang sesuai dengan kegiatan ini.</p>
            
            @php
                $selectedCategories = old('category_ids', $event->categories->pluck('id')->toArray());
            @endphp
            
            <div class="ef-categories">
                @foreach($categories as $cat)
                    <label class="ef-cat-chip" title="{{ $cat->name }}">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}>
                        <svg class="ef-cat-chip__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="ef-card" id="section-5">
            <p class="ef-section-label">5 — Narahubung & Media</p>
            <div class="ef-fields">
                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Nama Narahubung</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person', $event->contact_person) }}" placeholder="Nama penanggung jawab" class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Nomor HP</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $event->contact_phone) }}" placeholder="08xx-xxxx-xxxx" class="ef-input">
                    </div>
                </div>
                <div>
                    <label class="ef-label">Poster Event</label>
                    @if($event->poster)
                        <div class="ef-poster-current">
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster saat ini">
                            <div>
                                <p class="ef-poster-current__label">Poster saat ini</p>
                                <p class="ef-poster-current__sub">Upload file baru di bawah ini untuk mengganti</p>
                            </div>
                        </div>
                    @endif
                    <div class="ef-upload-zone" onclick="document.getElementById('poster-input').click()">
                        <div id="ef-poster-placeholder">
                            <div class="ef-upload-zone__icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <p class="ef-upload-zone__text">{{ $event->poster ? 'Klik untuk ganti poster' : 'Klik untuk upload poster' }}</p>
                            <p class="ef-upload-zone__meta">Format JPG, PNG, WEBP (Maks. 2 MB)</p>
                        </div>
                        <div id="ef-poster-preview" style="display:none;">
                            <img id="ef-poster-preview-img" src="" alt="Preview poster">
                            <p class="ef-upload-zone__meta" style="margin-top:0;">Klik lagi untuk ganti gambar lain</p>
                        </div>
                        <input type="file" id="poster-input" name="poster" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;" onchange="efPreviewPoster(this)">
                    </div>
                </div>
            </div>
        </div>

        <div class="ef-actions">
            <a href="{{ route('organizer.events.show', $event->id) }}" class="ef-btn-cancel">Batal</a>
            <button type="submit" class="ef-btn-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Perubahan & Ajukan Ulang
            </button>
        </div>
    </form>
</div>

<script>
function efPreviewPoster(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('ef-poster-preview-img').src = e.target.result;
        document.getElementById('ef-poster-placeholder').style.display = 'none';
        document.getElementById('ef-poster-preview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection