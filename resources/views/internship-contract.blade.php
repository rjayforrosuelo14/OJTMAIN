<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Contract</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            max-width: 850px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #ffffff;
            color: #333;
            text-align: justify;
        }
        .document {
            background-color: white;
            padding: 40px;
            border: 2px solid #2c3e50;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
        }
        .main-title {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #34495e;
            padding-bottom: 8px;
            margin-top: 30px;
            margin-bottom: 15px;
            letter-spacing: 1px;
            text-align: left;
        }
        .underline {
            border-bottom: 1px solid #333;
            display: inline-block;
            min-width: 150px;
            padding-bottom: 2px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            border: 2px solid #2c3e50;
        }
        .signature-table td {
            border: 1px solid #2c3e50;
            padding: 25px;
            vertical-align: top;
            width: 50%;
            text-align: justify;
        }
        .signature-table .signature-header {
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            background-color: #ecf0f1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        ol, ul {
            padding-left: 25px;
        }
        li {
            margin-bottom: 10px;
            text-align: justify;
        }
        ol li {
            margin-bottom: 8px;
            text-align: justify;
        }
        p {
            text-align: justify;
            margin-bottom: 12px;
        }
        .parties-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
            text-align: justify;
        }
        .definition {
            font-style: italic;
            font-weight: bold;
        }
        .fill-blank {
            border-bottom: 1px solid #333;
            display: inline-block;
            min-width: 200px;
            height: 20px;
            margin: 0 5px;
        }
        blockquote {
            margin-left: 40px;
            font-style: italic;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-left: 3px solid #3498db;
            text-align: justify;
        }
        blockquote p {
            text-align: justify;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Ensure all text elements are justified */
        * {
            text-align: justify;
        }
        /* Override for elements that should maintain specific alignment */
        .header *, .main-title {
            text-align: center !important;
        }
        h1 {
            text-align: left !important;
        }
        .signature-header {
            text-align: center !important;
        }
        /* Note section at bottom */
        .note-section {
            margin-top: 30px; 
            padding: 15px; 
            background-color: #f8f9fa; 
            border: 1px solid #dee2e6; 
            border-radius: 4px;
            text-align: justify;
        }
        .note-section p {
            margin: 0; 
            font-size: 12px; 
            color: #6c757d; 
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="document">
        <div class="header">
            <h1 class="main-title">Internship Agreement Contract</h1>
        </div>

        <h1>Parties</h1>
        <p>This Internship Agreement (hereinafter referred to as the <span class="definition">"Agreement"</span>) is entered into on</p>
        
        <blockquote>
            <p><span class="underline">Internship Agreement Contract</span> (the <span class="definition">"Effective Date"</span>), by and between <span class="underline">{{ isset($startDate) ? $startDate->format('F j, Y') : now('Asia/Manila')->format('F j, Y') }}</span>, with an address of <span class="underline">{{ $intern->company_address ?: 'N/A' }}</span>, (hereinafter referred to as the <span class="definition">"Company"</span>) and</p>
        </blockquote>
        
        <p><span class="underline">{{ $intern->company_name ?: 'Company Name' }}</span>, with an address of <span class="underline">{{ $intern->company_address ?: 'Company Address' }}</span>, (hereinafter referred to as the</p>
        
        <blockquote>
            <p><span class="definition">"Intern"</span>) (collectively referred to as the <span class="definition">"Parties"</span>).</p>
        </blockquote>

        <h1>Duties and Responsibilities</h1>
        <p>During the internship period, the Intern shall have the responsibility of performing the following duties:</p>
        <ol>
            <li>Assist in day-to-day operations of the department by performing clerical or technical tasks as assigned.</li>
            <li>Conduct research and gather information needed for reports, projects, or presentations.</li>
            <li>Prepare, organize, and maintain documents or records related to the internship program.</li>
            <li>Support staff members in projects and activities, ensuring deadlines and instructions are followed.</li>
            <li>Participate in meetings, trainings, and orientations to gain exposure and practical knowledge.</li>
        </ol>

        <h1>Pay and Compensation</h1>
        <ul>
            <li>The Parties hereby agree that this internship is unpaid and that the Intern will not be compensated or paid for any services that he/she conducts at the Company.</li>
            <li>The Intern agrees that he/she will be compensated in knowledge, education and experience as consideration for the duties and responsibilities that he/she will undertake under this Agreement.</li>
        </ul>

        <h1>Working Hours</h1>
        <ul>
            <li>The Intern agrees that he/she will be working from <span class="underline">Monday</span> to <span class="underline">Friday</span> (Monday to Friday), with <span class="underline">11:30 A.M</span> lunch break.</li>
            <li>In particular, the Intern agrees that he/she will work on average <span class="underline">8</span> hours per week.</li>
        </ul>

        <h1>Term of Agreement</h1>
        <ul>
            <li><a href="https://www.lawinsider.com/clause/term-of-agreement">This Agreement</a> shall be effective on the date of signing this Agreement (the <span class="definition">"Effective Date"</span>) and will end on <strong><span class="underline">_(End Date Multiply the Starting Date day of that month with 486 Hours = End Day with Month and Day)</span></strong>.</li>
        </ul>

        <h1>Termination</h1>
        <ul>
            <li>This Agreement may be terminated in the event that any of the following occurs:
                <ol>
                    <li>Immediately in the event that the Intern breaches this Agreement.</li>
                    <li>At any given time by providing written notice to the other party days prior to terminating the Agreement.</li>
                </ol>
            </li>
            <li>Upon terminating this Agreement, the Intern will be required to return all the Company's materials, products or any other content at his/her earliest convenience, but not beyond <span class="underline">3 days</span> days.</li>
        </ul>

        <h1>Confidentiality</h1>
        <ul>
            <li><a href="https://www.lawinsider.com/clause/confidentiality-clause">All terms</a> and conditions of this Agreement and any materials provided during the term of the Agreement must be kept confidential by the Intern, unless the disclosure is required pursuant to process of law.</li>
            <li>Disclosing or using this information for any purpose beyond the scope of this Agreement, or beyond the exceptions set forth above, is expressly forbidden without the prior consent of the Company.</li>
        </ul>

        <h1>Intellectual Property</h1>
        <ul>
            <li>The Intern agrees that any intellectual property provided to him/her by the Company will remain the sole property of the Company, including, but not limited to, copyrights, patents, trade secret rights, and other intellectual property rights associated with any ideas, concepts, techniques, inventions, processes, works of authorship, confidential information or trade secrets.</li>
        </ul>

        <h1>Representation and Warranties</h1>
        <ul>
            <li>Both Parties warrant that as of the Effective Date, they have the power and authority to enter into this Agreement and to perform their obligations under it, and to grant to each other the rights provided under this Agreement.</li>
            <li>Both Parties warrant that, by entering into this Agreement, they do not violate or infringe upon the rights of any third party or violate any other agreement between the Parties, individually, and any other person, organization, or business or any law or governmental regulation.</li>
        </ul>

        <h1>Limitation of Liability</h1>
        <ul>
            <li>In no event shall the Company or the Intern be individually liable for any damages for breach of duty by third parties, unless the Company's or Intern's act or failure to act involves intentional misconduct, fraud, or a knowing violation of the law.</li>
        </ul>

        <h1>Severability</h1>
        <ul>
            <li>In the event that any provision of this Agreement is found to be void and unenforceable by a court of competent jurisdiction, then the remaining provisions will remain in force in accordance with the Parties' intention.</li>
        </ul>

        <h1>Governing Law</h1>
        <ul>
            <li><a href="https://www.lawinsider.com/clause/governing-law">This Agreement</a> shall be governed by and construed in accordance with the laws of <span class="fill-blank"></span>.</li>
        </ul>

        <h1>Entire Agreement</h1>
        <ul>
            <li><a href="https://www.lawinsider.com/clause/entire-agreement">This Agreement</a> contains the entire agreement and understanding among the Parties to it with respect to its subject matter, and supersedes all prior agreements, understandings, inducements and conditions, express or implied, oral or written, of any nature whatsoever with respect to its subject matter. The express terms of the Agreement control and supersede any course of performance and/or usage of the trade inconsistent with any of its terms.</li>
        </ul>

        <h1>Signature and Date</h1>
        <ul>
            <li>The Parties hereby agree to the terms and conditions set forth in this Agreement and such is demonstrated by their signatures below:</li>
        </ul>

        <table class="signature-table">
            <tr>
                <td class="signature-header">INTERN</td>
                <td class="signature-header">COMPANY</td>
            </tr>
            <tr>
                <td>
                    <strong>Name:</strong> <span class="underline">{{ $intern->first_name }} {{ $intern->last_name }}</span><br><br>
                    <strong>Signature:</strong> <span class="fill-blank"></span><br><br>
                    <strong>Date:</strong> <span class="underline">{{ isset($today) ? $today->format('F j, Y') : now('Asia/Manila')->format('F j, Y') }}</span>
                </td>
                <td>
                    <strong>Name:</strong> <span class="underline">{{ $intern->company_name ?: 'Company Name' }}</span><br><br>
                    <strong>Signature:</strong> <span class="fill-blank"></span><br><br>
                    <strong>Date:</strong> <span class="underline">{{ isset($today) ? $today->format('F j, Y') : now('Asia/Manila')->format('F j, Y') }}</span>
                </td>
            </tr>
        </table>

        <div class="note-section">
            <p>
                <strong>Note:</strong> This agreement should be reviewed by legal counsel before execution. 
                All blank fields must be completed prior to signing.
            </p>
        </div>
    </div>
</body>
</html>