<?php
namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Notification;
use App\Models\OrganizationProfile;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ChatRoom;

class EventController extends Controller
{
    private function getOrg()
    {
        return OrganizationProfile::where('user_id', session('user_id'))->firstOrFail();
    }

    public function index(Request $request)
    {
        $org = $this->getOrg();
        $tab = $request->get('tab', 'aktif');

        $statusMap = [
            'aktif'   => 'published',
            'review'  => 'pending_review',
            'draft'   => 'draft',
            'selesai' => 'completed',
            'ditolak' => 'rejected',
        ];

        $events = Event::with('categories')
            ->where('organization_profile_id', $org->id)
            ->where('status', $statusMap[$tab] ?? 'published')
            ->latest()
            ->paginate(10);

        return view('organizer.events.index', compact('events', 'tab', 'org'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'location_name' => 'required|string',
            'city'          => 'required|string|max:100',
            'province'      => 'required|string|max:100',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i',
            'quota'         => 'required|integer|min:1',
            'category_ids'  => 'required|array|min:1',
            'category_ids.*'=> 'exists:categories,id',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'category_ids.required'     => 'Pilih minimal 1 kategori.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
        ]);

        $org = $this->getOrg();
        
        if ($org->verification_status !== 'verified') {
            return back()->with('error', 'Organisasi Anda belum diverifikasi. Menunggu persetujuan admin.');
        }

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }
        $event = Event::create([
            'organization_profile_id' => $org->id,
            'title'                   => $request->title,
            'slug'                    => Str::slug($request->title) . '-' . Str::random(6),
            'description'             => $request->description,
            'location_name'           => $request->location_name,
            'location_address'        => $request->location_address,
            'city'                    => $request->city,
            'province'                => $request->province,
            'start_date'              => $request->start_date,
            'end_date'                => $request->end_date,
            'start_time'              => $request->start_time,
            'end_time'                => $request->end_time,
            'quota'                   => $request->quota,
            'requirements'            => $request->requirements,
            'contact_person'          => $request->contact_person,
            'contact_phone'           => $request->contact_phone,
            'poster'                  => $posterPath,
            'status'                  => 'draft',
        ]);

        $event->categories()->attach($request->category_ids);

        return redirect()->route('organizer.events.show', $event->id)
            ->with('success', 'Event berhasil dibuat sebagai draft. Ajukan ke review admin kalau sudah siap.');
    }

    public function show(int $id)
    {
        $org   = $this->getOrg();
        $event = Event::with([
                    'categories',
                    'registrations.user.volunteerProfile',
                    'registrations.chatRoom',   
                ])
                ->where('organization_profile_id', $org->id)
                ->findOrFail($id);

        return view('organizer.events.show', compact('event'));
    }

    public function edit(int $id)
    {
        $org   = $this->getOrg();
        $event = Event::where('organization_profile_id', $org->id)->findOrFail($id);

        if (!in_array($event->status, ['draft', 'rejected', 'published'])) {
            return back()->with('error', 'Hanya event berstatus draft, ditolak, atau published yang bisa diedit.');
        }

        $categories = Category::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'location_name' => 'required|string',
            'city'          => 'required|string|max:100',
            'province'      => 'required|string|max:100',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'quota'         => 'required|integer|min:1',
            'category_ids'  => 'required|array|min:1',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $org   = $this->getOrg();
        $event = Event::where('organization_profile_id', $org->id)->findOrFail($id);

        if (!in_array($event->status, ['draft', 'rejected', 'published'])) {
            return back()->with('error', 'Hanya event berstatus draft, ditolak, atau published yang bisa diedit.');
        }

        $data = $request->only([
            'title', 'description', 'location_name', 'location_address',
            'city', 'province', 'start_date', 'end_date',
            'start_time', 'end_time', 'quota', 'requirements',
            'contact_person', 'contact_phone',
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $data['status']           = 'pending_review';
        $data['rejection_reason'] = null;

        $event->update($data);
        $event->categories()->sync($request->category_ids);

        User::where('role', 'admin')->each(function ($admin) use ($event, $org) {
            Notification::create([
                'user_id'          => $admin->id,
                'title'            => 'Event Diajukan Ulang',
                'message'          => "Event '{$event->title}' oleh {$org->organization_name} telah diperbarui dan perlu direview.",
                'type'             => 'event_pending_review',
                'related_event_id' => $event->id,
            ]);
        });

        return redirect()->route('organizer.events.show', $event->id)
            ->with('success', 'Event berhasil diperbarui dan diajukan ulang ke review admin.');
    }

    public function destroy(int $id)
    {
        $org   = $this->getOrg();
        $event = Event::where('organization_profile_id', $org->id)->findOrFail($id);

        if (!in_array($event->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Hanya event draft atau ditolak yang bisa dihapus.');
        }

        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function submit(int $id)
    {
        $org   = $this->getOrg();
        $event = Event::where('organization_profile_id', $org->id)
            ->where('status', 'draft')
            ->findOrFail($id);

        $event->update(['status' => 'pending_review']);

        // notif ke semua admin
        User::where('role', 'admin')->each(function ($admin) use ($event, $org) {
            Notification::create([
                'user_id'          => $admin->id,
                'title'            => 'Event Baru Menunggu Review',
                'message'          => "Event '{$event->title}' oleh {$org->organization_name} perlu direview.",
                'type'             => 'event_pending_review',
                'related_event_id' => $event->id,
            ]);
        });

        return back()->with('success', 'Event berhasil diajukan ke review admin.');
    }

    public function complete(int $id)
    {
        $org   = $this->getOrg();
        $event = Event::where('organization_profile_id', $org->id)->findOrFail($id);

        if ($event->status !== 'published') {
            return back()->with('error', 'Hanya event published yang bisa ditandai selesai.');
        }

        $event->update(['status' => 'completed']);

        Registration::where('event_id', $event->id)
            ->where('status', 'confirmed')
            ->get()
            ->each(function ($reg) use ($event) {
                Notification::create([
                    'user_id'          => $reg->user_id,
                    'title'            => 'Kegiatan Selesai',
                    'message'          => "Kegiatan '{$event->title}' telah selesai. Terima kasih sudah berpartisipasi!",
                    'type'             => 'event_completed',
                    'related_event_id' => $event->id,
                ]);
            });

        return back()->with('success', 'Event berhasil ditandai sebagai selesai.');
    }

    public function confirm(int $id)
    {
        $org = $this->getOrg();
        $reg = Registration::with('event')
            ->whereHas('event', fn($q) => $q->where('organization_profile_id', $org->id))
            ->findOrFail($id);

        $reg->update(['status' => 'confirmed']);
$reg->event->increment('registered_count'); 

        Notification::create([
            'user_id'          => $reg->user_id,
            'title'            => 'Pendaftaran Diterima!',
            'message'          => "Selamat! Pendaftaran kamu untuk '{$reg->event->title}' telah diterima.",
            'type'             => 'registration_confirmed',
            'related_event_id' => $reg->event_id,
        ]);
        ChatRoom::firstOrCreate(
            ['registration_id' => $reg->id],
            [
                'event_id'     => $reg->event_id,
                'volunteer_id' => $reg->user_id,
                'organizer_id' => session('user_id'),
                'is_open'      => true,
            ]
        );

        return back()->with('success', 'Volunteer berhasil diterima.');
    }

    public function reject(Request $request, int $id)
    {
        $org = $this->getOrg();
        $reg = Registration::with('event')
            ->whereHas('event', fn($q) => $q->where('organization_profile_id', $org->id))
            ->findOrFail($id);

        $reg->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->reason,
        ]);
        $reg->event->decrement('registered_count');

        Notification::create([
            'user_id'          => $reg->user_id,
            'title'            => 'Pendaftaran Tidak Diterima',
            'message'          => "Maaf, pendaftaran kamu untuk '{$reg->event->title}' tidak dapat diterima.",
            'type'             => 'registration_rejected',
            'related_event_id' => $reg->event_id,
        ]);

        return back()->with('success', 'Volunteer berhasil ditolak.');
    }

    public function attend(int $id)
{
    $org = $this->getOrg();
    $reg = Registration::with('event')
        ->whereHas('event', fn($q) => $q->where('organization_profile_id', $org->id))
        ->findOrFail($id);

    if ($reg->status !== 'confirmed') {
        return back()->with('error', 'Hanya volunteer berstatus terdaftar yang bisa ditandai hadir.');
    }

    $reg->update([
        'status'      => 'attended',
        'attended_at' => now(),
    ]);

    Notification::create([
        'user_id'          => $reg->user_id,
        'title'            => 'Kehadiran Dikonfirmasi',
        'message'          => "Kehadiran kamu di '{$reg->event->title}' telah dikonfirmasi. Terima kasih sudah hadir!",
        'type'             => 'attendance_confirmed',
        'related_event_id' => $reg->event_id,
    ]);

    return back()->with('success', 'Volunteer berhasil ditandai hadir');
}
}
