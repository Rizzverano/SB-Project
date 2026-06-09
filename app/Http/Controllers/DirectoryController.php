<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Sbmember;
use App\Models\CitizensCharter;
use App\Models\OrganizationalChart;
use App\Models\Accomplishment;
use App\Models\Recognition;
use App\Models\SbTarget;
use App\Models\SbOutlook;
use App\Models\OfficialsImage;
use App\Models\SbsecImage;
use App\Models\SbsecTarget;
use App\Models\SbsecOutlook;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class DirectoryController extends Controller
{
    public function welcome()
    {
        $membersCount = Sbmember::where('is_publish', true)
            ->where('is_archived', false)
            ->count();

        $officialsImage = OfficialsImage::where('published', true)
            ->latest()
            ->first();

        $sbsecImage = SbsecImage::where('published', true)
            ->latest()
            ->first();

        return view('welcome', compact(
            'membersCount',
            'officialsImage',
            'sbsecImage'
        ));
    }

    public function about()
    {
        $orgCharts = OrganizationalChart::where('is_publish', true)
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
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[^<>{}|\[\]\\\\^`]*$/', // no HTML/special chars
                    'regex:/^(?!.*https?:\/\/)(?!.*www\.)(?!.*\.(com|net|org|io|php|html))/i', // no URLs
                ],
                'email' => ['required', 'email:rfc,dns', 'max:255', 'regex:/^\S*$/'],
                'phone' => ['nullable', 'string', 'max:20', 'regex:/^\S*$/', 'regex:/^(09|\+639)\d{9}$/'],
                'message' => [
                    'required',
                    'string',
                    'max:2000',
                    'regex:/^[^<>{}|\[\]\\\\^`]*$/', // no HTML/special chars
                    'regex:/^(?!.*https?:\/\/)(?!.*www\.)(?!.*\.(com|net|org|io|php|html))/i', // no URLs
                ],
                'g-recaptcha-response' => 'required',
            ],
            [
                'name.regex' => 'Full name must not contain URLs, links, or special characters.',
                'message.regex' => 'Message must not contain URLs, links, or special characters.',
                'g-recaptcha-response.required' => 'Please complete the captcha.',
            ],
        );

        // ✅ VERIFY CAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()
                ->withErrors([
                    'captcha' => 'Captcha verification failed. Please try again.',
                ])
                ->withInput();
        }

        // ✅ SAVE MESSAGE
        $contactMessage = ContactMessage::create(array_merge(
            $request->only(['name', 'phone', 'message']),
            [
                'email' => Str::lower(trim($request->input('email'))),
                'ip_address' => $request->ip(),
            ]
        ));

        // ✅ NOTIFY ADMINS
        if (! $contactMessage->is_spam) {
        $admins = \App\Models\User::where('role', \App\Models\User::ADMIN)->where('is_active', true)->get();

        $url = route('filament.admin.resources.contact-messages.index', ['record' => $contactMessage]);

        foreach ($admins as $admin) {
            Notification::make()
                ->title('New Contact Message')
                ->body("New message from {$contactMessage->name}")
                ->icon('heroicon-o-envelope')
                ->iconColor('warning')
                ->viewData([
                    'module' => 'Contact Message',
                    'url' => $url,
                ])
                ->actions([Action::make('view')->label('View message')->url($url)->markAsRead()])
                ->sendToDatabase($admin, isEventDispatched: true);
        }
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
            ->latest()
            ->get();

        return view('main.legislative-process', compact('charters'));
    }

    public function sbmember()
    {
        $members = Sbmember::where('is_publish', true)->where('is_archived', false)->latest()->get();

        $formerMembers = Sbmember::where('is_archived', true)->latest()->get();

        return view('main.sb-members', compact('members', 'formerMembers'));
    }

    public function sbinfo()
    {
        $officialsImage = OfficialsImage::where('published', true)
            ->latest()
            ->first();

        $accomplishments = Accomplishment::where('published', true)
            ->orderBy('committee_name')
            ->get()
            ->groupBy('committee_name');

        $recognitions = Recognition::where('published', true)
            ->latest()
            ->get();

        $targets = SbTarget::where('published', true)
            ->orderBy('title')
            ->get()
            ->groupBy('title');

        $outlooks = SbOutlook::where('published', true)
            ->get()
            ->groupBy('type');

        return view('main.sb-info', compact(
            'officialsImage',
            'accomplishments',
            'recognitions',
            'targets',
            'outlooks'
        ));
    }

    public function sbsec()
    {
        $sbsecImage = SbsecImage::where('published', true)
            ->latest()
            ->first();

        $targets = SbsecTarget::where('published', true)
            ->orderBy('title')
            ->get()
            ->groupBy('title');

        $outlooks = SbsecOutlook::where('published', true)
            ->get()
            ->groupBy('type');

        return view('main.sb-sec', compact(
            'sbsecImage',
            'targets',
            'outlooks'
        ));
    }
}
