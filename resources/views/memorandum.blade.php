<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorandum of Agreement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .document {
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .underline {
            text-decoration: underline;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        ol {
            padding-left: 30px;
        }
        li {
            margin-bottom: 8px;
        }
        .moa-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .moa-parties {
            margin-bottom: 30px;
        }
        .acknowledgment {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="document">
        <div class="moa-header">
            <p>Republic of the Philippines<br>
            Province of Cebu<br>
            Municipality of Madridejos</p>
            
            <h1>MEMORANDUM OF AGREEMENT</h1>
        </div>

        <p>This Memorandum of Agreement made and executed between:</p>

        <div class="moa-parties">
            <p><strong>MADRIDEJOS COMMUNITY COLLEGE</strong>, a local higher educational institution, duly recognized and existing under Philippine Laws with office/business address at Crossing Bunakan, Madridejos, Cebu, <strong>DR. FLORIPIS A. MONTECILLO</strong>, President, hereinafter referred to as the <strong>COLLEGE.</strong></p>

            <p>And</p>

            <p><strong><span class="underline">{{ $intern->company_name ?: 'Company Name' }}</span></strong>, a company duly organized and existing under Philippine Laws with the office/business address at <span class="underline">{{ $intern->company_address ?: 'Company Address' }}</span>, represented herein by <strong>{{ $intern->supervisor_name ?: 'Company Representative' }}</strong>, {{ $intern->supervisor_position ?: 'Position' }} hereinafter referred to as <strong>COMPANY</strong>.</p>
        </div>

        <p><strong>WITNESSETH:</strong></p>

        <p>The parties hereby bind themselves to undertake a Memorandum of Agreement for the purpose of supporting the COLLEGE On-the-Job Training (OJT) for the student-trainees under the following terms and conditions:</p>

        <ol>
            <li>The COLLEGE shall be responsible for briefing the On-the-Job Student-Trainees who intend to conduct practicum exposure in the COMPANY as part of the COLLEGE's curriculum;</li>
            <li>The COLLEGE shall provide the On-the-Job Student-Trainee the basic orientation on work values, behavior, and discipline to ensure smooth cooperation;</li>
            <li>The COLLEGE shall issue an official endorsement vouching for the well-being of the On-the-Job Student-Trainee which shall be used by the COMPANY for processing the application of the Student-Trainee;</li>
            <li>The COLLEGE shall voluntarily withdraw a Student-Trainee who is found to misbehave and/or act in defiance to existing standards, rules and regulations of the COMPANY and impose necessary COLLEGE sanctions to the said Student-Trainee;</li>
            <li>The COMPANY may grant allowance and/or adequate insurance to Student-Trainee in accordance with the COMPANY's existing rules and regulations;</li>
            <li>The COMPANY, upon consultation with the COLLEGE, may require qualified students to submit themselves to examinations, interviews, and file pertinent documents to support their application;</li>
            <li>The COMPANY is not obliged to employ the Student-Trainee upon completion of the training;</li>
            <li>The Student-Trainee shall be personally responsible for any and all liabilities arising from negligence in the performance of his/her duties and functions while under training;</li>
            <li>There is no employer-employee relationship between the COMPANY and the Student-Trainee;</li>
            <li>The duration of the program shall be equivalent to five hundred forty (540) working hours unless otherwise agreed upon by the COMPANY and the COLLEGE;</li>
            <li>Any violation of the foregoing covenants will warrant the cancellation of the Memorandum of Agreement by the COMPANY within thirty (30) days upon notice to the COLLEGE;</li>
            <li>This Memorandum of Agreement shall become effective upon signature of both parties and implementation will begin immediately and shall continue to be valid hereafter until written notice is given by either party thirty (30) days prior to the date of intended termination.</li>
        </ol>

        <blockquote>
            <p>In witness whereof the parties have signed this Memorandum of Agreement at _______________________________ this {{ isset($today) ? $today->format('jS') : now('Asia/Manila')->format('jS') }} day of {{ isset($today) ? $today->format('F, Y') : now('Asia/Manila')->format('F, Y') }}.</p>
        </blockquote>

        <div class="signature-section">
            <div class="signature-box">
                <p><strong>For the COMPANY</strong></p>
                <br><br>
                <p><strong><span class="underline">{{ $intern->supervisor_name ?: 'Company Representative' }}</span></strong><br>
                {{ $intern->supervisor_position ?: 'Position' }}</p>
                <br>
                <p>Community Tax No.: _____________<br>
                Date of Issue: __________________<br>
                Place of Issue: _________________</p>
            </div>
            
            <div class="signature-box">
                <p><strong>For the SCHOOL</strong></p>
                <br><br>
                <p><strong><span class="underline">DR. FLORIPIS A. MONTECILLO</span></strong><br>
                School President</p>
                <br>
                <p>Community Tax No.: _____________<br>
                Date of Issue: __________________<br>
                Place of Issue: _________________</p>
            </div>
        </div>

        <p><strong>SIGNED IN THE PRESENCE OF:</strong></p>

        <div class="signature-section">
            <div class="signature-box">
                <p><span class="underline">(Company Manager/Supervisor/Representative)</span></p>
            </div>
            <div class="signature-box">
                <p><strong><span class="underline">JOSE D. GILA</span></strong><br>
                Representative of the Company Director of Student Affairs</p>
            </div>
        </div>

        <div class="acknowledgment">
            <h2>ACKNOWLEDGMENT</h2>
            
            <p>Before me, a Notary Public in the Province of Cebu, personally appeared ________________ and ________________ with IDs Number indicated above, known to me to be the same persons who executed the foregoing instrument and they acknowledged to me that the same is their free will and voluntary deed and that of the institutions herein represented.</p>

            <p>Witness my hand and seal on this ____ day of ________________, 2024 at Madridejos, Cebu.</p>

            <p>Doc. No _______:<br>
            Page No _______:<br>
            Book No _______:<br>
            Series of ________:</p>
        </div>
    </div>
</body>
</html>