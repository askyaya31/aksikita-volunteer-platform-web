@extends('layouts.volunteer')
@section('title', $event->title)

@push('styles')
<style>
.detail-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1.5rem 3rem;
}
.detail-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
    align-items: start;
}

.detail-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 500;
    color: #5A6278; text-decoration: none;
    margin-bottom: 1.5rem; padding: 4px 0;
    transition: color 0.15s;
}
.detail-back:hover { color: #0F2057; }

.detail-hero {
    height: 260px;
    border-radius: 18px;
    position: relative; overflow: hidden;
    margin-bottom: 1.5rem;
    display: flex; align-items: flex-end; padding: 1.5rem;
}
.detail-hero img {
    position: absolute; inset: 0;
    width: 100%; height: 100%; object-fit: cover;
}
.detail-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(15,32,87,0.75) 0%, rgba(15,32,87,0.1) 60%);
}
.detail-hero-inner { position: relative; z-index: 1; width: 100%; }
.detail-cats { display: flex; gap: 6px; margin-bottom: 10px; }
.detail-cat {
    font-size: 10.5px; font-weight: 700;
    padding: 3px 10px; border-radius: 999px;
    background: rgba(255,255,255,0.2); color: #fff;
    backdrop-filter: blur(4px);
    text-transform: uppercase; letter-spacing: 0.5px;
}
.detail-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 22px; font-weight: 700;
    color: #fff; line-height: 1.25;
}
.detail-org-row {
    display: flex; align-items: center; gap: 8px;
    margin-top: 10px;
}
.detail-org-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.detail-org-name { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.85); }

.detail-content-card {
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(15,32,87,0.06);
    margin-bottom: 1rem;
}
.detail-section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px; font-weight: 700; color: #0F2057;
    margin-bottom: 12px;
}
.detail-body-text {
    font-size: 14px; color: #5A6278; line-height: 1.75;
}

.info-list { list-style: none; }
.info-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid #EEF0F6;
    font-size: 13px;
}
.info-item:last-child { border-bottom: none; padding-bottom: 0; }
.info-icon {
    width: 32px; height: 32px; flex-shrink: 0;
    background: #EEF3FF; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #0F2057;
}
.info-label {
    font-size: 10.5px; color: #9099B0; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.4px;
    margin-bottom: 2px;
}
.info-val { font-weight: 600; color: #0F2057; font-size: 13px; }
.info-sub { font-size: 12px; color: #5A6278; font-weight: 400; }

.requirements-box {
    background: #FDF5E1;
    border: 1px solid #F5D98A;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 13.5px; color: #7A5700; line-height: 1.65;
    display: flex; gap: 10px;
}
.requirements-box svg { flex-shrink: 0; margin-top: 2px; }

.contact-box {
    display: flex; align-items: center; gap: 10px;
    font-size: 13.5px; color: #5A6278;
    background: #F8F9FC;
    border: 1px solid #EEF0F6;
    border-radius: 12px; padding: 12px 14px;
}
.contact-box strong { color: #0F2057; }
.contact-box a { color: #E8501A; font-weight: 600; text-decoration: none; }
.contact-box a:hover { text-decoration: underline; }

.sidebar-card {
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(15,32,87,0.06);
    position: sticky; top: 84px;
}
.sidebar-card-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px; font-weight: 700; color: #0F2057;
    margin-bottom: 1rem;
}

.quota-bar {
    height: 6px; background: #EEF0F6;
    border-radius: 999px; margin: 8px 0 5px; overflow: hidden;
}
.quota-fill { height: 100%; background: #0E7B6C; border-radius: 999px; }
.quota-text {
    font-size: 11.5px; color: #5A6278;
    display: flex; justify-content: space-between;
}

.reg-btn {
    width: 100%; padding: 13px;
    background: #E8501A; color: #fff;
    border-radius: 12px; font-size: 14.5px; font-weight: 700;
    border: none; cursor: pointer;
    transition: background 0.15s, transform 0.15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.reg-btn:hover { background: #F5773D; transform: translateY(-1px); }
.reg-btn:disabled {
    background: #D8DCE8; color: #9099B0; cursor: not-allowed; transform: none;
}

.reg-status {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 13.5px; line-height: 1.55;
    margin-bottom: 14px;
}
.reg-status svg { flex-shrink: 0; margin-top: 1px; }
.reg-status.confirmed { background: #E3F5F2; border: 1px solid #A0D9D0; color: #065F46; }
.reg-status.pending   { background: #FDF5E1; border: 1px solid #F5D98A; color: #7A5700; }
.reg-status.rejected  { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
.reg-status.cancelled { background: #F8F9FC; border: 1px solid #EEF0F6; color: #5A6278; }

.detail-textarea {
    width: 100%; border: 1.5px solid #D8DCE8;
    border-radius: 10px; padding: 10px 12px;
    font-family: inherit; font-size: 13.5px; color: #1A1F2E;
    resize: vertical; min-height: 76px;
    outline: none; transition: border-color 0.15s;
    margin-bottom: 10px;
}
.detail-textarea:focus { border-color: #1A3575; }
.detail-textarea::placeholder { color: #9099B0; }
.detail-label {
    display: block; font-size: 12px; font-weight: 600;
    color: #5A6278; margin-bottom: 6px;
}

.cancel-btn {
    width: 100%; padding: 11px;
    background: #FEF2F2; color: #991B1B;
    border: 1.5px solid #FECACA;
    border-radius: 12px; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: background 0.15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.cancel-btn:hover { background: #FEE2E2; }

.detail-alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 14px 16px; border-radius: 12px;
    font-size: 13.5px; margin-bottom: 1.5rem;
}
.detail-alert.success { background: #E3F5F2; border: 1px solid #A0D9D0; color: #065F46; }

@media (max-width: 860px) {
    .detail-layout { grid-template-columns: 1fr; }
    .sidebar-card { position: static; }
    .detail-hero { height: 200px; }
    .detail-title { font-size: 18px; }
}
</style>
@endpush

@section('content')
<div class="detail-wrap">

    @if(session('success'))
        <div class="detail-alert success" role="alert">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
                <p style="margin:4px 0 0; font-size:12.5px; opacity:0.8;">Menunggu konfirmasi dari organisasi.</p>
            </div>
        </div>
    @endif

    <a href="{{ route('volunteer.events') }}" class="detail-back">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke daftar kegiatan
    </a>

    @php
        $catColors = [
            'lingkungan' => ['bg' => '#0E7B6C', 'bg2' => '#1DB8A0'],
            'pendidikan'  => ['bg' => '#1A3575', 'bg2' => '#2A4A9C'],
            'kesehatan'   => ['bg' => '#B02060', 'bg2' => '#E4409A'],
            'sosial'      => ['bg' => '#D4900A', 'bg2' => '#EFB530'],
        ];
        $fc  = $event->categories->first();
        $pal = $catColors[$fc?->slug ?? ''] ?? ['bg' => '#0F2057', 'bg2' => '#1A3575'];
        $orgInitial = strtoupper(substr($event->organization->organization_name, 0, 1));
        $filled = $event->quota > 0 ? round(($event->quota - $event->remainingQuota()) / $event->quota * 100) : 0;
    @endphp

    <div class="detail-hero"
         style="{{ $event->poster ? '' : 'background: linear-gradient(135deg, '.$pal['bg'].' 0%, '.$pal['bg2'].' 100%);' }}">
        @if($event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
            <div class="detail-hero-overlay"></div>
        @endif
        <div class="detail-hero-inner">
            <div class="detail-cats">
                @foreach($event->categories as $cat)
                    <span class="detail-cat">{{ $cat->name }}</span>
                @endforeach
            </div>
            <h1 class="detail-title">{{ $event->title }}</h1>
            <div class="detail-org-row">
                <div class="detail-org-avatar">{{ $orgInitial }}</div>
                <span class="detail-org-name">{{ $event->organization->organization_name }}</span>
            </div>
        </div>
    </div>

    <div class="detail-layout">

        <div>
            <div class="detail-content-card">
                <ul class="info-list">
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Tanggal</p>
                            <p class="info-val">{{ $event->start_date->format('d M Y') }}
                                @if($event->start_date->format('Y-m-d') !== $event->end_date->format('Y-m-d'))
                                    <span class="info-sub"> — {{ $event->end_date->format('d M Y') }}</span>
                                @endif
                            </p>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Waktu</p>
                            <p class="info-val">
                                @if($event->start_time)
                                    {{ $event->start_time }}@if($event->end_time) &mdash; {{ $event->end_time }}@endif
                                @else
                                    &mdash;
                                @endif
                            </p>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Lokasi</p>
                            <p class="info-val">{{ $event->location_name }}</p>
                            <p class="info-sub">{{ $event->city }}, {{ $event->province }}</p>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Kuota Peserta</p>
                            <p class="info-val" style="{{ $event->isFull() ? 'color:#EF4444' : 'color:#0E7B6C' }}">
                                @if($event->isFull()) Penuh ({{ $event->quota }}/{{ $event->quota }})
                                @else {{ $event->remainingQuota() }} kuota tersisa
                                @endif
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="detail-content-card">
                <h2 class="detail-section-title">Tentang Kegiatan</h2>
                <div class="detail-body-text">{!! nl2br(e($event->description)) !!}</div>
            </div>

            @if($event->requirements)
                <div class="detail-content-card">
                    <h2 class="detail-section-title">Syarat Peserta</h2>
                    <div class="requirements-box">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#D4900A" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <div>{!! nl2br(e($event->requirements)) !!}</div>
                    </div>
                </div>
            @endif

            @if($event->contact_person)
                <div class="detail-content-card">
                    <h2 class="detail-section-title">Narahubung</h2>
                    <div class="contact-box">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#5A6278" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>
                            <strong>{{ $event->contact_person }}</strong>
                            @if($event->contact_phone)
                                &mdash; <a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                            @endif
                        </span>
                    </div>
                </div>
            @endif

        </div>

        <div>
            <div class="sidebar-card">
                @if($event->quota > 0)
                    <div style="margin-bottom: 1rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                            <span style="font-size:12.5px; font-weight:600; color:#5A6278;">Kapasitas terisi</span>
                            <span style="font-size:12.5px; font-weight:700; color:#0F2057;">{{ $filled }}%</span>
                        </div>
                        <div class="quota-bar">
                            <div class="quota-fill" style="width: {{ $filled }}%;"></div>
                        </div>
                        <div class="quota-text">
                            <span>{{ $event->quota - $event->remainingQuota() }} terdaftar</span>
                            <span>{{ $event->quota }} kuota</span>
                        </div>
                    </div>
                @endif

                @if($registrasi && $registrasi->status === 'confirmed')

                    <div class="reg-status confirmed">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <strong>Pendaftaran dikonfirmasi</strong>
                            <p style="margin:3px 0 0; font-size:12px; opacity:0.8;">Terdaftar sejak {{ $registrasi->registered_at->format('d M Y') }}. Hadir tepat waktu sesuai jadwal.</p>
                        </div>
                    </div>
                    <form action="{{ route('volunteer.cancel', $event->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan pendaftaran?')">
                        @csrf
                        <button type="submit" class="cancel-btn">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batalkan Pendaftaran
                        </button>
                    </form>

                @elseif($registrasi && $registrasi->status === 'pending')

                    <div class="reg-status pending">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <strong>Menunggu konfirmasi</strong>
                            <p style="margin:3px 0 0; font-size:12px; opacity:0.8;">Pendaftaranmu sudah diterima. Organisasi akan segera meninjau.</p>
                        </div>
                    </div>

                @elseif($registrasi && $registrasi->status === 'rejected')

                    <div class="reg-status rejected">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <strong>Pendaftaran tidak diterima</strong>
                            <p style="margin:3px 0 0; font-size:12px; opacity:0.8;">Coba kegiatan lain yang sesuai denganmu.</p>
                        </div>
                    </div>

                @elseif($registrasi && $registrasi->status === 'cancelled')

                    <div class="reg-status cancelled">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        <span>Kamu pernah membatalkan pendaftaran di kegiatan ini.</span>
                    </div>

                @elseif($event->isFull())

                    <button class="reg-btn" disabled>Kuota Penuh</button>

                @else

                    <p class="sidebar-card-title">Daftar ke kegiatan ini</p>
                    <form action="{{ route('volunteer.register', $event->id) }}" method="POST" id="regForm">
                        @csrf
                        <label class="detail-label" for="reg-notes">
                            Catatan untuk organisasi
                            <span style="font-weight:400; color:#9099B0;">(opsional)</span>
                        </label>
                        <textarea id="reg-notes" name="notes"
                                  class="detail-textarea"
                                  placeholder="Ceritakan mengapa kamu tertarik atau pengalaman yang relevan…"></textarea>
                        <button type="submit" class="reg-btn" id="regSubmit">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span id="regBtnText">Daftar Kegiatan Ini</span>
                        </button>
                    </form>

                @endif

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var form    = document.getElementById('regForm');
    var btn     = document.getElementById('regSubmit');
    var btnText = document.getElementById('regBtnText');
    if (!form || !btn) return;
    form.addEventListener('submit', function () {
        btn.disabled = true;
        if (btnText) btnText.textContent = 'Mendaftarkan…';
    });
})();
</script>
@endpush