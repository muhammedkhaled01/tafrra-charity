<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SubscriptionFeatureAccessTest extends TestCase
{
    public function test_tenant_cannot_access_unsubscribed_feature_routes(): void
    {
        $tenantUser = User::find(6); // جمعية العيش الشامي (subscribed to Basic Plan)

        if (! $tenantUser) {
            $this->markTestSkipped('Tenant user not found in database.');
        }

        // Beneficiaries is included in Basic Plan
        $this->actingAs($tenantUser)
            ->get(route('beneficiaries.index'))
            ->assertStatus(200);

        // Donors is NOT included in Basic Plan -> should redirect to dashboard with error
        $this->actingAs($tenantUser)
            ->get(route('donors.index'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');

        // Projects is NOT included in Basic Plan -> should redirect to dashboard with error
        $this->actingAs($tenantUser)
            ->get(route('projects.index'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');

        // Sponsorships is NOT included in Basic Plan -> should redirect to dashboard with error
        $this->actingAs($tenantUser)
            ->get(route('sponsorships.index'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');

        // Transactions is NOT included in Basic Plan -> should redirect to dashboard with error
        $this->actingAs($tenantUser)
            ->get(route('transactions.index'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');
    }

    public function test_sidebar_does_not_render_unsubscribed_features(): void
    {
        $tenantUser = User::find(6); // جمعية العيش الشامي

        if (! $tenantUser) {
            $this->markTestSkipped('Tenant user not found in database.');
        }

        $response = $this->actingAs($tenantUser)->get(route('dashboard'));
        $response->assertStatus(200);

        // Beneficiaries is allowed
        $response->assertSee(route('beneficiaries.index'));
        $response->assertSee('المستفيدين');

        // Documents is allowed
        $response->assertSee(route('documents.index'));
        $response->assertSee('الخطابات والعقود');

        // Donors, Sponsorships, Transactions, Projects are not allowed
        $response->assertDontSee(route('donors.index'));
        $response->assertDontSee('الداعمين والكفلاء');
        $response->assertDontSee(route('sponsorships.index'));
        $response->assertDontSee('إدارة الكفالات');
        $response->assertDontSee(route('transactions.index'));
        $response->assertDontSee('سندات القبض والصرف');
        $response->assertDontSee(route('projects.index'));
        $response->assertDontSee('المشاريع');
    }
}
