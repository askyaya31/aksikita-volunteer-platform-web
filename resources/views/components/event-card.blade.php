@php
    $catColors = [
        'lingkungan' => ['bg' => '#0E7B6C', 'bg2' => '#1DB8A0'],
        'pendidikan'  => ['bg' => '#1A3575', 'bg2' => '#2A4A9C'],
        'kesehatan'   => ['bg' => '#B02060', 'bg2' => '#E4409A'],
        'sosial'      => ['bg' => '#D4900A', 'bg2' => '#EFB530'],
        'bencana'     => ['bg' => '#7B1E1E', 'bg2' => '#C0392B'],
        'budaya'      => ['bg' => '#5B2B8C', 'bg2' => '#8E44AD'],
    ];
    $firstCat  = $event->categories->first();
    $slug      = $firstCat?->slug ?? 'default';
    $palette   = $catColors[$slug] ?? ['bg' => '#E2E8F0', 'bg2' => '#CBD5E1']; // Default abu-abu
@endphp

<div class="ecard">
    <div class="ecard-img" style="
        @if($event->poster)
            background-image: url('{{ asset('storage/' . $event->poster) }}');
            background-size: cover;
            background-position: center;
        @else
            /* Background transparan/checkered pattern simulasi jika tidak ada gambar */
            background-image: repeating-linear-gradient(45deg, #f0f0f0 25%, transparent 25%, transparent 75%, #f0f0f0 75%, #f0f0f0), repeating-linear-gradient(45deg, #f0f0f0 25%, #ffffff 25%, #ffffff 75%, #f0f0f0 75%, #f0f0f0);
            background-position: 0 0, 10px 10px;
            background-size: 20px 20px;
        @endif
    ">
        <div class="ecard-cats">
            @foreach($event->categories->take(2) as $cat)
                <span class="ecard-cat">{{ $cat->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="ecard-body">
        <p class="ecard-org">{{ $event->organization->organization_name }}</p>

        <h3 class="ecard-title">{{ $event->title }}</h3>

        <div class="ecard-meta">
            <div class="ecard-meta-row">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>{{ $event->location_name ?? $event->city }}</span>
            </div>
            <div class="ecard-meta-row">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>{{ $event->start_date->format('d M Y - H:i') }}</span>
            </div>
        </div>

        <div class="ecard-footer">
            <span class="ecard-slots">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                {{ $event->remainingQuota() }} kuota
            </span>
            <a href="{{ route('volunteer.events.show', $event->slug) }}" class="ecard-btn">Lihat</a>
        </div>
    </div>
</div>