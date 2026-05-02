<?php

namespace Tests\Feature;

use App\Filament\Widgets\RecentAnnouncements;
use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RecentAnnouncementsWidgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_recent_announcements_widget_shows_title_and_description(): void
    {
        Announcement::create([
            'title' => 'Public Hearing Schedule',
            'description' => 'The committee hearing will be held on Friday at 9:00 AM.',
            'published' => true,
            'is_archived' => false,
        ]);

        Livewire::test(RecentAnnouncements::class)
            ->assertSee('Recent Announcements')
            ->assertSee('Public Hearing Schedule')
            ->assertSee('The committee hearing will be held on Friday at 9:00 AM.');
    }
}
