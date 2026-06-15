@extends('layouts.volunteer')
@section('title', 'Kegiatan Tersimpan')

@section('content')
<div style="max-width:900px; margin:0 auto; padding:2rem 1.5rem;">
    <h1 style="font-size:20px; font-weight:700; color:#0F2057; margin-bottom:1.5rem;">
        Kegiatan Tersimpan
    </h1>

    @if($saved->isEmpty())
        <p style="color:#9099B0; font-size:14px;">Belum ada kegiatan yang kamu simpan.</p>
    @else
        <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach($saved as $item)
                @if($item->event)
                    @include('components.event-list-item', ['event' => $item->event])
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection