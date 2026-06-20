@php
    $tagColors = [
        'lingkungan' => 'tag-lingkungan',
        'sosial'     => 'tag-sosial',
        'pendidikan' => 'tag-pendidikan',
        'teknologi'  => 'tag-teknologi',
        'kesehatan'  => 'tag-kesehatan',
        'budaya'     => 'tag-budaya',
    ];
    $eventCategories = $event->categories ?? collect();
    $orgName = $event->organization->organization_name ?? '-';
    $location = $event->location_name ?? $event->city ?? null;
@endphp

<div class="event-card">
    @if($event->poster)
        <img class="card-thumb"
             src="{{ asset('storage/' . $event->poster) }}"
             alt="{{ $event->title }}">
    @else
        <div class="card-thumb-placeholder">
            <svg width="36" height="36" fill="none" viewBox="0 0 24 24"
                 stroke="#93C5FD" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                         l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01
                         M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2
                         0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
    @endif

    <div class="card-body">
        @if($eventCategories->isNotEmpty())
            <div class="card-tags">
                @foreach($eventCategories->take(3) as $cat)
                    @php
                        $slug = strtolower($cat->slug ?? $cat->name);
                        $cls  = $tagColors[$slug] ?? 'tag-default';
                    @endphp
                    <span class="tag {{ $cls }}">{{ $cat->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="card-title">{{ $event->title }}</div>
        <div class="card-org">{{ $orgName }}</div>

        <div class="card-meta">
            @if($location)
                <div class="meta-item">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0
                                 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $location }}
                </div>
            @endif
            @if($event->start_date)
                <div class="meta-item">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $event->start_date->translatedFormat('d M Y') }}
                </div>
            @endif
        </div>

        <div class="card-footer">
            @if($event->isFull())
                <span class="quota-pill" style="color:#EF4444;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    Penuh
                </span>
            @else
                <span class="quota-pill">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    {{ $event->remainingQuota() }} kuota
                </span>
            @endif

            <a href="{{ route('volunteer.events.show', $event->slug) }}"
               class="btn-lihat">Lihat</a>
        </div>
    </div>
</div>