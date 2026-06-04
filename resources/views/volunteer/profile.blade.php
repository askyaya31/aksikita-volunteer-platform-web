@extends('layouts.volunteer')
@section('title', 'Profil Saya — AksiKita')

@push('styles')
<style>
.profile-wrap {
    max-width: 680px;
    margin: 0 auto;
    padding: 32px 16px 48px;
}
.profile-page-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -0.025em;
    color: #0F172A;
    line-height: 1.2;
    margin-bottom: 4px;
}
.profile-page-sub {
    font-size: 0.875rem;
    color: #64748B;
    margin-bottom: 24px;
}
.profile-errors {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
}
.profile-errors__item {
    font-size: 0.8375rem;
    color: #991B1B;
    display: flex;
    align-items: center;
    gap: 6px;
    line-height: 1.5;
}
.profile-errors__item + .profile-errors__item { margin-top: 4px; }

.profile-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(15,23,42,0.06);
    margin-bottom: 16px;
}

.profile-avatar-section {
    padding: 24px 28px;
    border-bottom: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    gap: 20px;
    background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);
}
.profile-avatar-ring {
    width: 80px; height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
}
.profile-avatar-ring img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.profile-avatar-ring__placeholder {
    width: 100%; height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}
.profile-avatar-info { flex: 1; min-width: 0; }
.profile-avatar-info__name {
    font-size: 1.125rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.01em;
    margin-bottom: 3px;
}
.profile-avatar-info__email {
    font-size: 0.8375rem;
    color: rgba(191,219,254,0.85);
    margin-bottom: 10px;
}
.profile-avatar-upload {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.25);
    padding: 6px 14px;
    border-radius: 9999px;
    cursor: pointer;
    transition: background 0.15s;
    line-height: 1;
    position: relative;
}
.profile-avatar-upload:hover { background: rgba(255,255,255,0.25); }
.profile-avatar-upload input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 0; height: 0;
    pointer-events: none;
}

.profile-section {
    padding: 24px 28px;
    border-bottom: 1px solid #E2E8F0;
}
.profile-section:last-child { border-bottom: none; }
.profile-section__label {
    font-size: 0.6875rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #94A3B8;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.profile-section__label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #E2E8F0;
}

.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
@media (max-width: 520px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
.form-grid-1 { margin-top: 14px; }

.profile-field label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}
.profile-field input,
.profile-field select,
.profile-field textarea {
    width: 100%;
    padding: 11px 14px;
    font-size: 0.9rem;
    color: #0F172A;
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    transition: border-color 0.15s, box-shadow 0.15s;
    outline: none;
    -webkit-appearance: none;
    font-family: inherit;
}
.profile-field input:hover,
.profile-field select:hover,
.profile-field textarea:hover { border-color: #BFDBFE; }
.profile-field input:focus,
.profile-field select:focus,
.profile-field textarea:focus {
    border-color: #3B82F6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
.profile-field input:disabled {
    background: #F8FAFC;
    color: #94A3B8;
    cursor: not-allowed;
    border-color: #E2E8F0;
}
.profile-field textarea { resize: vertical; min-height: 88px; }
.profile-field select { cursor: pointer; }
.profile-field__hint {
    font-size: 0.775rem;
    color: #94A3B8;
    margin-top: 4px;
}

.profile-tags-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 8px;
    min-height: 28px;
}
.profile-tag {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 0.775rem;
    font-weight: 600;
    background: #EFF6FF;
    color: #1D4ED8;
    border: 1px solid #BFDBFE;
}

.profile-save-bar {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 4px;
}
.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #3B82F6;
    color: #fff;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: background 0.15s, transform 0.15s;
}
.btn-save:hover { background: #2563EB; transform: translateY(-1px); }
.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: transparent;
    color: #64748B;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 10px 20px;
    border-radius: 10px;
    border: 1.5px solid #E2E8F0;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s;
}
.btn-cancel:hover { background: #F8FAFC; }
</style>
@endpush

@section('content')
<div class="profile-wrap">

    <h1 class="profile-page-title">Profil Saya</h1>
    <p class="profile-page-sub">Lengkapi profilmu agar organisasi lebih mudah mengenalimu.</p>

    @if(session('success'))
        <div style="background:#F0FDF4; border:1px solid #BBF7D0; color:#166534;
                    padding:12px 16px; border-radius:12px; margin-bottom:20px; font-size:0.9rem;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="profile-errors">
            @foreach($errors->all() as $e)
                <p class="profile-errors__item">• {{ $e }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('volunteer.profile.update') }}"
          enctype="multipart/form-data" id="profileForm">
        @csrf

        <div class="profile-card">

        <div class="profile-avatar-section">
            <div class="profile-avatar-ring">
                @php
                    
                    $avatarSrc = null;

                    if ($user->volunteerProfile?->avatar) {
                        $avatarSrc = asset('storage/' . $user->volunteerProfile->avatar);
                    } elseif ($user->avatar) {
                        $avatarSrc = Str::startsWith($user->avatar, 'http')
                            ? $user->avatar
                            : asset('storage/' . $user->avatar);
                    }
                @endphp

                @if($avatarSrc)
                    <img src="{{ $avatarSrc }}"
                        alt="{{ $user->name }}"
                        id="avatarPreview"
                        style="display:block;">
                    <div class="profile-avatar-ring__placeholder"
                        id="avatarPlaceholder"
                        style="display:none;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @else
                    <img src="" alt="" id="avatarPreview" style="display:none;">
                    <div class="profile-avatar-ring__placeholder" id="avatarPlaceholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="profile-avatar-info">
                <p class="profile-avatar-info__name">{{ $user->name }}</p>
                <p class="profile-avatar-info__email">{{ $user->email }}</p>
                <label class="profile-avatar-upload">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Ganti Foto
                    <input type="file" name="avatar"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                        id="avatarInput">
                </label>
                <p style="font-size:.75rem; color:rgba(191,219,254,.7); margin-top:6px;">
                    JPG, PNG, WEBP. Maks 2 MB.
                </p>
            </div>
        </div>
            <div class="profile-section">
                <p class="profile-section__label">Data Akun</p>
                <div class="form-grid-2">
                    <div class="profile-field">
                        <label for="pf-name">Nama Lengkap</label>
                        <input type="text" id="pf-name" name="name"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Nama lengkap kamu" required>
                    </div>
                    <div class="profile-field">
                        <label for="pf-phone">Nomor Telepon</label>
                        <input type="text" id="pf-phone" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="form-grid-1 profile-field">
                    <label for="pf-email">Email</label>
                    <input type="email" id="pf-email"
                           value="{{ $user->email }}" disabled>
                    <p class="profile-field__hint">Email tidak dapat diubah.</p>
                </div>
            </div>
            <div class="profile-section">
                <p class="profile-section__label">Data Pribadi</p>
                <div class="form-grid-2">
                    <div class="profile-field">
                        <label for="pf-dob">Tanggal Lahir</label>
                        <input type="date" id="pf-dob" name="date_of_birth"
                               value="{{ old('date_of_birth', $user->volunteerProfile?->date_of_birth?->format('Y-m-d')) }}">
                    </div>
                    <div class="profile-field">
                        <label for="pf-gender">Jenis Kelamin</label>
                        <select id="pf-gender" name="gender">
                            <option value="">-- Pilih --</option>
                            <option value="male"   {{ old('gender', $user->volunteerProfile?->gender) === 'male'   ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->volunteerProfile?->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                            <option value="other"  {{ old('gender', $user->volunteerProfile?->gender) === 'other'  ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-grid-2" style="margin-top:14px;">
                    <div class="profile-field">
                        <label for="pf-city">Kota</label>
                        <input type="text" id="pf-city" name="city"
                               value="{{ old('city', $user->volunteerProfile?->city) }}"
                               placeholder="Yogyakarta">
                    </div>
                    <div class="profile-field">
                        <label for="pf-province">Provinsi</label>
                        <input type="text" id="pf-province" name="province"
                               value="{{ old('province', $user->volunteerProfile?->province) }}"
                               placeholder="DI Yogyakarta">
                    </div>
                </div>
                <div class="form-grid-1 profile-field" style="margin-top:14px;">
                    <label for="pf-bio">Bio</label>
                    <textarea id="pf-bio" name="bio"
                              placeholder="Ceritakan sedikit tentang dirimu, motivasimu menjadi volunteer…">{{ old('bio', $user->volunteerProfile?->bio) }}</textarea>
                    <p class="profile-field__hint">Maks 500 karakter.</p>
                </div>
            </div>
            <div class="profile-section">
                <p class="profile-section__label">Keahlian &amp; Minat</p>
                <div class="profile-field">
                    <label for="pf-skills">Keahlian</label>
                    <input type="text" id="pf-skills" name="skills"
                           value="{{ old('skills', is_array($user->volunteerProfile?->skills) ? implode(', ', $user->volunteerProfile->skills) : '') }}"
                           placeholder="Komunikasi, Desain, Coding, Fotografi…">
                    <p class="profile-field__hint">Pisahkan dengan koma.</p>
                    <div class="profile-tags-preview" id="skillsPreview">
                        @if(is_array($user->volunteerProfile?->skills))
                            @foreach($user->volunteerProfile->skills as $skill)
                                @if(trim($skill))
                                    <span class="profile-tag">{{ trim($skill) }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="profile-field" style="margin-top:14px;">
                    <label for="pf-interests">Minat</label>
                    <input type="text" id="pf-interests" name="interests"
                           value="{{ old('interests', is_array($user->volunteerProfile?->interests) ? implode(', ', $user->volunteerProfile->interests) : '') }}"
                           placeholder="Lingkungan, Pendidikan, Kesehatan, Sosial…">
                    <p class="profile-field__hint">Pisahkan dengan koma.</p>
                    <div class="profile-tags-preview" id="interestsPreview">
                        @if(is_array($user->volunteerProfile?->interests))
                            @foreach($user->volunteerProfile->interests as $interest)
                                @if(trim($interest))
                                    <span class="profile-tag">{{ trim($interest) }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="profile-save-bar">
            <a href="{{ route('volunteer.dashboard') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save" id="saveBtn">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span id="saveBtnText">Simpan Perubahan</span>
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var avatarInput   = document.getElementById('avatarInput');
    var avatarPreview = document.getElementById('avatarPreview');
    var avatarPH      = document.getElementById('avatarPlaceholder');

    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                avatarPreview.src = e.target.result;
                avatarPreview.style.display = 'block';
                if (avatarPH) avatarPH.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }

    function renderTags(inputId, previewId) {
        var input   = document.getElementById(inputId);
        var preview = document.getElementById(previewId);
        if (!input || !preview) return;
        input.addEventListener('input', function () {
            var tags = this.value.split(',').map(function(t){ return t.trim(); }).filter(Boolean);
            preview.innerHTML = tags.map(function(t){
                return '<span class="profile-tag">' + t + '</span>';
            }).join('');
        });
    }

    renderTags('pf-skills',    'skillsPreview');
    renderTags('pf-interests', 'interestsPreview');

    var form    = document.getElementById('profileForm');
    var saveBtn = document.getElementById('saveBtn');
    var saveTxt = document.getElementById('saveBtnText');
    if (form && saveBtn) {
        form.addEventListener('submit', function () {
            saveBtn.disabled = true;
            if (saveTxt) saveTxt.textContent = 'Menyimpan…';
        });
    }
})();
</script>
@endpush