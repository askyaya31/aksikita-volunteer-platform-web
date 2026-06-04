@extends('layouts.admin')

@section('title', $user->name . ' — Detail Volunteer')

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:8px; font-size:0.85rem; color:var(--color-ink-muted); margin-bottom:20px;">
    <a href="{{ route('admin.users') }}" style="color:var(--color-ink-muted); text-decoration:none;">Pengguna</a>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.users') }}?tab=volunteer" style="color:var(--color-ink-muted); text-decoration:none;">Volunteer</a>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span style="color:var(--color-ink);">{{ $user->name }}</span>
</div>

@php $profile = $user->volunteerProfile; @endphp

{{-- Header --}}
<div style="display:flex; align-items:flex-start; gap:20px; margin-bottom:28px; flex-wrap:wrap;">
    {{-- Avatar --}}
    <div style="width:72px; height:72px; border-radius:50%; overflow:hidden; flex-shrink:0; border:2px solid var(--color-border);">
        @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" style="width:100%; height:100%; object-fit:cover;">
        @else
            <div style="width:100%; height:100%; background:linear-gradient(135deg, var(--color-navy) 0%, var(--color-blue) 100%); display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:1.75rem; font-weight:800; color:#fff;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </div>

    <div style="flex:1; min-width:0;">
        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px;">
            <span class="ak-badge ak-badge-blue">Volunteer</span>
            @if($user->is_active)
                <span class="ak-badge ak-badge-success">Akun Aktif</span>
            @else
                <span class="ak-badge ak-badge-danger">Akun Nonaktif</span>
            @endif
        </div>
        <h1 style="font-size:1.5rem; margin-bottom:4px;">{{ $user->name }}</h1>
        <div style="font-size:0.875rem; color:var(--color-ink-muted);">
            {{ $user->email }}
            @if($user->phone) · {{ $user->phone }} @endif
            @if($profile?->city) · {{ $profile->city }}, {{ $profile->province }} @endif
        </div>
    </div>

    <a href="{{ route('admin.users') }}?tab=volunteer" class="ak-btn ak-btn-ghost" style="flex-shrink:0;">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start;">

    {{-- LEFT --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Bio --}}
        @if($profile?->bio)
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:12px;">Bio</h3>
                <div style="font-size:0.9rem; color:var(--color-ink-soft); line-height:1.75;">{{ $profile->bio }}</div>
            </div>
        @endif

        {{-- Skills & Minat --}}
        @if($profile && ($profile->skills || $profile->interests))
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:16px;">Keahlian & Minat</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    @if($profile->skills)
                        <div>
                            <div style="font-size:0.78rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px;">Keahlian</div>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                @foreach((is_array($profile->skills) ? $profile->skills : json_decode($profile->skills, true) ?? []) as $skill)
                                    <span class="ak-badge ak-badge-navy">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($profile->interests)
                        <div>
                            <div style="font-size:0.78rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px;">Minat</div>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                @foreach((is_array($profile->interests) ? $profile->interests : json_decode($profile->interests, true) ?? []) as $interest)
                                    <span class="ak-badge ak-badge-blue">{{ $interest }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Riwayat registrasi --}}
        @php
            $registrations = $user->registrations ?? collect();
        @endphp
        <div class="ak-card-flat">
            <div class="ak-flex-between" style="margin-bottom:16px;">
                <h3 style="font-size:0.95rem; margin-bottom:0;">Riwayat Kegiatan</h3>
                @if($registrations->count() > 0)
                    <span class="ak-badge ak-badge-blue">{{ $registrations->count() }} pendaftaran</span>
                @endif
            </div>

            @if($registrations->isEmpty())
                <div class="ak-empty-state" style="padding:32px 0;">
                    <div class="ak-empty-state__icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3>Belum ada aktivitas</h3>
                    <p>Volunteer ini belum pernah mendaftar kegiatan.</p>
                </div>
            @else
                <div class="ak-table-wrapper">
                    <table class="ak-table">
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations->take(15) as $reg)
                                @php
                                    $rMap = [
                                        'pending'   => ['Pending', 'ak-badge-warning'],
                                        'confirmed' => ['Dikonfirmasi', 'ak-badge-success'],
                                        'attended'  => ['Hadir', 'ak-badge-navy'],
                                        'cancelled' => ['Dibatalkan', 'ak-badge-danger'],
                                    ];
                                    [$rLabel, $rClass] = $rMap[$reg->status] ?? [$reg->status, 'ak-badge-gray'];
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:500; font-size:0.875rem; color:var(--color-ink);">
                                            {{ $reg->event->title ?? '—' }}
                                        </div>
                                        <div style="font-size:0.78rem; color:var(--color-ink-muted);">
                                            {{ $reg->event->organization->organization_name ?? '' }}
                                        </div>
                                    </td>
                                    <td style="font-size:0.8rem; color:var(--color-ink-muted); white-space:nowrap;">
                                        {{ $reg->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="ak-badge {{ $rClass }}">{{ $rLabel }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Statistik partisipasi --}}
        @if($registrations->count() > 0)
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:16px;">Statistik Partisipasi</h3>
                <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:12px;">
                    @php
                        $statCounts = [
                            ['label' => 'Total Daftar', 'value' => $registrations->count(), 'color' => 'var(--color-navy)'],
                            ['label' => 'Dikonfirmasi', 'value' => $registrations->where('status','confirmed')->count(), 'color' => 'var(--color-success)'],
                            ['label' => 'Hadir', 'value' => $registrations->where('status','attended')->count(), 'color' => 'var(--color-blue)'],
                            ['label' => 'Dibatalkan', 'value' => $registrations->where('status','cancelled')->count(), 'color' => 'var(--color-danger)'],
                        ];
                    @endphp
                    @foreach($statCounts as $sc)
                        <div style="text-align:center; padding:16px 12px; background:var(--color-bg); border-radius:var(--radius-md);">
                            <div style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; color:{{ $sc['color'] }};">{{ $sc['value'] }}</div>
                            <div style="font-size:0.75rem; color:var(--color-ink-muted); margin-top:4px;">{{ $sc['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- RIGHT --}}
    <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:calc(var(--spacing-navbar) + 16px);">

        {{-- Info pribadi --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.95rem; margin-bottom:16px;">Informasi Akun</h3>
            <div style="display:flex; flex-direction:column; gap:12px;">

                <div>
                    <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Email</div>
                    <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->email }}</div>
                </div>

                @if($user->phone)
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Telepon</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->phone }}</div>
                    </div>
                @endif

                @if($profile?->date_of_birth)
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Tanggal Lahir</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">{{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') }}</div>
                    </div>
                @endif

                @if($profile?->gender)
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Jenis Kelamin</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">
                            @php $gMap = ['male'=>'Laki-laki', 'female'=>'Perempuan', 'other'=>'Lainnya']; @endphp
                            {{ $gMap[$profile->gender] ?? $profile->gender }}
                        </div>
                    </div>
                @endif

                @if($profile?->city)
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Lokasi</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">{{ $profile->city }}, {{ $profile->province }}</div>
                    </div>
                @endif

                <hr class="ak-divider" style="margin:4px 0;">

                <div>
                    <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Bergabung</div>
                    <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->created_at->format('d M Y') }}</div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted);">{{ $user->created_at->diffForHumans() }}</div>
                </div>

            </div>
        </div>

        {{-- Toggle status akun --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.95rem; margin-bottom:4px;">Status Akun</h3>
            <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:14px;">
                {{ $user->is_active
                    ? 'Akun aktif. Volunteer dapat login dan mendaftar kegiatan.'
                    : 'Akun nonaktif. Volunteer tidak dapat login.' }}
            </p>
            <button type="button"
                    onclick="toggleUserActive({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }}, this)"
                    class="ak-btn ak-btn-sm {{ $user->is_active ? 'ak-btn-danger' : 'ak-btn-success' }}"
                    style="width:100%; justify-content:center;">
                {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
            </button>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
async function toggleUserActive(userId, currentlyActive, btn) {
    if (!confirm(currentlyActive
        ? 'Nonaktifkan akun volunteer ini?'
        : 'Aktifkan kembali akun volunteer ini?'
    )) return;
    btn.disabled = true;
    try {
        const res = await fetch(`/api/admin/users/${userId}/toggle-active`, {
            method: 'PATCH',
            headers: { 'Accept': 'application/json' },
        });
        if (res.ok) {
            window.location.reload();
        } else {
            const d = await res.json();
            alert(d.message ?? 'Gagal mengubah status.');
            btn.disabled = false;
        }
    } catch {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        btn.disabled = false;
    }
}
</script>
@endpush