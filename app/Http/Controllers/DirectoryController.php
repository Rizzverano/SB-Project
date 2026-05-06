<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use App\Models\Sbmember;
use App\Models\CitizensCharter;
use App\Models\OrganizationalChart;

class DirectoryController extends Controller
{
    public function welcome()
    {
        $membersCount = Sbmember::where('is_publish', true)
            ->where('is_archived', false)
            ->count();

        return view('welcome', compact('membersCount'));
    }

    public function about()
    {
        $orgCharts = OrganizationalChart::where('is_publish', true)
                        ->where('is_archived', false)
                        ->latest()
                        ->get();

        return view('main.about', compact('orgCharts'));
    }

    public function contact()
    {
        return view('main.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
            'g-recaptcha-response' => 'required',
        ]);

        // ✅ VERIFY CAPTCHA
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (! $response->json('success')) {
            return back()->withErrors([
                'captcha' => 'Captcha verification failed. Please try again.',
            ])->withInput();
        }

        // ✅ SAVE MESSAGE
        $contactMessage = ContactMessage::create(
            $request->only(['name', 'email', 'phone', 'message'])
        );

        // ✅ NOTIFY ADMINS
        $admins = \App\Models\User::where('role', \App\Models\User::ADMIN)->get();

        foreach ($admins as $admin) {
            \Filament\Notifications\Notification::make()
                ->title('New Contact Message')
                ->body("New message from {$contactMessage->name}")
                ->icon('heroicon-o-envelope')
                ->sendToDatabase($admin);
        }

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function gallery()
    {
        return view('main.gallery');
    }

    public function legislativeProcess()
    {

        $charters = CitizensCharter::where('is_publish', true)
                    ->where('is_archived', false)
                    ->latest()
                    ->get(); // get ALL published

        return view('main.legislative-process', compact('charters'));
    }

    public function sbmember()
    {
        $members = Sbmember::where('is_publish', true)
            ->where('is_archived', false)
            ->latest()
            ->get();

        $formerMembers = Sbmember::where('is_archived', true)
            ->where('is_publish', true)
            ->latest()
            ->get();

        return view('main.sb-members', compact('members', 'formerMembers'));
    }
}
