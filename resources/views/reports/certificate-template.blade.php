<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 842pt;
            height: 595pt;
            overflow: hidden;
            background-color: #fff;
        }
        body {
            font-family: 'Times-Roman', 'serif';
        }
        .certificate-container {
            position: absolute;
            top: 10pt;
            left: 10pt;
            width: 822pt;
            height: 575pt;
            padding: 30pt;
            border: 20pt solid #2c3e50;
        }
        .inner-border {
            border: 4pt double #f1c40f;
            height: 100%;
            width: 100%;
            padding: 30pt;
            text-align: center;
            position: relative;
        }
        .logo {
            max-width: 100pt;
            margin-bottom: 10pt;
        }
        .school-name {
            font-size: 24pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5pt;
            text-transform: uppercase;
        }
        .title {
            font-size: 44pt;
            font-family: 'Times-BoldItalic', 'serif';
            color: #f1c40f;
            margin: 15pt 0;
        }
        .subtitle {
            font-size: 18pt;
            color: #333;
            margin-bottom: 10pt;
        }
        .student-name {
            font-size: 38pt;
            font-weight: bold;
            color: #2c3e50;
            margin: 10pt 0;
            border-bottom: 2pt solid #333;
            display: inline-block;
            padding: 0 40pt;
        }
        .description {
            font-size: 16pt;
            color: #555;
            margin: 10pt auto;
            max-width: 85%;
            line-height: 1.4;
        }
        .course-name {
            font-size: 20pt;
            font-weight: bold;
            color: #2c3e50;
        }
        .footer {
            position: absolute;
            bottom: 40pt;
            width: 100%;
            left: 0;
            display: table;
            padding: 0 60pt;
        }
        .signature-block {
            display: table-cell;
            text-align: center;
            width: 33%;
            vertical-align: bottom;
        }
        .signature-line {
            border-top: 1pt solid #333;
            margin: 0 20pt;
            padding-top: 5pt;
            font-size: 12pt;
        }
        .meta-info {
            position: absolute;
            bottom: -15pt;
            left: 50%;
            transform: translateX(-50%);
            font-size: 9pt;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="inner-border">
            @if($school->logo_url)
                <img src="{{ public_path('storage/' . $school->logo_url) }}" class="logo">
            @endif
            
            <div class="school-name">{{ $school->name }}</div>
            
            <div class="title">{{ $certificate->title }}</div>
            
            <div class="subtitle">This is to certify that</div>
            
            <div class="student-name">{{ $student->name }} {{ $student->surname }}</div>
            
            <div class="description">
                {{ $certificate->description }}
                @if($certificate->course)
                    <div class="course-name" style="margin-top: 5pt;">{{ $certificate->course->name }}</div>
                @endif
            </div>
            
            <div class="footer">
                <div class="signature-block">
                    <div class="signature-line">{{ $certificate->issued_at->format('M d, Y') }}</div>
                    <div>Date of Issue</div>
                </div>
                <div class="signature-block">
                    <!-- Space for physical signature -->
                </div>
                <div class="signature-block">
                    <div class="signature-line">{{ $certificate->issuer->name }} {{ $certificate->issuer->surname }}</div>
                    <div>Authorized Administrator</div>
                </div>
            </div>
            
            <div class="meta-info">
                Certificate Number: {{ $certificate->certificate_number }}
            </div>
        </div>
    </div>
</body>
</html>