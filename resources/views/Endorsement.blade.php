<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endorsement Letter - Madridejos Community College</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
        }
        
        .letterhead {
            text-align: center;
            margin-bottom: 15px;
        }

        .letterhead img {
            width: 110px;
            height: 110px;
            object-fit: contain;
            display: inline-block;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        
        .date {
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .recipient {
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .salutation {
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .content p {
            margin-bottom: 15px;
        }
        
        .intern-list {
            margin: 20px 0;
            padding-left: 20px;
        }
        
        .closing {
            margin-top: 30px;
            font-size: 14px;
        }
        
        .signature-section {
            margin-top: 40px;
        }
        
        .signature {
            margin-bottom: 30px;
        }
        
        .signature-name {
            font-weight: bold;
            margin-bottom: 2px;
            text-decoration: underline;
        }
        
        .signature-title {
            font-size: 12px;
        }
        
        .placeholder {
            background-color: #f0f0f0;
            padding: 5px;
            border: 1px dashed #ccc;
            display: inline-block;
            margin: 2px;
        }
        
        .training-hours {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <img src="{{ asset('images/intern-logo.svg') }}" alt="Department Logo" onerror="this.style.display='none'">
    </div>
    
    <div class="header">
        ENDORSEMENT LETTER
    </div>
    
    <div class="date">
        {{ isset($sentAt) ? \Carbon\Carbon::parse($sentAt)->format('F j, Y') : now()->format('F j, Y') }}
    </div>
    
    <div class="recipient">
        <div>{{ $supervisor_name ?? '(Manager/Supervisor Name)' }}</div><br>
        <div>{{ $supervisor_position ?? '(Position)' }}</div><br>
        <div>{{ $company_name ?? '(Company Name)' }}</div><br>
        <div>{{ $company_address ?? '(Company Address)' }}</div>
    </div>
    
    <div class="salutation">
        Sir:
    </div>
    
    <div class="content">
        <p>The Information Technology Department of Madridejos Community College promotes the success of students by providing them the opportunity to achieve competency in the core disciplines of Information Technology, and encouraging them to obtain practical experience through internship.</p>
        
        <p>In this regard, we are endorsing our students listed below who are 4<sup>th</sup> year Bachelor of Science in Information Technology students in our school as interns:</p>
        
        <div class="intern-list">
            @if(!empty($interns))
                @foreach($interns as $intern)
                    <div>{{ $intern }}</div>
                @endforeach
            @else
                <div class="placeholder">(Name of Intern/s)</div>
            @endif
        </div>
        
        <p>These students-interns are required to complete the minimum requirements of <span class="training-hours">540 training hours</span>. We believe that your company can assist these students to gain more knowledge and skills and optimize their potentials for their future work.</p>
        
        <p>We are looking forward to a fruitful relationship with you.</p>
    </div>
    
    <div class="closing">
        Thank you very much.
    </div>
    
    <div class="signature-section">
        <p>Respectfully yours,</p>
        
        <div class="signature">
            <div class="signature-name">DINO ILLUSTRISIMO, MIT</div>
            <div class="signature-title">BSIT Internship Coordinator</div>
        </div>
        
        <div class="signature">
            <div class="signature-name">DR. FLORIPIS A. MONTECILLO</div>
            <div class="signature-title">College President</div>
        </div>
    </div>
</body>
</html>