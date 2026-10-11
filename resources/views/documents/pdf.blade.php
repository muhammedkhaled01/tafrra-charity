<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $document->title }}</title>
    <style>
        body {
            font-family: 'xbriyaz', 'sans-serif';
            font-size: 14pt;
            line-height: 1.6;
            color: #000;
        }
        
        /* Header Layout */
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .header-right {
            width: 35%;
            text-align: right;
            vertical-align: top;
            line-height: 1.4;
        }
        .header-center {
            width: 30%;
            text-align: center;
            vertical-align: top;
        }
        .header-left {
            width: 35%;
            text-align: right;
            vertical-align: top;
            font-size: 11pt;
            line-height: 1.8;
        }
        
        .header-right p {
            margin: 2px 0;
            font-weight: bold;
        }
        
        .logo {
            max-width: 120px;
            max-height: 100px;
        }
        
        .document-title {
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 30px 0 20px;
        }
        
        /* Content */
        .content {
            min-height: 500px;
            text-align: justify;
        }
        
        /* Footer / Signatures */
        .signatures-area {
            margin-top: 40px;
            width: 100%;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>
<body>
    
    <div style="text-align: center; font-weight: bold; font-size: 16pt; margin-bottom: 15px;">بسم الله الرحمن الرحيم</div>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <!-- Right Text -->
            <td class="header-right">
                <p>المملكة العربية السعودية</p>
                <p>{{ $tenant->name }}</p>
                @if($tenant->license_number)
                    <p>رقم الترخيص / {{ $tenant->license_number }}</p>
                @endif
                <p style="font-size: 10pt; font-weight: normal;">تحت إشراف المركز الوطني لتنمية القطاع غير الربحي</p>
            </td>
            
            <!-- Center Logo -->
            <td class="header-center">
                @if($tenant->logo)
                    <img src="{{ storage_path('app/public/' . $tenant->logo) }}" class="logo" alt="شعار الجمعية">
                @endif
            </td>
            
            <!-- Metadata (Left) -->
            <td class="header-left">
                <div><span style="display:inline-block; width:70px; font-weight:bold;">الرقم</span>: <span dir="auto">{{ $document->reference_number ?? '................' }}</span></div>
                <div><span style="display:inline-block; width:70px; font-weight:bold;">التاريخ</span>: <span dir="auto">{{ $document->document_date ? $document->document_date->format('Y/m/d') : '................' }}</span></div>
                <div><span style="display:inline-block; width:70px; font-weight:bold;">المشفوعات</span>: <span dir="auto">{{ $document->attachments_text ?? '................' }}</span></div>
                <div><span style="display:inline-block; width:70px; font-weight:bold;">الموضوع</span>: <span dir="auto">{{ $document->subject ?? '................' }}</span></div>
            </td>
        </tr>
    </table>

    <!-- Title -->
    <div class="document-title">
        {{ $document->title }}
    </div>

    <!-- Body Content -->
    <div class="content">
        {!! $document->content !!}
    </div>

    <!-- Signatures -->
    @php
        $selectedSigs = $document->signatures ?? [];
        $activeSignatures = [];
        if (is_array($tenant->signatures)) {
            foreach ($tenant->signatures as $index => $sig) {
                if (in_array((string)$index, $selectedSigs)) {
                    $activeSignatures[] = $sig;
                }
            }
        }
    @endphp

    @if(count($activeSignatures) > 0)
        <table class="signatures-area">
            <tr>
                @if(count($activeSignatures) == 1)
                    <!-- Empty space on the right so the signature goes to the left -->
                    <td style="width: 65%;"></td>
                @endif
                
                @foreach($activeSignatures as $sig)
                    <td class="signature-box" style="width: {{ count($activeSignatures) == 1 ? '35%' : (100 / count($activeSignatures)) . '%' }};">
                        <div style="font-size: 14pt; font-weight: bold; margin-bottom: 5px;">{{ $sig['title'] }}</div>
                        <div style="font-size: 14pt; font-weight: bold; margin-bottom: 5px;">{{ $sig['name'] }}</div>
                        
                        @if(isset($sig['image']) && $sig['image'])
                            <div style="height: 90px; margin: 5px 0;">
                                <img src="{{ storage_path('app/public/' . $sig['image']) }}" style="max-height: 90px; max-width: 200px;">
                            </div>
                        @else
                            <div style="height: 100px;"></div>
                        @endif
                        
                        <!-- Put the stamp under the signature -->
                        @if($loop->last && $tenant->stamp)
                            <div style="margin-top: 10px;">
                                <img src="{{ storage_path('app/public/' . $tenant->stamp) }}" style="max-height: 120px; opacity: 0.9;" alt="الختم الرسمي">
                            </div>
                        @endif
                    </td>
                @endforeach
            </tr>
        </table>
    @elseif($tenant->stamp)
        <!-- If there are no signatures but there is a stamp -->
        <table class="signatures-area">
            <tr>
                <td style="width: 65%;"></td>
                <td style="width: 35%; text-align: center; vertical-align: top;">
                    <div style="margin-top: 10px;">
                        <img src="{{ storage_path('app/public/' . $tenant->stamp) }}" style="max-height: 120px; opacity: 0.9;" alt="الختم الرسمي">
                    </div>
                </td>
            </tr>
        </table>
    @endif

</body>
</html>
