<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        /* Forces standard print drivers to map correctly to A4 landscape specs */
        @page {
            margin: 0;
            size: a4 landscape;
        }
        * {
            box-sizing: border-box;
        }
        /* Lock canvas bounds to prevent layout engines from stretching elements */
        html, body {
            margin: 0;
            padding: 0;
            width: 810pt;  
            /*height: 250pt; */
            background-color: #fff;
            /*overflow: hidden;*/
        }
        body {
            font-family: 'Times-Roman', 'serif';
        }
        /* Use fixed dimension subtraction rather than 100% to protect borders */
        .certificate-container {
            width: 800;
            height: 2pt;
            padding: 20pt; 
        }
        .main-border {
            border: 20pt solid #2c3e50;
            width: 740pt;  /* 842pt minus left/right 20pt container paddings */
            height: 490pt; /* 595pt minus top/bottom 20pt container paddings */
            padding: 10pt;
        }
        .inner-border {
            border: 4pt double #f1c40f;
            width: 670pt;  /* Subtract 20pt main border from each side */
            height: 440pt; /* Subtract 20pt main border from top and bottom */
            padding: 20pt 30pt;
            text-align: center;
            position: relative;
        }
        .logo {
            max-width: 90pt;
            margin-bottom: 5pt;
        }
        .school-name {
            font-size: 22pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5pt;
            text-transform: uppercase;
        }
        .title {
            font-size: 38pt;
            font-family: 'Times-BoldItalic', 'serif';
            color: #f1c40f;
            margin: 10pt 0;
        }
        .subtitle {
            font-size: 16pt;
            color: #333;
            margin-bottom: 5pt;
        }
        .student-name {
            font-size: 34pt;
            font-weight: bold;
            color: #2c3e50;
            margin: 5pt 0;
            border-bottom: 2pt solid #333;
            display: inline-block;
            padding: 0 40pt;
        }
        .description {
            font-size: 14pt;
            color: #555;
            margin: 10pt auto;
            max-width: 85%;
            line-height: 1.4;
        }
        .course-name {
            font-size: 18pt;
            font-weight: bold;
            color: #2c3e50;
        }
        /* Fix absolute elements tracking off canvas rules */
        .footer {
            position: absolute;
            bottom: 50pt;
            width: 702pt; /* Match the exact inner width of your inner border canvas */
            left: 0;
            display: table;
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
            font-size: 11pt;
            font-weight: bold;
        }
        .signature-title {
            font-size: 10pt;
            color: #444;
            margin-top: 2pt;
        }
        .meta-info {
            position: absolute;
            bottom: 5pt;
            left: 0;
            width: 702pt;
            text-align: center;
            font-size: 9pt;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="main-border">
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
                        <div class="signature-title">Date of Issue</div>
                    </div>
                    <div class="signature-block">
                        <!-- Space for physical signature -->
                    </div>
                    <div class="signature-block">
                        <div class="signature-line">{{ $certificate->issuer->name }} {{ $certificate->issuer->surname }}</div>
                        <div class="signature-title">Authorized Administrator</div>
                    </div>
                </div>
                
                <div class="meta-info">
                    Certificate Number: {{ $certificate->certificate_number }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
