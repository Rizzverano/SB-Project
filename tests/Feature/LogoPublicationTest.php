<?php

namespace Tests\Feature;

use App\Models\Logo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoPublicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_publish_as_active_unpublishes_other_logo_sets(): void
    {
        $firstLogoSet = Logo::create([
            'pres_gov' => 'logos/first-pres-gov.png',
            'lgu_hilongos' => 'logos/first-lgu.png',
            'is_published' => true,
        ]);

        $secondLogoSet = Logo::create([
            'pres_gov' => 'logos/second-pres-gov.png',
            'lgu_hilongos' => 'logos/second-lgu.png',
            'is_published' => false,
        ]);

        $secondLogoSet->publishAsActive();

        $this->assertFalse($firstLogoSet->fresh()->is_published);
        $this->assertTrue($secondLogoSet->fresh()->is_published);
    }
}
