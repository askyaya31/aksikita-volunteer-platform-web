@extends('layouts.admin')

@section('title', $event->title . ' — Review Kegiatan')

@section('content')

<div style="display:flex; align-items:center; gap:8px; font-size:0.85rem; color:var(--color-ink-muted); margin-bottom:20px;">
    <a href="{{ route('admin.events') }}" style="color:var(--color-ink-muted); text-decoration:none;">Kegiatan</a>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span style="color:var(--color-ink);">{{ Str::limit($event->title, 40) }}</span>
</div>

<div class="ak-flex-between" style="flex-wrap:wrap; gap:16px; margin-bottom:28px;">
    <div>
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
            @php
                $statusMap = [
                    'pending_review' => ['label'=>'Menunggu Review', 'class'=>'ak-badge-warning'],
                    'published'      => ['label'=>'Aktif', 'class'=>'ak-badge-success'],
                    'completed'      => ['label'=>'Selesai', 'class'=>'ak-badge-gray'],
                    'rejected'       => ['label'=>'Ditolak', 'class'=>'ak-badge-danger'],
                    'draft'          => ['label'=>'Draft', 'class'=>'ak-badge-gray'],
                ];
                $s = $statusMap[$event->status] ?? ['label'=>$event->status, 'class'=>'ak-badge-gray'];
            @endphp
            <span class="ak-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
            @if($event->rejection_reason)
                <span class="ak-badge ak-badge-danger">Ditolak sebelumnya</span>
            @endif
        </div>
        <h1 style="font-size:1.5rem; margin-bottom:0;">{{ $event->title }}</h1>
    </div>
    <a href="{{ route('admin.events') }}?tab={{ $event->status === 'pending_review' ? 'review' : ($event->status === 'published' ? 'aktif' : ($event->status === 'completed' ? 'selesai' : 'ditolak')) }}"
       class="ak-btn ak-btn-ghost">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke daftar
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 380px; gap:24px; align-items:start;">
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Poster --}}
        @if($event->poster)
            <div class="ak-card-flat" style="padding:0; overflow:hidden;">
                <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}"
                     style="width:100%; max-height:340px; object-fit:cover; display:block;">
            </div>
        @endif

        {{-- Deskripsi --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.95rem; margin-bottom:12px;">Deskripsi Kegiatan</h3>
            <div style="font-size:0.9rem; color:var(--color-ink-soft); line-height:1.75; white-space:pre-wrap;">{{ $event->description }}</div>
        </div>

        {{-- Persyaratan --}}
        @if($event->requirements)
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:12px;">Persyaratan Volunteer</h3>
                <div style="font-size:0.9rem; color:var(--color-ink-soft); line-height:1.75; white-space:pre-wrap;">{{ $event->requirements }}</div>
            </div>
        @endif

        {{-- Kategori --}}
        @if($event->categories->count() > 0)
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:12px;">Kategori</h3>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    @foreach($event->categories as $cat)
                        <span class="ak-badge ak-badge-blue">{{ $cat->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Registrations summary --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.95rem; margin-bottom:16px;">Statistik Pendaftaran</h3>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
                <div style="text-align:center; padding:16px; background:var(--color-bg); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; color:var(--color-navy);">{{ $event->registrations->count() }}</div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:4px;">Total Daftar</div>
                </div>
                <div style="text-align:center; padding:16px; background:var(--color-bg); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; color:var(--color-success);">{{ $event->registrations->where('status','confirmed')->count() }}</div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:4px;">Dikonfirmasi</div>
                </div>
                <div style="text-align:center; padding:16px; background:var(--color-bg); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; color:var(--color-warning);">{{ $event->registrations->where('status','pending')->count() }}</div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:4px;">Pending</div>
                </div>
            </div>
        </div>

        {{-- Alasan penolakan sebelumnya --}}
        @if($event->rejection_reason)
            <div class="ak-alert ak-alert-danger">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600; margin-bottom:2px;">Alasan Penolakan Sebelumnya</div>
                    <div>{{ $event->rejection_reason }}</div>
                </div>
            </div>
        @endif

    </div>

    <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:calc(var(--spacing-navbar) + 16px);">

        {{-- Info singkat --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.95rem; margin-bottom:16px;">Informasi Kegiatan</h3>

            <div style="display:flex; flex-direction:column; gap:12px;">

                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px; color:var(--color-ink-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <div>
                        <div style="font-size:0.78rem; color:var(--color-ink-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:2px;">Organisasi</div>
                        <div style="font-size:0.875rem; color:var(--color-ink); font-weight:600;">{{ $event->organization->organization_name ?? '-' }}</div>
                        <div style="font-size:0.8rem; color:var(--color-ink-muted);">{{ $event->organization->user->email ?? '-' }}</div>
                    </div>
                </div>

                <hr class="ak-divider" style="margin:4px 0;">

                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px; color:var(--color-ink-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div>
                        <div style="font-size:0.78rem; color:var(--color-ink-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:2px;">Tanggal Pelaksanaan</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            @if($event->end_date && $event->end_date != $event->start_date)
                                – {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                            @endif
                        </div>
                        @if($event->start_time)
                            <div style="font-size:0.8rem; color:var(--color-ink-muted);">
                                {{ substr($event->start_time, 0, 5) }}
                                @if($event->end_time) – {{ substr($event->end_time, 0, 5) }} WIB @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px; color:var(--color-ink-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <div style="font-size:0.78rem; color:var(--color-ink-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:2px;">Lokasi</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">{{ $event->location_name }}</div>
                        <div style="font-size:0.8rem; color:var(--color-ink-muted);">{{ $event->city }}, {{ $event->province }}</div>
                        @if($event->location_address)
                            <div style="font-size:0.8rem; color:var(--color-ink-muted); margin-top:2px;">{{ $event->location_address }}</div>
                        @endif
                    </div>
                </div>

                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px; color:var(--color-ink-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <div>
                        <div style="font-size:0.78rem; color:var(--color-ink-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:2px;">Kuota</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">{{ $event->quota }} orang</div>
                    </div>
                </div>

                @if($event->contact_person)
                    <div style="display:flex; align-items:flex-start; gap:10px;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px; color:var(--color-ink-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <div>
                            <div style="font-size:0.78rem; color:var(--color-ink-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:2px;">Kontak</div>
                            <div style="font-size:0.875rem; color:var(--color-ink);">{{ $event->contact_person }}</div>
                            @if($event->contact_phone)
                                <div style="font-size:0.8rem; color:var(--color-ink-muted);">{{ $event->contact_phone }}</div>
                            @endif
                        </div>
                    </div>
                @endif

                <hr class="ak-divider" style="margin:4px 0;">

                <div style="font-size:0.78rem; color:var(--color-ink-muted);">
                    Diajukan {{ $event->created_at->diffForHumans() }}
                    @if($event->reviewed_at)
                        · Ditinjau {{ \Carbon\Carbon::parse($event->reviewed_at)->diffForHumans() }}
                        @if($event->reviewer)
                            oleh {{ $event->reviewer->name }}
                        @endif
                    @endif
                </div>

            </div>
        </div>

        @if($event->status === 'pending_review')
            <div class="ak-card-flat" style="border:1.5px solid var(--color-warning); background:var(--color-warning-bg);">
                <h3 style="font-size:0.95rem; margin-bottom:4px; color:var(--color-ink);">Tinjau Kegiatan Ini</h3>
                <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:16px;">
                    Pastikan kegiatan memenuhi syarat dan ketentuan platform sebelum menyetujui.
                </p>

                {{-- APPROVE --}}
                <form method="POST" action="{{ route('admin.events.review', $event->id) }}" id="formApprove">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="ak-btn ak-btn-success" style="width:100%; justify-content:center; margin-bottom:10px;"
                            onclick="return confirm('Setujui kegiatan ini? Kegiatan akan langsung dipublikasikan.')">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Setujui & Publikasikan
                    </button>
                </form>

                {{-- REJECT TOGGLE --}}
                <button type="button" onclick="document.getElementById('rejectPanel').classList.toggle('hidden')"
                        class="ak-btn ak-btn-ghost" style="width:100%; justify-content:center; color:var(--color-danger); border-color:var(--color-danger);">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tolak Kegiatan
                </button>

                {{-- REJECT FORM --}}
                <div id="rejectPanel" class="hidden" style="margin-top:14px; padding-top:14px; border-top:1px solid var(--color-warning);">
                    <form method="POST" action="{{ route('admin.events.review', $event->id) }}">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <div class="ak-form-group" style="margin-bottom:12px;">
                            <label class="ak-label" for="rejection_reason">
                                Alasan Penolakan <span class="required">*</span>
                            </label>
                            <textarea name="rejection_reason" id="rejection_reason" class="ak-textarea" rows="4"
                                      placeholder="Jelaskan secara spesifik kenapa kegiatan ini ditolak, sehingga organisasi bisa memperbaikinya..."
                                      required>{{ old('rejection_reason') }}</textarea>
                            <span class="ak-input-hint">Alasan ini akan dikirimkan ke organisasi melalui notifikasi.</span>
                        </div>
                        <button type="submit" class="ak-btn ak-btn-danger" style="width:100%; justify-content:center;"
                                onclick="return confirm('Yakin ingin menolak kegiatan ini?')">
                            Konfirmasi Penolakan
                        </button>
                    </form>
                </div>
            </div>
        @elseif($event->status === 'published')
            <div class="ak-alert ak-alert-success">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600;">Kegiatan Sudah Aktif</div>
                    <div style="font-size:0.8rem; margin-top:2px;">Kegiatan ini sudah dipublikasikan dan tampil di platform.</div>
                </div>
            </div>
        @elseif($event->status === 'rejected')
            <div class="ak-alert ak-alert-danger">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600;">Kegiatan Ditolak</div>
                    @if($event->rejection_reason)
                        <div style="font-size:0.8rem; margin-top:2px;">{{ $event->rejection_reason }}</div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>

document.getElementById('rejectPanel')?.classList.add('hidden');
</script>
<style>
.hidden { display: none !important; }
</style>
@endpush