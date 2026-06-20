@extends('layouts.organizer')

@section('title', 'Detail Kandidat - ' . ($candidate->user?->name ?? 'Kandidat'))

@section('content')
<div class="ak-container" style="padding-top: 32px; padding-bottom: 48px; max-width: 960px;">

    <div class="ak-flex-between" style="margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 1.25rem; font-weight: 700; color: var(--color-ink); margin: 0 0 2px;">
                Detail Kandidat
            </h1>
            <p style="font-size: 0.875rem; color: var(--color-ink-muted); margin: 0;">
                {{ $candidate->event->title }}
            </p>
        </div>
        <a href="{{ route('organizer.candidates.index', ['event' => $candidate->event_id]) }}"
           class="ak-btn ak-btn-ghost ak-btn-sm">
            ← Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <div class="ak-alert ak-alert-success" style="margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ak-alert ak-alert-danger" style="margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @php
        $user    = $candidate->user;
        $profile = $user?->volunteerProfile;

        $statusMap = [
            'confirmed' => ['label' => 'Diterima', 'class' => 'ak-badge-success'],
            'cancelled' => ['label' => 'Ditolak',  'class' => 'ak-badge-danger'],
            'attended'  => ['label' => 'Hadir',    'class' => 'ak-badge-blue'],
            'pending'   => ['label' => 'Pending',  'class' => 'ak-badge-warning'],
        ];
        $s = $statusMap[$candidate->status] ?? $statusMap['pending'];
    @endphp

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: start;">
        <div class="ak-card" style="text-align: center;">
            <div style="
                width: 88px; height: 88px; border-radius: var(--radius-lg);
                background: var(--color-blue-ghost); margin: 0 auto 16px;
                display: flex; align-items: center; justify-content: center;
                font-family: var(--font-display); font-size: 2rem; font-weight: 700;
                color: var(--color-blue); overflow: hidden; flex-shrink: 0;
            ">
                @if($profile?->avatar)
                    <img src="{{ Storage::url($profile->avatar) }}"
                         alt="{{ $user->name }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                @endif
            </div>

            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-ink); margin: 0 0 4px;">
                {{ $user?->name ?? '-' }}
            </h2>
            <p style="font-size: 0.85rem; color: var(--color-ink-muted); margin: 0 0 20px;">
                {{ $user?->email ?? '-' }}
            </p>

            <span class="ak-badge {{ $s['class'] }}" style="font-size: 0.8rem; padding: 5px 16px;">
                {{ $s['label'] }}
            </span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">

            <div class="ak-card">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--color-navy); margin: 0 0 12px;">
                    Catatan Pendaftaran
                </h3>
                <p style="color: var(--color-ink-soft); line-height: 1.7; margin: 0;">
                    {{ $candidate->notes ?? 'Tidak ada catatan yang diisi.' }}
                </p>
            </div>

            <div class="ak-card">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--color-navy); margin: 0 0 16px;">
                    Informasi Pribadi
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">

                    <div>
                        <span style="display: block; font-size: 0.78rem; color: var(--color-ink-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px;">
                            No. Telepon
                        </span>
                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--color-ink);">
                            {{ $user?->phone ?? '-' }}
                        </span>
                    </div>

                    <div>
                        <span style="display: block; font-size: 0.78rem; color: var(--color-ink-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px;">
                            Domisili
                        </span>
                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--color-ink);">
                            {{ $profile?->city ? $profile->city . ', ' . $profile->province : '-' }}
                        </span>
                    </div>

                    @if($profile?->date_of_birth)
                    <div>
                        <span style="display: block; font-size: 0.78rem; color: var(--color-ink-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px;">
                            Tanggal Lahir
                        </span>
                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--color-ink);">
                            {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') }}
                        </span>
                    </div>
                    @endif

                    @if($profile?->gender)
                    @php $gMap = ['male' => 'Laki-laki', 'female' => 'Perempuan', 'other' => 'Lainnya']; @endphp
                    <div>
                        <span style="display: block; font-size: 0.78rem; color: var(--color-ink-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px;">
                            Jenis Kelamin
                        </span>
                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--color-ink);">
                            {{ $gMap[$profile->gender] ?? $profile->gender }}
                        </span>
                    </div>
                    @endif
                </div>

                @if($profile?->bio)
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--color-border);">
                        <span style="display: block; font-size: 0.78rem; color: var(--color-ink-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px;">
                            Bio
                        </span>
                        <p style="font-size: 0.875rem; color: var(--color-ink-soft); line-height: 1.7; margin: 0;">
                            {{ $profile->bio }}
                        </p>
                    </div>
                @endif
            </div>

            @if($candidate->status === 'cancelled' && $candidate->cancellation_reason)
                <div class="ak-alert ak-alert-danger">
                    <div>
                        <strong style="display: block; margin-bottom: 4px;">Alasan Penolakan</strong>
                        {{ $candidate->cancellation_reason }}
                    </div>
                </div>
            @endif

            <div class="ak-card">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--color-navy); margin: 0 0 16px;">
                    Aksi
                </h3>

                @if($candidate->status === 'pending')
                    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 12px;">
                        <form method="POST" action="{{ route('organizer.confirm', $candidate->id) }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Terima kandidat ini?')"
                                    class="ak-btn ak-btn-success">
                                Terima Kandidat
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('rejectPanel').classList.toggle('hidden-panel')"
                                class="ak-btn ak-btn-danger" style="background: transparent; color: var(--color-danger); border-color: var(--color-danger);">
                            Tolak Kandidat
                        </button>
                    </div>

                    <div id="rejectPanel" class="hidden-panel"
                         style="padding-top: 16px; border-top: 1px solid var(--color-border);">
                        <form method="POST" action="{{ route('organizer.reject', $candidate->id) }}">
                            @csrf
                            <div class="ak-form-group" style="margin-bottom: 12px;">
                                <label class="ak-label" for="reason">Alasan penolakan</label>
                                <textarea name="reason" id="reason" rows="3"
                                          class="ak-textarea"
                                          placeholder="Berikan alasan penolakan yang jelas..."></textarea>
                            </div>
                            <button type="submit" onclick="return confirm('Tolak kandidat ini?')"
                                    class="ak-btn ak-btn-danger">
                                Konfirmasi Penolakan
                            </button>
                        </form>
                    </div>

                @elseif($candidate->status === 'confirmed')
                    <form method="POST" action="{{ route('organizer.attend', $candidate->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Tandai kandidat ini hadir?')"
                                class="ak-btn ak-btn-blue">
                            Tandai Hadir
                        </button>
                    </form>

                @elseif($candidate->status === 'attended')
                    <div class="ak-alert ak-alert-info">
                        Volunteer ini sudah hadir di kegiatan ini.
                    </div>

                @elseif($candidate->status === 'cancelled')
                    <div class="ak-alert ak-alert-danger">
                        Pendaftaran ini sudah ditolak.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    .hidden-panel { display: none; }

    @media (max-width: 768px) {
        .ak-container > div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection