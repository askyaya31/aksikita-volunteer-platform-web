<a href="{{ route('volunteer.events.show', $event->slug) }}"
   class="card block p-4 group">
    <div class="flex items-start gap-4">

        <div class="w-16 h-16 rounded-xl overflow-hidden bg-brand-50 flex-shrink-0 card-img-zoom">
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}"
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full gradient-brand flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <line x1="7" y1="9" x2="17" y2="9"/>
                        <line x1="7" y1="13" x2="13" y2="13"/>
                    </svg>
                </div>
            @endif
        </div>

        <div class="flex-1 min-w-0">
            @if($event->categories->count())
                <div class="flex flex-wrap gap-1 mb-1">
                    @foreach($event->categories->take(2) as $cat)
                        <span class="badge badge-primary">{{ $cat->name }}</span>
                    @endforeach
                </div>
            @endif

            <h3 class="font-bold text-slate-800 text-sm leading-snug truncate
                       group-hover:text-brand-600 transition-colors">
                {{ $event->title }}
            </h3>
            <p class="text-xs text-slate-500 truncate">{{ $event->organization->organization_name }}</p>

            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5 text-xs text-slate-400">
                <span class="flex items-center gap-1">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2" stroke-linecap="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $event->city }}
                </span>
                <span class="flex items-center gap-1">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $event->start_date->format('d M Y') }}
                </span>
            </div>
        </div>

        <div class="flex flex-col items-end gap-2 flex-shrink-0 self-center">
            @if($event->isFull())
                <span class="badge badge-danger">Penuh</span>
            @else
                <span class="text-xs font-semibold text-emerald-600">
                    {{ $event->remainingQuota() }} kuota
                </span>
            @endif
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2" stroke-linecap="round"
                 class="group-hover:stroke-brand-500 group-hover:translate-x-0.5 transition-all">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
        </div>
    </div>
</a>
