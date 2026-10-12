<?php

namespace Tests\Feature;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BeneficiaryImportTest extends TestCase
{
    protected function getTenantUser(): ?User
    {
        return User::whereNotNull('tenant_id')->first();
    }

    public function test_user_can_download_beneficiaries_template(): void
    {
        $user = $this->getTenantUser();
        if (! $user) {
            $this->markTestSkipped('No tenant user available for test.');
        }

        $response = $this->actingAs($user)->get(route('beneficiaries.template'));

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('content-disposition', ''), 'attachment') ||
            str_contains($response->headers->get('content-type', ''), 'spreadsheet')
        );
    }

    public function test_user_can_import_beneficiaries_via_csv(): void
    {
        $user = $this->getTenantUser();
        if (! $user) {
            $this->markTestSkipped('No tenant user available for test.');
        }

        $tenantId = $user->tenant_id;
        $testNationalId = '1099887766';

        // Clean up if already exists
        Beneficiary::where('tenant_id', $tenantId)->where('national_id', $testNationalId)->delete();

        $headers = 'رقم الهوية,الاسم الأول,اسم الأب,اسم الجد,اسم العائلة,رقم الجوال,تاريخ الميلاد (هجري),الجنس,الحالة الاجتماعية,المدينة,الحي,عدد أفراد الأسرة,الدخل الشهري,الفئة,الحالة,ملاحظات';
        $row = "{$testNationalId},سالم,أحمد,علي,القحطاني,0551239876,1412-04-10,ذكر,متزوج,الرياض,الملقا,5,4000,أسر محدودة الدخل,نشط,تجربة استيراد";
        $csvContent = "\xEF\xBB\xBF".$headers."\n".$row;

        $file = UploadedFile::fake()->createWithContent('beneficiaries.csv', $csvContent);

        $response = $this->actingAs($user)->post(route('beneficiaries.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('beneficiaries.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('beneficiaries', [
            'tenant_id' => $tenantId,
            'national_id' => $testNationalId,
            'first_name' => 'سالم',
            'family_name' => 'القحطاني',
            'phone' => '0551239876',
        ]);
    }

    public function test_import_updates_existing_beneficiary_without_duplicate(): void
    {
        $user = $this->getTenantUser();
        if (! $user) {
            $this->markTestSkipped('No tenant user available for test.');
        }

        $tenantId = $user->tenant_id;
        $testNationalId = '1099887755';

        // Clean up
        Beneficiary::where('tenant_id', $tenantId)->where('national_id', $testNationalId)->delete();

        // Create existing beneficiary
        Beneficiary::create([
            'tenant_id' => $tenantId,
            'national_id' => $testNationalId,
            'first_name' => 'عبدالله',
            'family_name' => 'الغامدي',
            'phone' => '0501112233',
            'dob' => '1410-01-01',
            'gender' => 'male',
            'marital_status' => 'أعزب',
            'city' => 'جدة',
            'monthly_income' => 2000,
            'status' => 'active',
            'category' => 'low_income',
        ]);

        // Upload updated info
        $headers = 'رقم الهوية,الاسم الأول,اسم الأب,اسم الجد,اسم العائلة,رقم الجوال,تاريخ الميلاد (هجري),الجنس,الحالة الاجتماعية,المدينة,الحي,عدد أفراد الأسرة,الدخل الشهري,الفئة,الحالة,ملاحظات';
        $row = "{$testNationalId},عبدالله,محمد,علي,الغامدي,0509998877,1410-01-01,ذكر,متزوج,الرياض,الياسمين,3,5000,أسر محدودة الدخل,نشط,تحديث السجل";
        $csvContent = "\xEF\xBB\xBF".$headers."\n".$row;

        $file = UploadedFile::fake()->createWithContent('beneficiaries_update.csv', $csvContent);

        $response = $this->actingAs($user)->post(route('beneficiaries.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('beneficiaries.index'));

        // Verify it was updated, not duplicated
        $this->assertEquals(1, Beneficiary::where('tenant_id', $tenantId)->where('national_id', $testNationalId)->count());

        $beneficiary = Beneficiary::where('tenant_id', $tenantId)->where('national_id', $testNationalId)->first();
        $this->assertEquals('0509998877', $beneficiary->phone);
        $this->assertEquals('متزوج', $beneficiary->marital_status);
        $this->assertEquals('الرياض', $beneficiary->city);
        $this->assertEquals(5000, (float) $beneficiary->monthly_income);
    }

    public function test_import_validates_file_presence_and_extension(): void
    {
        $user = $this->getTenantUser();
        if (! $user) {
            $this->markTestSkipped('No tenant user available for test.');
        }

        // Without file
        $response = $this->actingAs($user)->post(route('beneficiaries.import'), []);
        $response->assertSessionHasErrors(['file']);

        // Invalid file format (e.g. .txt)
        $invalidFile = UploadedFile::fake()->create('test.txt', 10, 'text/plain');
        $response = $this->actingAs($user)->post(route('beneficiaries.import'), [
            'file' => $invalidFile,
        ]);
        $response->assertSessionHasErrors(['file']);
    }

    public function test_import_handles_arabic_variations_and_empty_family_name_gracefully(): void
    {
        $user = $this->getTenantUser();
        if (! $user) {
            $this->markTestSkipped('No tenant user available for test.');
        }

        $tenantId = $user->tenant_id;
        $testNationalId = '1052522599';

        // Clean up
        Beneficiary::where('tenant_id', $tenantId)->where('national_id', $testNationalId)->delete();

        // Testing:
        // - first_name: علي, father_name: محسن, grandfather_name: محمود, family_name: (empty)
        // - phone: 551234568 (no leading 0)
        // - marital_status: اعزب (no hamza)
        // - category: ايتام (no hamza)
        $headers = 'رقم الهوية,الاسم الأول,اسم الأب,اسم الجد,اسم العائلة,رقم الجوال,تاريخ الميلاد (هجري),الجنس,الحالة الاجتماعية,المدينة,الحي,عدد أفراد الأسرة,الدخل الشهري,الفئة,الحالة,ملاحظات';
        $row = "{$testNationalId},علي,محسن,محمود,,551234568,1415-05-12,ذكر,اعزب,جدة,تست,7,0,ايتام,نشط,";
        $csvContent = "\xEF\xBB\xBF".$headers."\n".$row;

        $file = UploadedFile::fake()->createWithContent('beneficiaries_arabic.csv', $csvContent);

        $response = $this->actingAs($user)->post(route('beneficiaries.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('beneficiaries.index'));

        $beneficiary = Beneficiary::where('tenant_id', $tenantId)->where('national_id', $testNationalId)->first();
        $this->assertNotNull($beneficiary);
        $this->assertEquals('علي', $beneficiary->first_name);
        $this->assertEquals('محسن', $beneficiary->father_name);
        $this->assertEquals('محمود', $beneficiary->grandfather_name);
        $this->assertNull($beneficiary->family_name);
        $this->assertEquals('علي محسن محمود', $beneficiary->name);
        $this->assertEquals('0551234568', $beneficiary->phone);
        $this->assertEquals('أعزب', $beneficiary->marital_status);
        $this->assertEquals('orphans', $beneficiary->category->value);
        $this->assertEquals('أيتام', $beneficiary->category->label());
    }
}
