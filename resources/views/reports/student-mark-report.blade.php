<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Mark Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
        }
        .report-title {
            font-size: 18px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        .student-info {
            margin-bottom: 30px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .student-info p {
            margin: 5px 0;
        }
        .student-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }
        .course-section {
            margin-bottom: 25px;
        }
        .course-title {
            font-size: 16px;
            font-weight: bold;
            background: #2c3e50;
            color: #fff;
            padding: 8px 15px;
            margin-bottom: 10px;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #555;
            font-size: 12px;
            text-uppercase;
        }
        .mark-badge {
            font-weight: bold;
            color: #3498db;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #bdc3c7;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($school->logo_url)
            <img src="{{ public_path('storage/' . $school->logo_url) }}" class="logo">
        @endif
        <h1 class="school-name">{{ $school->name }}</h1>
        <div class="report-title">Academic Achievement Report</div>
    </div>

    <div class="student-info">
        <p><strong>Student:</strong> <span class="student-name">{{ $student->name }} {{ $student->surname }}</span></p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Date Generated:</strong> {{ $generatedAt }}</p>
    </div>

    @forelse($marksBySubject as $courseId => $marks)
        <div class="course-section">
            <div class="course-title">{{ $marks->first()->course->name }}</div>
            <table>
                <thead>
                    <tr>
                        <th width="40%">Assessment</th>
                        <th width="15%">Mark</th>
                        <th width="15%">Max</th>
                        <th width="30%">Comments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marks as $mark)
                        <tr>
                            <td>{{ $mark->title }}</td>
                            <td class="mark-badge">{{ $mark->mark }}</td>
                            <td>{{ $mark->max_mark ?: '-' }}</td>
                            <td style="font-size: 11px; color: #666;">{{ $mark->comments ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align: center; color: #999; margin-top: 50px;">No marks recorded for this student.</p>
    @endforelse

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $school->name }}. This is an official electronic document.</p>
    </div>
</body>
</html>
