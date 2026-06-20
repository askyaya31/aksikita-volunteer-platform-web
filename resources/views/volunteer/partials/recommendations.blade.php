@if($recommendations->isNotEmpty())
<section style="margin-top:2rem;">

    <div style="display:flex; align-items:center; justify-content:space-between;
                margin-bottom:1rem;">
        <div>
            <h2 style="font-family:var(--font-display); font-size:1.1rem;
                       font-weight:700; color:var(--color-navy); margin:0;">
                Rekomendasi untuk Kamu
            </h2>
            <p style="font-size:0.8rem; color:var(--color-ink-muted); margin:3px 0 0;">
                Berdasarkan minat dan riwayat kegiatanmu
            </p>
        </div>
        <a href="{{ route('volunteer.events') }}"
           style="font-size:0.8rem; font-weight:600; color:var(--color-blue);
                  text-decoration:none;">
            Lihat semua →
        </a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));
                gap:14px;">
        @foreach($recommendations as $event)
            @php
                $isPast = \Carbon\Carbon::parse($event->end_date)->isPast();
            @endphp
            <a href="{{ route('volunteer.events.show', $event->slug) }}"
               style="display:flex; flex-direction:column; background:var(--color-surface);
                      border:1.5px solid var(--color-border); border-radius:var(--radius-lg);
                      overflow:hidden; text-decoration:none;
                      transition:box-shadow 0.15s, border-color 0.15s;"
               onmouseover="this.style.boxShadow='0 4px 16px rgba(15,32,87,0.10)';
                            this.style.borderColor='var(--color-blue-light)'"
               onmouseout="this.style.boxShadow='none';
                           this.style.borderColor='var(--color-border)'">

                @if($event->poster)
                    <div style="height:140px; overflow:hidden; flex-shrink:0;">
                        <img src="{{ Storage::url($event->poster) }}"
                             alt="{{ $event->title }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    </div>
                @else
                    <div style="height:140px; flex-shrink:0;
                                background:linear-gradient(135deg, var(--color-navy) 0%, var(--color-blue) 100%);
                                display:flex; align-items:center; justify-content:center;">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24"
                             stroke="rgba(255,255,255,0.4)" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <div style="padding:12px 14px; flex:1; display:flex;
                            flex-direction:column; gap:6px;">
                    @if($event->categories->isNotEmpty())
                        <div style="display:flex; flex-wrap:wrap; gap:4px;">
                            @foreach($event->categories->take(2) as $cat)
                                <span style="display:inline-flex; padding:2px 8px;
                                             background:var(--color-blue-ghost);
                                             color:var(--color-blue);
                                             border-radius:var(--radius-full);
                                             font-size:0.7rem; font-weight:600;">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div style="font-size:0.9rem; font-weight:700; color:var(--color-navy);
                                line-height:1.4; display:-webkit-box;
                                -webkit-line-clamp:2; -webkit-box-orient:vertical;
                                overflow:hidden;">
                        {{ $event->title }}
                    </div>

                    <div style="font-size:0.75rem; color:var(--color-ink-muted);
                                display:flex; align-items:center; gap:10px; flex-wrap:wrap;
                                margin-top:auto;">
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }}
                        </span>
                        @if($event->city)
                            <span style="display:flex; align-items:center; gap:4px;">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->city }}
                            </span>
                        @endif
                    </div>

                </div>
            </a>
        @endforeach
    </div>

</section>
@endif