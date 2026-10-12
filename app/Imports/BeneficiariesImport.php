<?php

namespace App\Imports;

use App\Enums\BeneficiaryCategory;
use App\Enums\BeneficiaryStatus;
use App\Enums\Gender;
use App\Models\Beneficiary;
use App\Models\Tenant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class BeneficiariesImport implements ToCollection, WithHeadingRow
{
    public int $importedCount = 0;

    public int $updatedCount = 0;

    public int $skippedCount = 0;

    public array $errors = [];

    public function __construct(protected ?Tenant $tenant = null)
    {
        HeadingRowFormatter::default('none');
        $this->tenant = $tenant ?? auth()->user()?->tenant;
    }

    public function collection(Collection $rows): void
    {
        if (! $this->tenant) {
            $this->errors[] = 'لا يمكن إتمام الاستيراد لعدم وجود جمعية تابعة للمستخدم.';

            return;
        }

        $subscription = $this->tenant->subscription;
        $maxBeneficiaries = $subscription?->max_beneficiaries ?? -1;

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // Accounting for 1-based index and header row

            // Normalize row keys and extract values
            $data = $this->extractRowData($row->toArray());

            if (empty($data['national_id'])) {
                continue; // Skip empty rows
            }

            // Validate National ID (10 digits starting with 1 or 2)
            $nationalId = preg_replace('/[^\d]/', '', $this->convertArabicDigits((string) $data['national_id']));
            if (strlen($nationalId) !== 10 || ! in_array($nationalId[0], ['1', '2'])) {
                $this->errors[] = "السطر {$rowNumber}: رقم الهوية ({$data['national_id']}) غير صالح (يجب أن يتكون من 10 أرقام ويبدأ بـ 1 أو 2).";
                $this->skippedCount++;

                continue;
            }

            // Check subscription limits for new records
            $existing = Beneficiary::where('tenant_id', $this->tenant->id)
                ->where('national_id', $nationalId)
                ->first();

            if (! $existing && $maxBeneficiaries !== -1) {
                $currentCount = Beneficiary::where('tenant_id', $this->tenant->id)->count();
                if ($currentCount >= $maxBeneficiaries) {
                    $this->errors[] = "توقف الاستيراد عند السطر {$rowNumber}: تم الوصول إلى الحد الأقصى للباقة ({$maxBeneficiaries} مستفيد). يرجى ترقية الباقة لإضافة المزيد.";
                    break;
                }
            }

            // Resolve name parts
            $names = $this->resolveNames($data);

            // Resolve phone
            $phone = $this->normalizePhone($data['phone'] ?? '');

            // Resolve dates
            $dob = $this->normalizeDate($data['dob'] ?? '1415-01-01');

            // Resolve gender
            $gender = $this->normalizeGender($data['gender'] ?? 'male');

            // Resolve marital status
            $maritalStatus = $this->normalizeMaritalStatus($data['marital_status'] ?? 'متزوج');

            // Resolve category
            $category = $this->normalizeCategory($data['category'] ?? 'low_income');

            // Resolve status
            $status = $this->normalizeStatus($data['status'] ?? 'active');

            // Resolve family members & income
            $familyMembersRaw = $this->convertArabicDigits((string) ($data['family_members'] ?? '1'));
            $familyMembers = max(1, (int) preg_replace('/[^\d]/', '', $familyMembersRaw) ?: 1);

            $incomeRaw = $this->convertArabicDigits((string) ($data['monthly_income'] ?? '0'));
            $monthlyIncome = max(0, (float) preg_replace('/[^\d.]/', '', $incomeRaw) ?: 0);

            $beneficiaryData = [
                'tenant_id' => $this->tenant->id,
                'national_id' => $nationalId,
                'first_name' => $names['first_name'],
                'father_name' => $names['father_name'],
                'grandfather_name' => $names['grandfather_name'],
                'family_name' => $names['family_name'],
                'phone' => $phone,
                'dob' => $dob,
                'gender' => $gender,
                'marital_status' => $maritalStatus,
                'city' => ! empty($data['city']) ? trim((string) $data['city']) : ($this->tenant->city ?? 'الرياض'),
                'neighborhood' => ! empty($data['neighborhood']) ? trim((string) $data['neighborhood']) : null,
                'family_members' => $familyMembers,
                'monthly_income' => $monthlyIncome,
                'category' => $category,
                'status' => $status,
                'notes' => ! empty($data['notes']) ? trim((string) $data['notes']) : null,
            ];

            if ($existing) {
                $existing->update($beneficiaryData);
                $this->updatedCount++;
            } else {
                Beneficiary::create($beneficiaryData);
                $this->importedCount++;
            }
        }
    }

    protected function extractRowData(array $row): array
    {
        $normalizedRow = [];
        foreach ($row as $k => $v) {
            $normalizedRow[trim((string) $k)] = $v;
        }

        $get = function (array $keys) use ($normalizedRow) {
            foreach ($keys as $key) {
                if (isset($normalizedRow[$key]) && trim((string) $normalizedRow[$key]) !== '') {
                    return trim((string) $normalizedRow[$key]);
                }
            }

            return null;
        };

        return [
            'national_id' => $get(['رقم الهوية', 'الهوية', 'السجل المدني', 'national_id', 'id_number']),
            'full_name' => $get(['الاسم الكامل', 'الاسم', 'اسم المستفيد', 'full_name', 'name']),
            'first_name' => $get(['الاسم الأول', 'first_name']),
            'father_name' => $get(['اسم الأب', 'father_name']),
            'grandfather_name' => $get(['اسم الجد', 'grandfather_name']),
            'family_name' => $get(['اسم العائلة', 'اللقب', 'العائلة', 'family_name', 'last_name']),
            'phone' => $get(['رقم الجوال', 'الجوال', 'الهاتف', 'phone', 'mobile']),
            'dob' => $get(['تاريخ الميلاد (هجري)', 'تاريخ الميلاد', 'dob', 'birth_date']),
            'gender' => $get(['الجنس', 'gender']),
            'marital_status' => $get(['الحالة الاجتماعية', 'marital_status']),
            'city' => $get(['المدينة', 'city']),
            'neighborhood' => $get(['الحي', 'neighborhood']),
            'family_members' => $get(['عدد أفراد الأسرة', 'أفراد الأسرة', 'family_members']),
            'monthly_income' => $get(['الدخل الشهري', 'الدخل', 'monthly_income', 'income']),
            'category' => $get(['الفئة', 'نوع الحالة', 'category']),
            'status' => $get(['الحالة', 'status']),
            'notes' => $get(['ملاحظات', 'الملاحظات', 'notes']),
        ];
    }

    protected function resolveNames(array $data): array
    {
        $firstName = ! empty($data['first_name']) ? trim((string) $data['first_name']) : null;
        $fatherName = ! empty($data['father_name']) ? trim((string) $data['father_name']) : null;
        $grandfatherName = ! empty($data['grandfather_name']) ? trim((string) $data['grandfather_name']) : null;
        $familyName = ! empty($data['family_name']) ? trim((string) $data['family_name']) : null;

        // If individual columns were used (at least one of father, grandfather, family is present, OR first_name is non-empty):
        if ($fatherName !== null || $grandfatherName !== null || $familyName !== null) {
            return [
                'first_name' => $firstName ?? 'مستفيد جديد',
                'father_name' => $fatherName,
                'grandfather_name' => $grandfatherName,
                'family_name' => $familyName,
            ];
        }

        // If only full_name or compound first_name is provided
        $nameToSplit = ! empty($data['full_name'])
            ? trim((string) $data['full_name'])
            : ($firstName ?? 'مستفيد جديد');

        $parts = preg_split('/\s+/u', $nameToSplit, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if (count($parts) <= 1) {
            return [
                'first_name' => $parts[0] ?? 'مستفيد جديد',
                'father_name' => null,
                'grandfather_name' => null,
                'family_name' => null,
            ];
        }

        if (count($parts) === 2) {
            return [
                'first_name' => $parts[0],
                'father_name' => null,
                'grandfather_name' => null,
                'family_name' => $parts[1],
            ];
        }

        if (count($parts) === 3) {
            return [
                'first_name' => $parts[0],
                'father_name' => $parts[1],
                'grandfather_name' => null,
                'family_name' => $parts[2],
            ];
        }

        return [
            'first_name' => $parts[0],
            'father_name' => $parts[1],
            'grandfather_name' => $parts[2],
            'family_name' => implode(' ', array_slice($parts, 3)),
        ];
    }

    protected function convertArabicDigits(string $str): string
    {
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($eastern, $western, $str);
    }

    protected function normalizeArabicText(?string $text): string
    {
        if ($text === null) {
            return '';
        }

        $text = trim($text);

        // Remove Arabic diacritics / tashkeel (Fatha, Damma, Kasra, Sukun, Tanween, Shadda, etc.)
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $text);

        // Normalize Alef variants: أ, إ, آ, ٱ -> ا
        $text = preg_replace('/[أإآٱ]/u', 'ا', $text);

        // Normalize Taa Marbuta: ة -> ه
        $text = preg_replace('/ة/u', 'ه', $text);

        // Normalize Alef Maqsura: ى -> ي
        $text = preg_replace('/ى/u', 'ي', $text);

        // Lowercase for any Latin characters
        $text = mb_strtolower($text, 'UTF-8');

        // Collapse multiple spaces
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    protected function normalizePhone(?string $phone): string
    {
        $clean = preg_replace('/[^\d]/', '', $this->convertArabicDigits((string) $phone));

        if (str_starts_with($clean, '966')) {
            $clean = substr($clean, 3);
        }

        if (! str_starts_with($clean, '0') && str_starts_with($clean, '5')) {
            $clean = '0'.$clean;
        }

        if (strlen($clean) === 10 && str_starts_with($clean, '05')) {
            return $clean;
        }

        return $clean ?: '0500000000';
    }

    protected function normalizeDate(?string $dob): string
    {
        if (empty($dob)) {
            return '1415-01-01';
        }

        $dob = $this->convertArabicDigits(trim((string) $dob));
        $dob = str_replace('/', '-', $dob);

        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dob)) {
            $parts = explode('-', $dob);

            return sprintf('%04d-%02d-%02d', (int) $parts[0], (int) $parts[1], (int) $parts[2]);
        }

        return '1415-01-01';
    }

    protected function normalizeGender(?string $gender): string
    {
        $normalized = $this->normalizeArabicText($gender);

        if (str_contains($normalized, 'انث') || str_contains($normalized, 'بنت') || str_contains($normalized, 'سيد') || str_contains($normalized, 'female') || str_contains($normalized, 'woman')) {
            return Gender::Female->value;
        }

        return Gender::Male->value;
    }

    protected function normalizeMaritalStatus(?string $status): string
    {
        $normalized = $this->normalizeArabicText($status);

        if (str_contains($normalized, 'عزب') || str_contains($normalized, 'single')) {
            return 'أعزب';
        }

        if (str_contains($normalized, 'تزوج') || str_contains($normalized, 'married')) {
            return 'متزوج';
        }

        if (str_contains($normalized, 'مطلق') || str_contains($normalized, 'divorc')) {
            return 'مطلق';
        }

        if (str_contains($normalized, 'ارمل') || str_contains($normalized, 'widow')) {
            return 'أرمل';
        }

        return ! empty($status) ? trim((string) $status) : 'متزوج';
    }

    protected function normalizeCategory(?string $category): string
    {
        $normalized = $this->normalizeArabicText($category);

        if (str_contains($normalized, 'يتيم') || str_contains($normalized, 'ايتام') || str_contains($normalized, 'orphan')) {
            return BeneficiaryCategory::Orphans->value;
        }

        if (str_contains($normalized, 'ارامل') || str_contains($normalized, 'ارمل') || str_contains($normalized, 'مطلق') || str_contains($normalized, 'widow')) {
            return BeneficiaryCategory::Widows->value;
        }

        if (str_contains($normalized, 'اعاق') || str_contains($normalized, 'معاق') || str_contains($normalized, 'احتياج') || str_contains($normalized, 'disabled')) {
            return BeneficiaryCategory::PeopleWithDisabilities->value;
        }

        if (str_contains($normalized, 'مسن') || str_contains($normalized, 'كبار') || str_contains($normalized, 'عجز') || str_contains($normalized, 'elderly') || str_contains($normalized, 'senior')) {
            return BeneficiaryCategory::Elderly->value;
        }

        if (str_contains($normalized, 'طالب') || str_contains($normalized, 'طلاب') || str_contains($normalized, 'علم') || str_contains($normalized, 'student')) {
            return BeneficiaryCategory::Students->value;
        }

        return BeneficiaryCategory::LowIncomeFamilies->value;
    }

    protected function normalizeStatus(?string $status): string
    {
        $normalized = $this->normalizeArabicText($status);

        if (str_contains($normalized, 'دراس') || str_contains($normalized, 'مراجع') || str_contains($normalized, 'review')) {
            return BeneficiaryStatus::UnderReview->value;
        }

        if (str_contains($normalized, 'موقوف') || str_contains($normalized, 'غير نشط') || str_contains($normalized, 'معلق') || str_contains($normalized, 'inactive')) {
            return BeneficiaryStatus::Inactive->value;
        }

        return BeneficiaryStatus::Active->value;
    }
}
