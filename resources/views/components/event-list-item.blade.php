<div class="card" style="border:1px solid #ECEEF3; border-radius:16px; background:#fff; padding:20px 24px;">
    <div style="align-items:center; gap:18px; display:flex;">

        <a href="{{ route('volunteer.events.show', $event->slug) }}"
           class="flex-shrink-0"
           style="width:64px; height:64px; border-radius:12px; overflow:hidden; background:#EFF3FF; display:block;">
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}"
                     alt="{{ $event->title }}"
                     style="width:100%; height:100%; object-fit:cover; display:block;">
            @else
                <div class="gradient-brand" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <line x1="7" y1="9" x2="17" y2="9"/>
                        <line x1="7" y1="13" x2="13" y2="13"/>
                    </svg>
                </div>
            @endif
        </a>

        <div style="flex:1; min-width:0;">
            @if($event->categories->count())
                <div style="display:flex; gap:18px; margin-bottom:6px;">
                    @foreach($event->categories->take(2) as $cat)
                        <span style="font-size:10px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; color:#0F2057;">
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('volunteer.events.show', $event->slug) }}" style="text-decoration:none;">
                <h3 style="font-size:14.5px; font-weight:700; color:#0F2057; line-height:1.35; margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $event->title }}
                </h3>
            </a>
            <p style="font-size:12px; color:#0F2057; margin-bottom:7px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                {{ $event->organization->organization_name }}
            </p>

            <div style="display:flex; flex-wrap:wrap; gap:14px; font-size:11.5px; color:#0F2057;">
                <span style="display:flex; align-items:center; gap:4px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2" stroke-linecap="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $event->city }}
                </span>
                <span style="display:flex; align-items:center; gap:4px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $event->start_date->format('d M Y') }}
                </span>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; align-items:flex-end; justify-content:space-between; align-self:stretch; flex-shrink:0;">
            @if($event->isFull())
                <span style="display:flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600; color:#EF4444;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    Penuh
                </span>
            @else
                <span style="display:flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600; color:#0F2057;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    {{ $event->remainingQuota() }} kuota
                </span>
            @endif

            <a href="{{ route('volunteer.events.show', $event->slug) }}"
               style="padding:7px 22px; border-radius:9999px; font-size:12.5px; font-weight:700; background:#0F2057; color:#fff; text-decoration:none; transition:background .15s; display:inline-block;"
               onmouseover="this.style.background='#1A3575'"
               onmouseout="this.style.background='#0F2057'">
                Lihat
            </a>
        </div>
    </div>
</div>