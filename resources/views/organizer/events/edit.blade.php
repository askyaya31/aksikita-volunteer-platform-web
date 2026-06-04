@extends('layouts.organizer')
@section('title', 'Edit Event')

@push('styles')
<style>

    .ef-page {
        max-width: 720px;
        margin-inline: auto;
        padding-block: 32px 56px;
    }

    .ef-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--color-ink-muted);
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.15s;
    }
    .ef-back:hover { color: var(--color-navy); }
    .ef-back svg { flex-shrink: 0; }

    .ef-heading {
        font-family: var(--font-display);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-navy);
        letter-spacing: -0.02em;
        line-height: 1.3;
        margin-bottom: 4px;
    }
    .ef-subheading {
        font-size: 0.8125rem;
        color: var(--color-ink-muted);
        margin-bottom: 0;
    }

    .ef-alert-rejected {
        margin-top: 16px;
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-left: 3px solid var(--color-danger);
        border-radius: var(--radius-md);
        padding: 14px 16px;
        display: flex;
        gap: 12px;
    }
    .ef-alert-rejected__icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .ef-alert-rejected__title {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #991b1b;
        margin-bottom: 3px;
    }
    .ef-alert-rejected__reason {
        font-size: 0.8125rem;
        color: #b91c1c;
        line-height: 1.5;
    }
    .ef-alert-rejected__note {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 6px;
    }

    .ef-errors {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: var(--radius-md);
        padding: 12px 16px;
        margin-bottom: 20px;
    }
    .ef-errors__title {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #991b1b;
        margin-bottom: 8px;
    }
    .ef-errors__list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .ef-errors__item {
        font-size: 0.8125rem;
        color: #b91c1c;
        display: flex;
        align-items: flex-start;
        gap: 7px;
    }
    .ef-errors__item svg { flex-shrink: 0; margin-top: 2px; }

    .ef-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 20px 20px 22px;
        margin-bottom: 12px;
    }

    .ef-section-label {
        font-size: 0.6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--color-ink-muted);
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--color-border-soft);
    }

    .ef-label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--color-ink);
        margin-bottom: 6px;
    }
    .ef-label .req {
        color: var(--color-danger);
        margin-left: 2px;
    }
    .ef-hint {
        font-size: 0.75rem;
        color: var(--color-ink-muted);
        margin-bottom: 6px;
        margin-top: -2px;
    }

    .ef-input {
        width: 100%;
        height: 38px;
        padding: 0 12px;
        font-size: 0.875rem;
        font-family: var(--font-body);
        color: var(--color-ink);
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        appearance: none;
        -webkit-appearance: none;
    }
    .ef-input:focus {
        border-color: var(--color-blue);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .ef-input.is-error {
        border-color: var(--color-danger);
    }
    .ef-input.is-error:focus {
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }
    textarea.ef-input {
        height: auto;
        padding: 10px 12px;
        resize: vertical;
        line-height: 1.55;
    }

    .ef-fields { display: flex; flex-direction: column; gap: 14px; }
    .ef-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .ef-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }

    @media (max-width: 560px) {
        .ef-row-2,
        .ef-row-3 { grid-template-columns: 1fr; }
    }

    .ef-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 4px;
    }
    .ef-cat-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-full);
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--color-ink-soft);
        background: var(--color-surface);
        transition: all 0.15s;
        user-select: none;
    }
    .ef-cat-chip input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .ef-cat-chip:hover {
        border-color: var(--color-blue-mid);
        color: var(--color-navy);
    }
    .ef-cat-chip:has(input:checked) {
        border-color: var(--color-navy);
        background: var(--color-navy);
        color: #fff;
    }
    .ef-cat-chip__check {
        width: 13px;
        height: 13px;
        display: none;
        opacity: 0;
        transition: opacity 0.1s;
    }
    .ef-cat-chip:has(input:checked) .ef-cat-chip__check {
        display: block;
        opacity: 1;
    }

    .ef-poster-current {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: var(--color-bg);
        border: 1px solid var(--color-border-soft);
        border-radius: var(--radius-sm);
        margin-bottom: 10px;
    }
    .ef-poster-current img {
        width: 64px;
        height: 44px;
        object-fit: cover;
        border-radius: 5px;
        flex-shrink: 0;
    }
    .ef-poster-current__label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--color-ink);
    }
    .ef-poster-current__sub {
        font-size: 0.75rem;
        color: var(--color-ink-muted);
        margin-top: 1px;
    }

    .ef-upload-zone {
        border: 1.5px dashed var(--color-border);
        border-radius: var(--radius-sm);
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
    }
    .ef-upload-zone:hover {
        border-color: var(--color-blue-mid);
        background: var(--color-blue-ghost);
    }
    .ef-upload-zone__icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--color-blue-ghost);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }
    .ef-upload-zone__text {
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--color-ink-soft);
    }
    .ef-upload-zone__meta {
        font-size: 0.75rem;
        color: var(--color-ink-muted);
        margin-top: 3px;
    }
    #poster-preview-img {
        max-height: 130px;
        width: auto;
        margin: 0 auto 10px;
        display: block;
        border-radius: 6px;
        object-fit: cover;
    }

    .ef-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 24px;
    }
    .ef-btn-submit {
        flex: 1;
        height: 40px;
        padding: 0 20px;
        background: var(--color-navy);
        color: #fff;
        border: 1.5px solid var(--color-navy);
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s, box-shadow 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }
    .ef-btn-submit:hover {
        background: var(--color-navy-dark);
        box-shadow: 0 4px 14px rgba(30,58,138,0.22);
    }
    .ef-btn-cancel {
        height: 40px;
        padding: 0 20px;
        background: transparent;
        color: var(--color-ink-soft);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: border-color 0.15s, color 0.15s;
    }
    .ef-btn-cancel:hover {
        border-color: var(--color-ink-muted);
        color: var(--color-ink);
    }

    .ef-steps {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 24px;
        overflow-x: auto;
        padding-bottom: 2px;
    }
    .ef-step {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .ef-step__num {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--color-border-soft);
        color: var(--color-ink-muted);
        font-size: 0.6875rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .ef-step__label {
        font-size: 0.75rem;
        color: var(--color-ink-muted);
        font-weight: 500;
    }
    .ef-step-sep {
        width: 20px;
        height: 1px;
        background: var(--color-border);
        margin: 0 6px;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')

<div class="ef-page">
    <a href="{{ route('organizer.events.show', $event->id) }}" class="ef-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali ke detail event
    </a>
    <div style="margin-bottom: 20px;">
        <h1 class="ef-heading">Edit Event</h1>
        <p class="ef-subheading">Perubahan akan masuk ke antrian review admin sebelum dipublikasikan ulang.</p>
    </div>
    @if($event->status === 'rejected' && $event->rejection_reason)
        <div class="ef-alert-rejected" style="margin-bottom: 20px;">
            <div class="ef-alert-rejected__icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round">
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
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="0.5" fill="currentColor"/>
                        </svg>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ef-steps">
        <div class="ef-step">
            <div class="ef-step__num">1</div>
            <span class="ef-step__label">Informasi Utama</span>
        </div>
        <div class="ef-step-sep"></div>
        <div class="ef-step">
            <div class="ef-step__num">2</div>
            <span class="ef-step__label">Lokasi</span>
        </div>
        <div class="ef-step-sep"></div>
        <div class="ef-step">
            <div class="ef-step__num">3</div>
            <span class="ef-step__label">Jadwal & Kuota</span>
        </div>
        <div class="ef-step-sep"></div>
        <div class="ef-step">
            <div class="ef-step__num">4</div>
            <span class="ef-step__label">Kategori</span>
        </div>
        <div class="ef-step-sep"></div>
        <div class="ef-step">
            <div class="ef-step__num">5</div>
            <span class="ef-step__label">Narahubung & Media</span>
        </div>
    </div>

    <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="ef-card">
            <p class="ef-section-label">1 — Informasi Utama</p>
            <div class="ef-fields">

                <div>
                    <label class="ef-label">Judul Event <span class="req">*</span></label>
                    <input type="text" name="title"
                           value="{{ old('title', $event->title) }}"
                           placeholder="Contoh: Aksi Bersih Pantai Parangtritis"
                           class="ef-input @error('title') is-error @enderror">
                </div>

                <div>
                    <label class="ef-label">Deskripsi <span class="req">*</span></label>
                    <p class="ef-hint">Jelaskan tujuan, manfaat, dan gambaran kegiatan secara singkat.</p>
                    <textarea name="description" rows="4"
                              placeholder="Deskripsikan kegiatan ini..."
                              class="ef-input @error('description') is-error @enderror">{{ old('description', $event->description) }}</textarea>
                </div>

                <div>
                    <label class="ef-label">Syarat Peserta</label>
                    <p class="ef-hint">Opsional. Isi jika ada ketentuan khusus untuk relawan yang bergabung.</p>
                    <textarea name="requirements" rows="2"
                              placeholder="Contoh: Usia minimal 17 tahun, membawa perlengkapan pribadi."
                              class="ef-input">{{ old('requirements', $event->requirements) }}</textarea>
                </div>

            </div>
        </div>

        <div class="ef-card">
            <p class="ef-section-label">2 — Lokasi</p>
            <div class="ef-fields">

                <div>
                    <label class="ef-label">Nama Tempat <span class="req">*</span></label>
                    <input type="text" name="location_name"
                           value="{{ old('location_name', $event->location_name) }}"
                           placeholder="Contoh: Pantai Parangtritis"
                           class="ef-input @error('location_name') is-error @enderror">
                </div>

                <div>
                    <label class="ef-label">Alamat Lengkap</label>
                    <input type="text" name="location_address"
                           value="{{ old('location_address', $event->location_address) }}"
                           placeholder="Jl. Parangtritis km 28, Bantul"
                           class="ef-input">
                </div>

                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Kota <span class="req">*</span></label>
                        <input type="text" name="city"
                               value="{{ old('city', $event->city) }}"
                               placeholder="Yogyakarta"
                               class="ef-input @error('city') is-error @enderror">
                    </div>
                    <div>
                        <label class="ef-label">Provinsi <span class="req">*</span></label>
                        <input type="text" name="province"
                               value="{{ old('province', $event->province) }}"
                               placeholder="DI Yogyakarta"
                               class="ef-input @error('province') is-error @enderror">
                    </div>
                </div>

            </div>
        </div>

        <div class="ef-card">
            <p class="ef-section-label">3 — Jadwal & Kuota</p>
            <div class="ef-fields">

                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="start_date"
                               value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}"
                               class="ef-input @error('start_date') is-error @enderror">
                    </div>
                    <div>
                        <label class="ef-label">Tanggal Selesai <span class="req">*</span></label>
                        <input type="date" name="end_date"
                               value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}"
                               class="ef-input @error('end_date') is-error @enderror">
                    </div>
                </div>

                <div class="ef-row-3">
                    <div>
                        <label class="ef-label">Jam Mulai</label>
                        <input type="time" name="start_time"
                               value="{{ old('start_time', $event->start_time) }}"
                               class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Jam Selesai</label>
                        <input type="time" name="end_time"
                               value="{{ old('end_time', $event->end_time) }}"
                               class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Kuota <span class="req">*</span></label>
                        <input type="number" name="quota"
                               value="{{ old('quota', $event->quota) }}"
                               min="1"
                               placeholder="50"
                               class="ef-input @error('quota') is-error @enderror">
                    </div>
                </div>

            </div>
        </div>

        <div class="ef-card">
            <p class="ef-section-label">4 — Kategori <span style="color:var(--color-danger)">*</span></p>
            <p class="ef-hint" style="margin-bottom: 12px;">Pilih satu atau lebih kategori yang sesuai dengan kegiatan ini.</p>

            @php
                $selectedCategories = old('category_ids', $event->categories->pluck('id')->toArray());
            @endphp

            <div class="ef-categories">
                @foreach($categories as $cat)
                    <label class="ef-cat-chip" title="{{ $cat->name }}">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                               {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}>
                        <svg class="ef-cat-chip__check" viewBox="0 0 12 12" fill="none">
                            <path d="M2.5 6L5 8.5L9.5 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="ef-card">
            <p class="ef-section-label">5 — Narahubung & Media</p>
            <div class="ef-fields">

                <div class="ef-row-2">
                    <div>
                        <label class="ef-label">Nama Narahubung</label>
                        <input type="text" name="contact_person"
                               value="{{ old('contact_person', $event->contact_person) }}"
                               placeholder="Nama penanggung jawab"
                               class="ef-input">
                    </div>
                    <div>
                        <label class="ef-label">Nomor HP</label>
                        <input type="text" name="contact_phone"
                               value="{{ old('contact_phone', $event->contact_phone) }}"
                               placeholder="08xx-xxxx-xxxx"
                               class="ef-input">
                    </div>
                </div>

                <div>
                    <label class="ef-label">Poster Event</label>

                    @if($event->poster)
                        <div class="ef-poster-current">
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster saat ini">
                            <div>
                                <p class="ef-poster-current__label">Poster saat ini</p>
                                <p class="ef-poster-current__sub">Upload file baru untuk mengganti</p>
                            </div>
                        </div>
                    @endif

                    <div class="ef-upload-zone" onclick="document.getElementById('poster-input').click()">
                        <div id="ef-poster-placeholder">
                            <div class="ef-upload-zone__icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--color-blue)" stroke-width="1.8" stroke-linecap="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                            <p class="ef-upload-zone__text">
                                {{ $event->poster ? 'Klik untuk ganti poster' : 'Klik untuk upload poster' }}
                            </p>
                            <p class="ef-upload-zone__meta">JPG, PNG, WEBP — maks. 2 MB</p>
                        </div>
                        <div id="ef-poster-preview" style="display:none;">
                            <img id="ef-poster-preview-img" src="" alt="Preview poster">
                            <p class="ef-upload-zone__meta" style="margin-top:0;">Klik untuk ganti</p>
                        </div>
                        <input type="file" id="poster-input" name="poster"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               style="display:none;"
                               onchange="efPreviewPoster(this)">
                    </div>
                </div>

            </div>
        </div>

        <div class="ef-actions">
            <button type="submit" class="ef-btn-submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan &amp; Ajukan Ulang
            </button>
            <a href="{{ route('organizer.events.show', $event->id) }}" class="ef-btn-cancel">
                Batal
            </a>
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