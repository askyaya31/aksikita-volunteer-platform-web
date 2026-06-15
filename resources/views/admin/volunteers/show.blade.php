@extends('layouts.admin')

@section('title', $user->name . ' — Detail Volunteer')

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:8px; font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:20px;">
    <a href="{{ route('admin.users') }}" style="color:var(--color-ink-muted); text-decoration:none; hover:color:var(--color-navy);">Pengguna</a>
    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.users') }}?tab=volunteer" style="color:var(--color-ink-muted); text-decoration:none;">Volunteer</a>
    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span style="color:var(--color-ink);">{{ $user->name }}</span>
</div>

@php $profile = $user->volunteerProfile; @endphp

{{-- Header --}}
<div style="display:flex; align-items:flex-start; gap:18px; margin-bottom:28px; flex-wrap:wrap;">
    <div style="width:68px; height:68px; border-radius:50%; overflow:hidden; flex-shrink:0; border:1px solid var(--color-border);">
        @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" style="width:100%; height:100%; object-fit:cover;">
        @else
            <div style="width:100%; height:100%; background:var(--color-navy); display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:1.625rem; font-weight:800; color:#fff;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </div>

    <div style="flex:1; min-width:0;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:5px;">
            <span style="font-size:0.775rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em;">Volunteer</span>
            <span style="width:3px; height:3px; border-radius:50%; background:var(--color-border);"></span>
            <span style="display:inline-flex; align-items:center; gap:4px; font-size:0.775rem; font-weight:500; color:{{ $user->is_active ? 'var(--color-ink-muted)' : 'var(--color-danger)' }};">
                <span style="width:5px; height:5px; border-radius:50%; background:{{ $user->is_active ? 'var(--color-success)' : 'var(--color-danger)' }};"></span>
                {{ $user->is_active ? 'Akun aktif' : 'Akun nonaktif' }}
            </span>
        </div>
        <h1 style="font-size:1.375rem; margin-bottom:4px;">{{ $user->name }}</h1>
        <div style="font-size:0.85rem; color:var(--color-ink-muted);">
            {{ $user->email }}
            @if($user->phone) · {{ $user->phone }} @endif
            @if($profile?->city) · {{ $profile->city }}, {{ $profile->province }} @endif
        </div>
    </div>

    <a href="{{ route('admin.users') }}?tab=volunteer" class="ak-btn ak-btn-ghost" style="flex-shrink:0; font-size:0.875rem;">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 300px; gap:24px; align-items:start;">

    {{-- LEFT --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Bio --}}
        @if($profile?->bio)
            <div class="ak-card-flat">
                <h3 style="font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--color-ink-muted); margin-bottom:12px;">Bio</h3>
                <div style="font-size:0.9rem; color:var(--color-ink-soft); line-height:1.75;">{{ $profile->bio }}</div>
            </div>
        @endif

        {{-- Skills & Minat --}}
        @if($profile && ($profile->skills || $profile->interests))
            <div class="ak-card-flat">
                <h3 style="font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--color-ink-muted); margin-bottom:16px;">Keahlian & Minat</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    @if($profile->skills)
                        <div>
                            <div style="font-size:0.775rem; font-weight:600; color:var(--color-ink-muted); margin-bottom:8px;">Keahlian</div>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                @foreach((is_array($profile->skills) ? $profile->skills : json_decode($profile->skills, true) ?? []) as $skill)
                                    <span style="padding:3px 9px; border-radius:4px; font-size:0.775rem; font-weight:500; background:var(--color-bg); border:1px solid var(--color-border); color:var(--color-ink-soft);">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($profile->interests)
                        <div>
                            <div style="font-size:0.775rem; font-weight:600; color:var(--color-ink-muted); margin-bottom:8px;">Minat</div>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                @foreach((is_array($profile->interests) ? $profile->interests : json_decode($profile->interests, true) ?? []) as $interest)
                                    <span style="padding:3px 9px; border-radius:4px; font-size:0.775rem; font-weight:500; background:var(--color-bg); border:1px solid var(--color-border); color:var(--color-ink-soft);">{{ $interest }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Riwayat Kegiatan --}}
        @php $registrations = $user->registrations ?? collect(); @endphp
        <div class="ak-card-flat">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <h3 style="font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--color-ink-muted); margin-bottom:0;">Riwayat Kegiatan</h3>
                @if($registrations->count() > 0)
                    <span style="font-size:0.8rem; color:var(--color-ink-muted);">{{ $registrations->count() }} pendaftaran</span>
                @endif
            </div>

            @if($registrations->isEmpty())
                <div class="ak-empty-state" style="padding:32px 0;">
                    <div class="ak-empty-state__icon">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                        'pending'   => ['Pending', 'var(--color-warning)'],
                                        'confirmed' => ['Dikonfirmasi', 'var(--color-success)'],
                                        'attended'  => ['Hadir', 'var(--color-navy)'],
                                        'cancelled' => ['Dibatalkan', 'var(--color-danger)'],
                                    ];
                                    [$rLabel, $rColor] = $rMap[$reg->status] ?? [$reg->status, 'var(--color-ink-muted)'];
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:500; font-size:0.875rem; color:var(--color-ink);">
                                            {{ $reg->event->title ?? '—' }}
                                        </div>
                                        <div style="font-size:0.775rem; color:var(--color-ink-muted);">
                                            {{ $reg->event->organization->organization_name ?? '' }}
                                        </div>
                                    </td>
                                    <td style="font-size:0.8rem; color:var(--color-ink-muted); white-space:nowrap;">
                                        {{ $reg->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span style="font-size:0.8rem; font-weight:500; color:{{ $rColor }};">{{ $rLabel }}</span>
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
                <h3 style="font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--color-ink-muted); margin-bottom:16px;">Statistik Partisipasi</h3>
                <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:1px; background:var(--color-border); border:1px solid var(--color-border); border-radius:var(--radius-md); overflow:hidden;">
                    @php
                        $statCounts = [
                            ['label' => 'Total Daftar', 'value' => $registrations->count()],
                            ['label' => 'Dikonfirmasi', 'value' => $registrations->where('status','confirmed')->count()],
                            ['label' => 'Hadir', 'value' => $registrations->where('status','attended')->count()],
                            ['label' => 'Dibatalkan', 'value' => $registrations->where('status','cancelled')->count()],
                        ];
                    @endphp
                    @foreach($statCounts as $sc)
                        <div style="text-align:center; padding:16px 8px; background:var(--color-surface);">
                            <div style="font-family:var(--font-display); font-size:1.625rem; font-weight:800; color:var(--color-navy); line-height:1;">{{ $sc['value'] }}</div>
                            <div style="font-size:0.75rem; color:var(--color-ink-muted); margin-top:5px;">{{ $sc['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- RIGHT --}}
    <div style="display:flex; flex-direction:column; gap:16px; position:sticky; top:calc(var(--spacing-navbar) + 16px);">

        {{-- Info akun --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--color-ink-muted); margin-bottom:14px;">Informasi Akun</h3>
            <div style="display:flex; flex-direction:column; gap:11px;">

                <div>
                    <div style="font-size:0.725rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:2px;">Email</div>
                    <div style="font-size:0.85rem; color:var(--color-ink);">{{ $user->email }}</div>
                </div>

                @if($user->phone)
                    <div>
                        <div style="font-size:0.725rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:2px;">Telepon</div>
                        <div style="font-size:0.85rem; color:var(--color-ink);">{{ $user->phone }}</div>
                    </div>
                @endif

                @if($profile?->date_of_birth)
                    <div>
                        <div style="font-size:0.725rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:2px;">Tanggal Lahir</div>
                        <div style="font-size:0.85rem; color:var(--color-ink);">{{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') }}</div>
                    </div>
                @endif

                @if($profile?->gender)
                    <div>
                        <div style="font-size:0.725rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:2px;">Jenis Kelamin</div>
                        <div style="font-size:0.85rem; color:var(--color-ink);">
                            @php $gMap = ['male'=>'Laki-laki', 'female'=>'Perempuan', 'other'=>'Lainnya']; @endphp
                            {{ $gMap[$profile->gender] ?? $profile->gender }}
                        </div>
                    </div>
                @endif

                @if($profile?->city)
                    <div>
                        <div style="font-size:0.725rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:2px;">Lokasi</div>
                        <div style="font-size:0.85rem; color:var(--color-ink);">{{ $profile->city }}, {{ $profile->province }}</div>
                    </div>
                @endif

                <div style="height:1px; background:var(--color-border); margin:2px 0;"></div>

                <div>
                    <div style="font-size:0.725rem; font-weight:600; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:2px;">Bergabung</div>
                    <div style="font-size:0.85rem; color:var(--color-ink);">{{ $user->created_at->format('d M Y') }}</div>
                    <div style="font-size:0.775rem; color:var(--color-ink-muted);">{{ $user->created_at->diffForHumans() }}</div>
                </div>

            </div>
        </div>

        {{-- Status akun --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--color-ink-muted); margin-bottom:6px;">Status Akun</h3>
            <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:14px; line-height:1.5;">
                {{ $user->is_active
                    ? 'Volunteer dapat login dan mendaftar kegiatan.'
                    : 'Akun dinonaktifkan. Volunteer tidak dapat login.' }}
            </p>
            <button type="button"
                    onclick="toggleUserActive({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }}, this)"
                    class="ak-btn ak-btn-sm {{ $user->is_active ? 'ak-btn-ghost' : 'ak-btn-success' }}"
                    style="width:100%; justify-content:center; {{ $user->is_active ? 'color:var(--color-danger);' : '' }}">
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
