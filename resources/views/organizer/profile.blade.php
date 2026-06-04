@extends('layouts.organizer')
@section('title', 'Profil Organisasi')

@push('styles')
<style>
.org-page-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2rem 0 1.75rem;
}
.org-page-hero-title {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 22px; font-weight: 700;
    color: #fff; line-height: 1.2;
}

.prof-section {
    background: #fff;
    border: 1.5px solid var(--color-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: 16px;
}
.prof-section-head {
    padding: 14px 20px 13px;
    border-bottom: 1px solid var(--color-border-soft);
    display: flex; align-items: center; gap: 10px;
}
.prof-section-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--color-blue-ghost);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: var(--color-blue);
}
.prof-section-title {
    font-size: 0.8125rem; font-weight: 700;
    color: var(--color-navy); letter-spacing: 0.01em;
}
.prof-section-body {
    padding: 18px 20px 20px;
    display: flex; flex-direction: column; gap: 14px;
}
.prof-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media (max-width: 540px) { .prof-grid-2 { grid-template-columns: 1fr; } }

.logo-upload-area {
    display: flex; align-items: center; gap: 16px;
}
.logo-preview {
    width: 72px; height: 72px; flex-shrink: 0;
    border-radius: 14px; overflow: hidden;
    background: var(--color-blue-ghost);
    border: 2px solid var(--color-border);
    display: flex; align-items: center; justify-content: center;
}
.logo-preview img { width: 100%; height: 100%; object-fit: cover; }

.prof-status {
    border-radius: 12px;
    padding: 12px 16px;
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 16px; font-size: 0.8125rem;
}
.prof-status.verified { background: #ECFDF5; border: 1.5px solid #A7F3D0; }
.prof-status.pending  { background: #FFFBEB; border: 1.5px solid #FDE68A; }
.prof-status.rejected { background: #FEF2F2; border: 1.5px solid #FECACA; }
.prof-status-icon {
    width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.prof-status.verified .prof-status-icon { background: #D1FAE5; }
.prof-status.pending  .prof-status-icon { background: #FEF3C7; }
.prof-status.rejected .prof-status-icon { background: #FEE2E2; }
.prof-status-title { font-weight: 600; margin-bottom: 1px; }
.prof-status.verified .prof-status-title { color: #065f46; }
.prof-status.pending  .prof-status-title { color: #92400e; }
.prof-status.rejected .prof-status-title { color: #991b1b; }
.prof-status-desc { font-size: 0.77rem; }
.prof-status.verified .prof-status-desc { color: #059669; }
.prof-status.pending  .prof-status-desc { color: #b45309; }
.prof-status.rejected .prof-status-desc { color: #dc2626; }
</style>
@endpush

@section('content')

<section class="org-page-hero">
    <div class="ak-container">
        <p style="font-size:11px; font-weight:600; color:rgba(255,255,255,0.45); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:4px;">Pengaturan</p>
        <h1 class="org-page-hero-title">Profil Organisasi</h1>
    </div>
</section>

<div class="ak-container" style="padding-top: 1.5rem; padding-bottom: 2.5rem;">
    <div style="max-width: 680px; margin: 0 auto;">
        @if($org?->verification_status === 'verified')
            <div class="prof-status verified">
                <div class="prof-status-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <div>
                    <p class="prof-status-title">Organisasi terverifikasi</p>
                    <p class="prof-status-desc">Kamu dapat membuat dan mempublikasikan event volunteer.</p>
                </div>
            </div>
        @elseif($org?->verification_status === 'pending')
            <div class="prof-status pending">
                <div class="prof-status-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <p class="prof-status-title">Menunggu verifikasi admin</p>
                    <p class="prof-status-desc">Lengkapi semua data di bawah untuk membantu proses verifikasi.</p>
                </div>
            </div>
        @elseif($org?->verification_status === 'rejected')
            <div class="prof-status rejected">
                <div class="prof-status-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </div>
                <div>
                    <p class="prof-status-title">Verifikasi ditolak</p>
                    @if($org->rejection_reason)
                        <p class="prof-status-desc">Alasan: {{ $org->rejection_reason }}</p>
                    @endif
                    <p class="prof-status-desc" style="margin-top:3px;">Perbarui data dan simpan untuk mengajukan ulang.</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="ak-alert ak-alert-danger" style="margin-bottom:16px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="flex-shrink:0; margin-top:1px;">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <p style="font-weight:600; margin-bottom:4px;">Perbaiki kesalahan berikut:</p>
                    <ul style="margin:0; padding-left:14px;">
                        @foreach($errors->all() as $error)
                            <li style="font-size:0.8rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('organizer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="prof-section">
                <div class="prof-section-head">
                    <div class="prof-section-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                        </svg>
                    </div>
                    <span class="prof-section-title">Logo Organisasi</span>
                </div>
                <div class="prof-section-body">
                    <div class="logo-upload-area">
                        <div class="logo-preview" id="logo-wrapper">
                            @if($org?->logo)
                                <img id="logo-preview-img" src="{{ asset('storage/' . $org->logo) }}" alt="Logo">
                            @else
                                <div id="logo-placeholder" style="width:100%; height:100%; background:var(--color-blue-ghost); display:flex; align-items:center; justify-content:center;">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--color-blue-light)" stroke-width="1.5" stroke-linecap="round">
                                        <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="ak-form-group">
                                <label class="ak-label" style="font-size:0.8rem;">Ganti Logo</label>
                                <input type="file" name="logo" accept="image/*"
                                       id="logo-input" onchange="previewLogo(this)"
                                       class="ak-input" style="padding:7px 10px; font-size:0.8rem;
                                              file:mr-2 file:py-1 file:px-3 file:rounded file:border-0
                                              file:text-xs file:font-semibold
                                              file:bg-blue-50 file:text-blue-600">
                                <p class="ak-input-hint">JPG, PNG, WEBP — maks. 2MB. Rasio kotak direkomendasikan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="prof-section">
                <div class="prof-section-head">
                    <div class="prof-section-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <span class="prof-section-title">Data Akun PIC</span>
                </div>
                <div class="prof-section-body">
                    <div class="prof-grid-2">
                        <div class="ak-form-group">
                            <label class="ak-label" style="font-size:0.8125rem;">Nama PIC</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="ak-input {{ $errors->has('name') ? 'error' : '' }}" style="font-size:0.875rem;">
                        </div>
                        <div class="ak-form-group">
                            <label class="ak-label" style="font-size:0.8125rem;">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="ak-input" style="font-size:0.875rem;">
                        </div>
                    </div>
                    <div class="ak-form-group">
                        <label class="ak-label" style="font-size:0.8125rem;">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="ak-input" style="font-size:0.875rem; background:var(--color-bg); color:var(--color-ink-muted); cursor:not-allowed;">
                        <p class="ak-input-hint">Email tidak dapat diubah.</p>
                    </div>
                </div>
            </div>
            <div class="prof-section">
                <div class="prof-section-head">
                    <div class="prof-section-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <span class="prof-section-title">Data Organisasi</span>
                </div>
                <div class="prof-section-body">
                    <div class="ak-form-group">
                        <label class="ak-label" style="font-size:0.8125rem;">Nama Organisasi <span class="required">*</span></label>
                        <input type="text" name="organization_name"
                               value="{{ old('organization_name', $org?->organization_name) }}"
                               class="ak-input {{ $errors->has('organization_name') ? 'error' : '' }}" style="font-size:0.875rem;">
                    </div>
                    <div class="ak-form-group">
                        <label class="ak-label" style="font-size:0.8125rem;">Deskripsi Organisasi</label>
                        <textarea name="description" rows="3"
                                  placeholder="Ceritakan tentang misi, visi, dan program kerja organisasi kamu..."
                                  class="ak-textarea" style="font-size:0.875rem; min-height:80px;">{{ old('description', $org?->description) }}</textarea>
                    </div>
                    <div class="ak-form-group">
                        <label class="ak-label" style="font-size:0.8125rem;">Alamat</label>
                        <input type="text" name="address" value="{{ old('address', $org?->address) }}"
                               placeholder="Jalan, kelurahan, kecamatan..."
                               class="ak-input" style="font-size:0.875rem;">
                    </div>
                    <div class="prof-grid-2">
                        <div class="ak-form-group">
                            <label class="ak-label" style="font-size:0.8125rem;">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $org?->city) }}"
                                   class="ak-input" style="font-size:0.875rem;">
                        </div>
                        <div class="ak-form-group">
                            <label class="ak-label" style="font-size:0.8125rem;">Provinsi</label>
                            <input type="text" name="province" value="{{ old('province', $org?->province) }}"
                                   class="ak-input" style="font-size:0.875rem;">
                        </div>
                    </div>
                    <div class="ak-form-group">
                        <label class="ak-label" style="font-size:0.8125rem;">Website</label>
                        <input type="text" name="website" value="{{ old('website', $org?->website) }}"
                               placeholder="https://namaorganisasi.org"
                               class="ak-input" style="font-size:0.875rem;">
                    </div>
                </div>
            </div>
            <button type="submit" class="ak-btn ak-btn-primary" style="width:100%; justify-content:center; padding:11px 24px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Perubahan
            </button>
        </form>

    </div>
</div>

<script>
function previewLogo(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const wrapper = document.getElementById('logo-wrapper');
        wrapper.innerHTML = `<img src="${e.target.result}" alt="Preview logo" style="width:100%; height:100%; object-fit:cover;">`;
    };
    reader.readAsDataURL(input.files[0]);
}
</script>

@endsection