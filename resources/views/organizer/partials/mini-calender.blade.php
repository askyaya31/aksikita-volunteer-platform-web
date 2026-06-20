@php
    $currentMonth = $currentMonth ?? now()->month;
    $currentYear  = $currentYear  ?? now()->year;
    $today        = now()->format('Y-m-d');
    
    $yearMonth = \Carbon\Carbon::create($currentYear, $currentMonth);
    $daysInMonth = $yearMonth->daysInMonth;
    $firstDayOfMonth = $yearMonth->startOfMonth()->dayOfWeek; 
    $monthName = $yearMonth->translatedFormat('F Y');
@endphp

<div class="mini-calendar">
    <div class="cal-header flex items-center justify-between mb-6">
        <button onclick="prevMonth()" 
                class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 text-[#0F2057]">
            ←
        </button>
        
        <h3 class="font-semibold text-xl text-[#0F2057]" id="calendar-title">
            {{ $monthName }}
        </h3>
        
        <button onclick="nextMonth()" 
                class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 text-[#0F2057]">
            →
        </button>
    </div>

    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
            <div class="text-center text-xs font-semibold text-gray-500 py-1">
                {{ $day }}
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-7 gap-1" id="calendar-grid">
        @php
            for ($i = 0; $i < $firstDayOfMonth; $i++) {
                echo '<div class="aspect-square"></div>';
            }
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                $isToday = $dateStr === $today;
                $hasEvent = in_array($dateStr, $markedDates ?? []); 
                
                $class = 'cal-cell aspect-square flex items-center justify-center text-sm font-medium rounded-2xl transition-all cursor-pointer';
                
                if ($isToday) {
                    $class .= ' bg-[#0F2057] text-white';
                } elseif ($hasEvent) {
                    $class .= ' bg-blue-50 text-[#0F2057] relative';
                } else {
                    $class .= ' hover:bg-gray-100 text-gray-700';
                }
                
                echo "<div class='{$class}' data-date='{$dateStr}' onclick='selectDate(this)'>";
                echo $day;
                if ($hasEvent && !$isToday) {
                    echo "<span class='absolute bottom-1.5 w-1.5 h-1.5 bg-[#0066FF] rounded-full'></span>";
                }
                echo "</div>";
            }
        @endphp
    </div>
</div>

@push('styles')
<style>
    .mini-calendar {
        font-family: 'Sora', system-ui, sans-serif;
    }
    
    .cal-cell {
        height: 42px;
        line-height: 42px;
    }
    
    .cal-cell:hover:not(.bg-[#0F2057]) {
        background-color: #EFF6FF !important;
    }
</style>
@endpush

@push('scripts')
<script>
let currentMonth = {{ $currentMonth }};
let currentYear  = {{ $currentYear }};

function prevMonth() {
    currentMonth--;
    if (currentMonth < 1) {
        currentMonth = 12;
        currentYear--;
    }
    refreshCalendar();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 12) {
        currentMonth = 1;
        currentYear++;
    }
    refreshCalendar();
}

function selectDate(el) {
    document.querySelectorAll('.cal-cell').forEach(cell => {
        cell.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-500');
    });
    el.classList.add('ring-2', 'ring-offset-2', 'ring-blue-500');
    console.log('Selected date:', el.dataset.date);
}

function refreshCalendar() {
    window.location.href = `{{ route('organizer.schedule') }}?month=${currentMonth}&year=${currentYear}`;
}
</script>
@endpush