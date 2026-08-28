<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Acceptance Letter</title>
    <style>
        body {
            font-family: Times, serif;
            max-width: 8.5in;
            margin: 0 auto;
            padding: 1in;
            line-height: 1.5;
            font-size: 12pt;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .underline {
            text-decoration: underline;
        }
        .header {
            margin-bottom: 2em;
        }
        .signature-section {
            margin-top: 3em;
        }
        p {
            margin: 1em 0;
            text-align: justify;
        }
        .company-details {
            margin: 1.5em 0;
        }
        .company-details div {
            margin: 0.5em 0;
        }
    </style>
</head>
<body>
    <div class="center header">
        <div class="bold">INTERNSHIP ACCEPTANCE LETTER</div>
    </div>

    <div style="margin-bottom: 2em;">
        <div class="bold">DINO L. ILUSTRISIMO,</div> MIT
        <div>Internship Coordinator</div>
        <div>BSIT Department</div>
        <div>Madridejos Community College</div>
        <div>Bunakan, Madridejos, Cebu</div>
    </div>

    <p>Sir:</p>

    <p>This letter notifies you of the acceptance of the application of your student named <span class="underline">{{ $intern->first_name }} {{ $intern->last_name }}</span> for his/her <span class="bold">Internship</span> with us starting on <span class="bold underline">{{ isset($startDate) ? $startDate->format('F j, Y') : now('Asia/Manila')->format('F j, Y') }}</span> to <span class="underline">{{ isset($endDate) ? $endDate->format('F j, Y') : now('Asia/Manila')->addHours(486)->format('F j, Y') }}</span> to completely accumulate a total of <span class="bold">486 hours</span> of relevant trainings.</p>

    <p>This letter does not guarantee his/her official Internship with us unless a <span class="bold">Memorandum of Agreement (MOA)</span> and other official documents are fully signed by you and our company/office.</p>

    <p>Below are the following details of our company for Memorandum of Agreement (MOA) and other official document purposes:</p>

    <div class="company-details">
        <div>Name of the Company : <span class="underline">{{ $intern->company_name ?: 'N/A' }}</span></div>
        <div>Business Address : <span class="underline">{{ $intern->company_address ?: 'N/A' }}</span></div>
        <div>Immediate Supervisor: <span class="underline">{{ $intern->supervisor_name ?: 'N/A' }}</span></div>
        <div>Contact Details : <span class="underline">{{ $intern->company_phone ?: 'N/A' }}</span></div>
    </div>

    <div class="signature-section">
        <p>Regards,</p>
        <div style="margin-top: 3em;">
            <div class="bold underline">{{ $intern->supervisor_name ?: 'Immediate Supervisor' }}</div>
            <div>Immediate Supervisor</div>
        </div>
    </div>
</body>
</html>