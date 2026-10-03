<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير المستفيدين</title>
    <style>
        body {
            font-family: 'cairo', 'tajawal', sans-serif;
            text-align: right;
            direction: rtl;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #006C35;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            max-height: 100px;
        }
        .title {
            color: #006C35;
            font-size: 24px;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f2f2f2;
            color: #006C35;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($tenant && $tenant->logo)
            <img src="{{ public_path('storage/' . $tenant->logo) }}" class="logo" alt="Charity Logo">
        @elseif($tenant)
            <h2>{{ $tenant->name }}</h2>
        @endif
        <div class="title">تقرير المستفيدين - Beneficiaries Report</div>
        <div>التاريخ: {{ $date }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>الهوية الوطنية</th>
                <th>الاسم</th>
                <th>رقم الجوال</th>
                <th>العمر</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiaries as $beneficiary)
                <tr>
                    <td>{{ $beneficiary->national_id }}</td>
                    <td>{{ $beneficiary->name }}</td>
                    <td><span dir="ltr">{{ $beneficiary->phone }}</span></td>
                    <td>{{ $beneficiary->age }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
