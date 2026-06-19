@extends('layouts.organizer')
@section('title', 'Profil Organisasi')

@push('styles')
<style>
.prof-container {
    max-width: 680px;
    margin: 0 auto;
    padding: 2rem 1rem 4rem;
}

.prof-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.prof-page-title {
    font-size: 22px;
    font-weight: 700;
    color: #1A3575;
    margin: 0;
}
.btn-top-upload {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    border: 1px solid #D1D5DB;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: #4B5563;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    transition: all 0.2s;
}
.btn-top-upload:hover {
    background: #F9FAFB;
    border-color: #9CA3AF;
}

.prof-hero-card {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    border-radius: 24px;
    padding: 32px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 24px;
    margin-bottom: 32px;
    box-shadow: 0 10px 25px -5px rgba(26, 53, 117, 0.2);
}
.hero-avatar-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    flex-shrink: 0;
}
.hero-avatar-preview {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: #fff;
    border: 3px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.hero-avatar-placeholder {
    width: 100%;
    height: 100%;
    background: #E5E7EB;
    background-image: radial-gradient(#D1D5DB 20%, transparent 20%), radial-gradient(#D1D5DB 20%, transparent 20%);
    background-size: 8px 8px;
    background-position: 0 0, 4px 4px;
    border-radius: 50%;
}
.hero-info-wrapper {
    flex-grow: 1;
}
.hero-org-name {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 4px 0;
    color: #ffffff;
}
.hero-org-email {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.75);
    margin: 0 0 12px 0;
}
.btn-inner-upload {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: #ffffff;
    cursor: pointer;
    backdrop-filter: blur(4px);
    transition: background 0.2s;
}
.btn-inner-upload:hover {
    background: rgba(255, 255, 255, 0.25);
}
.hero-upload-hint {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.5);
    margin: 6px 0 0 0;
}

.form-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #D1D5DB;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: #4B5563;
    background: #fff;
    margin-bottom: 12px;
}
.form-card-box {
    border: 1px solid #D1D5DB;
    border-radius: 16px;
    padding: 24px;
    background: #fff;
    margin-bottom: 28px;
}
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 540px) { 
    .form-grid-2 { grid-template-columns: 1fr; } 
}

.custom-form-group {
    margin-bottom: 16px;
}
.custom-form-group:last-child {
    margin-bottom: 0;
}
.custom-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: #1F2937;
    margin-bottom: 6px;
}
.custom-label .required {
    color: #EF4444;
}
.custom-input, .custom-textarea {
    width: 100%;
    border: 1px solid #C4CBD6;
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 13px;
    color: #1F2937;
    background-color: #fff;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.custom-input:focus, .custom-textarea:focus {
    border-color: #1A3575;
    box-shadow: 0 0 0 3px rgba(26, 53, 117, 0.1);
}
.custom-input.disabled {
    background-color: #F3F4F6;
    color: #9CA3AF;
    cursor: not-allowed;
    border-color: #E5E7EB;
}
.custom-input-hint {
    font-size: 11px;
    color: #6B7280;
    margin-top: 4px;
    margin-bottom: 0;
}

.btn-submit-save {
    width: 100%;
    background: #2557BF;
    color: white;
    border: none;
    border-radius: 14px;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: background 0.2s;
    box-shadow: 0 4px 6px -1px rgba(37, 87, 191, 0.1);
}
.btn-submit-save:hover {
    background: #1A44A0;
}

.prof-status {
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    font-size: 0.8125rem;
}
.prof-status.verified { background: #ECFDF5; border: 1.5px solid #A7F3D0; }
.prof-status.pending  { background: #FFFBEB; border: 1.5px solid #FDE68A; }
.prof-status.rejected { background: #FEF2F2; border: 1.5px solid #FECACA; }
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

<div class="prof-container">
    @if($org?->verification_status === 'verified')
        <div class="prof-status verified">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
                <p class="prof-status-title">Organisasi terverifikasi</p>
                <p class="prof-status-desc">Kamu dapat membuat dan mempublikasikan event volunteer.</p>
            </div>
        </div>
    @elseif($org?->verification_status === 'pending')
        <div class="prof-status pending">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <div>
                <p class="prof-status-title">Menunggu verifikasi admin</p>
                <p class="prof-status-desc">Lengkapi semua data di bawah untuk membantu proses verifikasi.</p>
            </div>
        </div>
    @elseif($org?->verification_status === 'rejected')
        <div class="prof-status rejected">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            <div>
                <p class="prof-status-title">Verifikasi ditolak</p>
                @if($org->rejection_reason) <p class="prof-status-desc">Alasan: {{ $org->rejection_reason }}</p> @endif
                <p class="prof-status-desc" style="margin-top:3px;">Perbarui data dan simpan untuk mengajukan ulang.</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="ak-alert ak-alert-danger" style="margin-bottom:20px; border-radius:12px; padding:12px 16px; background:#FEF2F2; border:1px solid #FECACA; display:flex; gap:10px; color:#991B1B;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div style="font-size:13px;">
                <p style="font-weight:600; margin:0 0 4px 0;">Perbaiki kesalahan berikut:</p>
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('organizer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <input type="file" name="logo" accept="image/*" id="logo-real-input" onchange="previewLogo(this)" style="display: none;">

        <div class="prof-hero-card">
            <div class="hero-avatar-wrapper">
                <div class="hero-avatar-preview" id="logo-preview-box">
                    @if($org?->logo)
                        <img id="logo-img-element" src="{{ asset('storage/' . $org->logo) }}" alt="Logo">
                    @else
                        <div class="hero-avatar-placeholder"></div>
                    @endif
                </div>
            </div>
            <div class="hero-info-wrapper">
                <h2 class="hero-org-name">{{ old('organization_name', $org?->organization_name ?? '[Nama Organisasi]') }}</h2>
                <p class="hero-org-email">{{ $user->email }}</p>
                <button type="button" class="btn-inner-upload" onclick="triggerLogoUpload()">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                    </svg>
                    Ganti Logo
                </button>
                <p class="hero-upload-hint">JPG, PNG, WEBP Maks 2 MB.</p>
            </div>
        </div>

        <div class="form-section-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Data Akun PIC
        </div>
        <div class="form-card-box">
            <div class="form-grid-2">
                <div class="custom-form-group">
                    <label class="custom-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="custom-input">
                </div>
                <div class="custom-form-group">
                    <label class="custom-label">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="custom-input">
                </div>
            </div>
            <div class="custom-form-group" style="margin-top: 16px;">
                <label class="custom-label">E-mail</label>
                <input type="email" value="{{ $user->email }}" class="custom-input disabled" disabled>
                <p class="custom-input-hint">E-mail tidak dapat diubah.</p>
            </div>
        </div>

        <div class="form-section-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Data Organisasi
        </div>
        <div class="form-card-box">
            <div class="custom-form-group">
                <label class="custom-label">Nama Organisasi <span class="required">*</span></label>
                <input type="text" name="organization_name" value="{{ old('organization_name', $org?->organization_name) }}" class="custom-input" id="input-org-name">
            </div>
            <div class="custom-form-group">
                <label class="custom-label">Deskripsi</label>
                <textarea name="description" rows="4" placeholder="Ceritakan tentang misi, visi, dan program kerja organisasi kamu..." class="custom-textarea">{{ old('description', $org?->description) }}</textarea>
            </div>
            <div class="custom-form-group">
                <label class="custom-label">Alamat</label>
                <input type="text" name="address" value="{{ old('address', $org?->address) }}" placeholder="Jalan, kelurahan, kecamatan..." class="custom-input">
            </div>
            <div class="form-grid-2" style="margin-top: 16px;">
                <div class="custom-form-group">
                    <label class="custom-label">Kota</label>
                    <input type="text" name="city" value="{{ old('city', $org?->city) }}" class="custom-input">
                </div>
                <div class="custom-form-group">
                    <label class="custom-label">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $org?->province) }}" class="custom-input">
                </div>
            </div>
            <div class="custom-form-group" style="margin-top: 16px;">
                <label class="custom-label">Website</label>
                <input type="text" name="website" value="{{ old('website', $org?->website) }}" placeholder="https://namaorganisasi.org" class="custom-input">
            </div>
        </div>

        <button type="submit" class="btn-submit-save">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
            </svg>
            Simpan Perubahan
        </button>
    </form>
</div>

<script>
function triggerLogoUpload() {
    document.getElementById('logo-real-input').click();
}

function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewBox = document.getElementById('logo-preview-box');
            previewBox.innerHTML = `<img id="logo-img-element" src="${e.target.result}" alt="Preview logo">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

const inputOrgName = document.getElementById('input-org-name');
if(inputOrgName) {
    inputOrgName.addEventListener('input', function(e) {
        const titleCard = document.querySelector('.hero-org-name');
        if(titleCard) {
            titleCard.textContent = e.target.value.trim() !== "" ? e.target.value : "[Nama Organisasi]";
        }
    });
}
</script>

@endsection