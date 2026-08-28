<!DOCTYPE html>
<html>
<head>
    <title>{{ $intern->first_name }} {{ $intern->last_name }} - DTR</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            padding: 20px;
            background-color: #f1f1f1;
            color: #111;
        }

        .form-shell {
            max-width: 1024px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #111;
        }

        .dtr-print-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: stretch;
            gap: 18px;
        }

        .form-shell {
            flex: 0 0 calc(50% - 9px);
            max-width: calc(50% - 9px);
            display: flex;
            flex-direction: column;
            align-self: stretch;
            min-height: 100%;
        }

        .print-copy {
            display: none;
        }

        .title-section {
            text-align: center;
            margin-bottom: 10px;
        }

        .form-code {
            font-size: 9px;
            letter-spacing: 1px;
            margin-bottom: 4px;
            color: #333;
        }

        .form-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1.7px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .author-name {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 0 8px 2px;
            margin-bottom: 4px;
        }

        .author-caption {
            font-size: 10px;
            font-style: italic;
            margin-bottom: 16px;
            color: #555;
        }

        .info-block {
            width: 100%;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 4px;
        }

        .info-item {
            display: flex;
            gap: 6px;
            flex: 1;
        }

        .info-label {
            font-weight: 700;
            white-space: nowrap;
        }

        .info-fill {
            flex: 1;
            border-bottom: 1px solid #000;
            min-width: 40px;
            padding-left: 4px;
            font-weight: 600;
            color: #111;
        }

        table.dtr-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 10px;
        }

        table.dtr-table th,
        table.dtr-table td {
            border: 1px solid #444;
            padding: 5px 6px;
            text-align: center;
            vertical-align: middle;
        }

        table.dtr-table thead th {
            font-weight: 700;
            background-color: #f5f5f5;
            color: #111;
        }

        table.dtr-table tbody td.day-cell {
            font-weight: 700;
            width: 30px;
            color: #111;
            background: #fafafa;
        }

        table.dtr-table tbody tr td {
            height: 20px;
        }

        .no-records td {
            font-style: italic;
            height: 40px;
        }

        .totals-row td {
            font-weight: 700;
            text-align: right;
            padding-right: 8px;
            background: #f3f3f3;
        }

        .totals-row td.day-cell {
            text-align: center;
        }

        .bottom-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            margin-top: 18px;
            font-size: 10px;
        }

        .bottom-box {
            width: 100%;
            max-width: 760px;
            padding: 10px 12px;
            background: #fafafa;
            min-height: auto;
            margin: 0 auto;
        }

        .bottom-box.signature-box {
            max-width: 320px;
        }

        .bottom-box.certification-box {
            max-width: 640px;
        }

        .bottom-box-title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            margin-bottom: 6px;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .signature-note {
            font-size: 8.5px;
            color: #222;
            margin-bottom: 4px;
            font-style: italic;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 12px;
            padding-top: 4px;
            font-size: 9px;
            text-align: center;
        }

        .signature-subtext {
            margin-top: 4px;
            font-size: 9px;
            color: #333;
            text-align: center;
        }

        .signature-pad-wrap {
            position: relative;
            width: 100%;
            max-width: 100%;
            margin-bottom: 8px;
            min-height: 52px;
            display: flex;
            align-items: stretch;
        }

        #signature-canvas {
            display: block;
            width: 100%;
            height: 52px;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            border-radius: 3px;
            background: transparent;
            touch-action: none;
            cursor: crosshair;
        }

        .signature-pad-wrap {
            position: relative;
            width: 100%;
            max-width: 100%;
            margin-bottom: 8px;
            border: none !important;
            box-shadow: none !important;
        }

        .signature-canvas-hint {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            text-align: center;
            transform: translateY(-50%);
            font-size: 10px;
            color: #aaa;
            pointer-events: none;
            font-family: Arial, sans-serif;
        }

        .signature-controls {
            display: flex;
            gap: 6px;
            margin-top: 4px;
            font-family: Arial, sans-serif;
            justify-content: center;
        }

        .sig-btn {
            flex: 0 0 auto;
            width: 100px;
            padding: 5px 8px;
            font-size: 10px;
            border: 1px solid #000;
            background: #fff;
            color: #000;
            border-radius: 3px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .sig-btn.primary {
            background: #000;
            color: #fff;
        }

        .sig-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .signature-result {
            display: none;
            width: 100%;
            min-height: 52px;
            padding: 0;
            background: transparent;
        }

        .signature-result img {
            display: block;
            width: 100%;
            max-height: 90px;
            height: 52px;
            object-fit: contain;
            margin: 0 auto;
            background: transparent;
        }

        .signature-status {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #2a7d2a;
            text-align: center;
            margin-top: 4px;
            min-height: 12px;
        }

        #signature-edit-controls {
            margin-top: 8px;
            justify-content: center;
        }

        #signature-edit-controls .sig-btn {
            width: 100px;
            padding: 5px 8px;
            font-size: 10px;
            border: 1px solid #000;
            background: #fff;
            color: #000;
            border-radius: 3px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0.35cm;
            }

            html, body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                background: #fff;
                color: #000;
            }

            body {
                padding: 0;
            }

            #print-wrapper {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                justify-content: space-between;
            }

            .form-shell {
                box-shadow: none;
                padding: 12px;
                width: 49%;
                min-width: 49%;
                page-break-inside: avoid;
                break-inside: avoid;
                border: 1px solid #000;
            }

            .print-copy {
                display: block !important;
            }

            .title-section,
            .info-block,
            .bottom-section,
            .button-group,
            .print-note {
                margin-bottom: 6px;
            }

            .form-code {
                font-size: 9px;
            }

            .form-title {
                font-size: 16px;
            }

            .author-name {
                font-size: 12px;
            }

            .author-caption,
            .info-block,
            .bottom-box-title,
            .signature-line,
            .signature-status,
            .certification-text {
                font-size: 9px;
            }

            table.dtr-table {
                font-size: 9px;
            }

            table.dtr-table th,
            table.dtr-table td {
                padding: 2px 3px;
            }

            .bottom-section {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .bottom-box {
                flex: 1 1 100%;
                min-width: auto;
                padding: 8px;
                max-width: 760px;
                border: none;
            }

            .bottom-box.signature-box {
                max-width: 460px;
            }

            .signature-pad-wrap,
            .signature-controls,
            .signature-canvas-hint,
            #signature-canvas {
                display: none !important;
            }

            .signature-line {
                margin-top: 20px;
                border-top: 1px solid #000;
                padding-top: 4px;
            }

            .button-group,
            .print-note {
                display: none !important;
            }
        }

        .certification-text {
            line-height: 1.4;
            max-width: 620px;
            margin: 0 auto;
        }

        .button-group {
            text-align: center;
            margin-top: 26px;
        }

        .button {
            margin: 0 8px;
            display: inline-block;
            min-width: 110px;
            padding: 10px 14px;
            text-align: center;
            background-color: #000;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .button:hover {
            background-color: #222;
        }

        .back-button {
            background-color: #444;
        }

        .back-button:hover {
            background-color: #222;
        }

        .print-note {
            margin-top: 12px;
            text-align: center;
            font-style: italic;
            color: #444;
            min-height: 18px;
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

    </style>
</head>
<body>
    <div id="print-wrapper" class="dtr-print-wrapper">
        <div class="form-shell">
            <div class="title-section">
                <div class="form-code">CIVIL SERVICE FORM NO. 48</div>
            <div class="form-title">DAILY TIME RECORD</div>
            <div class="author-name">{{ $intern->first_name }} {{ $intern->last_name }}</div>
            <div class="author-caption">(Name)</div>
        </div>

        <div class="info-block">
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">For the month of:</span>
                    <span class="info-fill">{{ now('Asia/Manila')->format('F Y') }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Official hours for arrival and departure</span>
                    <span class="info-fill"></span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Regular Days:</span>
                    <span class="info-fill"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Saturdays:</span>
                    <span class="info-fill"></span>
                </div>
            </div>
        </div>

        <table class="dtr-table">
            <thead>
                <tr>
                    <th rowspan="2">Day</th>
                    <th colspan="2">A.M.</th>
                    <th colspan="2">P.M.</th>
                    <th colspan="2">Undertime</th>
                </tr>
                <tr>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Hours</th>
                    <th>Minutes</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $daysInMonth = now()->daysInMonth;
                    $logsByDate = collect($logs)->groupBy(function ($log) {
                        return \Carbon\Carbon::parse($log->date)->format('Y-m-d');
                    });
                    $noon = \Carbon\Carbon::createFromTime(12, 0, 0, 'Asia/Manila');
                @endphp

                @if(count($logs) === 0)
                    <tr class="no-records">
                        <td colspan="7">No attendance records found.</td>
                    </tr>
                @else
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $currentDate = now()->startOfMonth()->addDays($day - 1);
                            $dateKey = $currentDate->format('Y-m-d');
                            $dayLogs = $logsByDate->get($dateKey, collect())->sortBy('time_in');
                            $amArrival = '';
                            $amDeparture = '';
                            $pmArrival = '';
                            $pmDeparture = '';

                            foreach ($dayLogs as $dayLog) {
                                $timeIn = $dayLog->time_in ? \Carbon\Carbon::parse($dateKey . ' ' . $dayLog->time_in, 'Asia/Manila') : null;
                                $timeOut = $dayLog->time_out ? \Carbon\Carbon::parse($dateKey . ' ' . $dayLog->time_out, 'Asia/Manila') : null;

                                if ($timeIn && $timeOut) {
                                    if ($timeOut->lte($noon)) {
                                        $amArrival = $amArrival ?: $timeIn->format('h:i A');
                                        $amDeparture = $amDeparture ?: $timeOut->format('h:i A');
                                    } elseif ($timeIn->gte($noon)) {
                                        $pmArrival = $pmArrival ?: $timeIn->format('h:i A');
                                        $pmDeparture = $pmDeparture ?: $timeOut->format('h:i A');
                                    } else {
                                        $amArrival = $amArrival ?: $timeIn->format('h:i A');
                                        $pmDeparture = $pmDeparture ?: $timeOut->format('h:i A');
                                    }
                                } elseif ($timeIn) {
                                    if ($timeIn->lt($noon)) {
                                        $amArrival = $amArrival ?: $timeIn->format('h:i A');
                                    } else {
                                        $pmArrival = $pmArrival ?: $timeIn->format('h:i A');
                                    }
                                }
                            }
                        @endphp
                        <tr>
                            <td class="day-cell">{{ $day }}</td>
                            <td>{{ $amArrival }}</td>
                            <td>{{ $amDeparture }}</td>
                            <td>{{ $pmArrival }}</td>
                            <td>{{ $pmDeparture }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                    <tr class="totals-row">
                        <td class="day-cell"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="bottom-section">
            <div class="bottom-box certification-box">
                <div class="bottom-box-title">Certification</div>
                <div class="certification-text">
                    I certify on my honor that the above is a true and correct record of hours of work performed, which was made daily at the time of arrival and departure from the office.
                </div>
            </div>
            <div class="bottom-box signature-box">
                <div class="bottom-box-title">Signature</div>
                <div class="signature-note">Certified correct by the undersigned:</div>

                <div class="signature-pad-wrap" id="signature-pad-wrap">
                    <canvas id="signature-canvas"></canvas>
                    <div class="signature-canvas-hint" id="signature-hint">Sign here</div>
                </div>

                <div class="signature-result" id="signature-result">
                    <img id="signature-image" alt="Signature" />
                </div>

                <div class="signature-controls" id="signature-controls">
                    <button type="button" class="sig-btn" id="sig-clear-btn">Clear</button>
                    <button type="button" class="sig-btn primary" id="sig-apply-btn" disabled>Sign</button>
                </div>
                <div class="signature-controls" id="signature-edit-controls" style="display:none;">
                    <button type="button" class="sig-btn" id="sig-reset-btn">Clear Signature</button>
                </div>

                <div class="signature-status" id="signature-status"></div>
                <input type="hidden" name="signature" id="signature-input" value="">
                <div class="signature-line">{{ $intern->first_name }} {{ $intern->last_name }}</div>
                <div class="signature-subtext">Signature over Printed Name</div>
            </div>
        </div>

        <div class="print-note" id="print-note"></div>
        <div class="button-group">
            <a href="#" class="button" onclick="handlePrint(event)">Print</a>
            <a href="{{ url()->previous() }}" class="button back-button">Back</a>
        </div>
    </div>

    <script>
        var printWrapper = document.getElementById('print-wrapper');
        var originalForm = document.querySelector('#print-wrapper > .form-shell');

        if (printWrapper && originalForm) {
            var duplicateForm = originalForm.cloneNode(true);
            duplicateForm.classList.add('duplicate-form');
            duplicateForm.querySelectorAll('[id]').forEach(function (el) {
                el.id = el.id + '-copy';
            });
            printWrapper.insertBefore(duplicateForm, originalForm);
        }

        // Only points at a real URL if the route actually exists in your app.
        // Otherwise this stays empty and the save-to-server call is skipped.
        var saveSignatureUrl = @json(\Illuminate\Support\Facades\Route::has('intern.dtr.sign') ? route('intern.dtr.sign', $intern->id ?? 0) : '');
        var csrfToken = @json(csrf_token());

        function handlePrint(event) {
            event.preventDefault();
            var note = document.getElementById('print-note');
            note.textContent = 'Preparing document for printing…';
            preparePrintCopy();
            window.print();
            setTimeout(function() {
                note.textContent = '';
            }, 3000);
        }

        function preparePrintCopy() {
            var original = document.querySelector('#print-wrapper > .form-shell:not(.print-copy)');
            var copyContainer = document.querySelector('#print-wrapper > .form-shell.print-copy');
            if (!original || !copyContainer) return;

            // Clone original form shell for the print copy.
            var clone = original.cloneNode(true);
            clone.classList.add('print-copy');
            clone.style.display = 'block';
            clone.removeAttribute('id');

            // Hide interactive elements inside the print copy.
            clone.querySelectorAll('.button-group, .print-note, .signature-pad-wrap, .signature-controls').forEach(function(el) {
                el.style.display = 'none';
            });

            copyContainer.parentNode.replaceChild(clone, copyContainer);
        }

        (function () {
            var canvases = Array.prototype.slice.call(document.querySelectorAll('canvas[id*="signature-canvas"]'));
            var hint = document.getElementById('signature-hint');
            var applyBtn = document.getElementById('sig-apply-btn');
            var clearBtn = document.getElementById('sig-clear-btn');
            var resetBtn = document.getElementById('sig-reset-btn');

            var drawing = false;
            var hasStroke = false;
            var signatureCommitted = false;
            var lastX = 0, lastY = 0;

            function resizeCanvas(canvas) {
                var ctx = canvas.getContext('2d');
                var ratio = window.devicePixelRatio || 1;
                var rect = canvas.getBoundingClientRect();
                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;
                ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#000';
            }

            function getPos(canvas, e) {
                var rect = canvas.getBoundingClientRect();
                var clientX = e.clientX ?? (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
                var clientY = e.clientY ?? (e.touches && e.touches[0] ? e.touches[0].clientY : 0);
                return { x: clientX - rect.left, y: clientY - rect.top };
            }

            function syncSignatureState(dataUrl, signedText) {
                document.querySelectorAll('.signature-pad-wrap').forEach(function (padWrap) {
                    padWrap.style.display = 'none';
                });

                document.querySelectorAll('.signature-controls').forEach(function (controls) {
                    controls.style.display = 'none';
                });

                document.querySelectorAll('.signature-result').forEach(function (resultWrap) {
                    resultWrap.style.display = 'block';
                });

                document.querySelectorAll('[id*="signature-edit-controls"]').forEach(function (editControls) {
                    editControls.style.display = 'flex';
                });

                document.querySelectorAll('img[id*="signature-image"]').forEach(function (resultImg) {
                    resultImg.src = dataUrl;
                });

                document.querySelectorAll('input[id*="signature-input"]').forEach(function (hiddenInput) {
                    hiddenInput.value = dataUrl;
                });

                document.querySelectorAll('.signature-status').forEach(function (statusEl) {
                    statusEl.textContent = signedText;
                });
            }

            function clearAllCanvases() {
                canvases.forEach(function (canvas) {
                    var ctx = canvas.getContext('2d');
                    ctx.setTransform(1, 0, 0, 1, 0, 0);
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });
            }

            function commitSignature(targetCanvas) {
                if (!hasStroke || signatureCommitted) return;
                signatureCommitted = true;

                var currentCanvas = targetCanvas || canvases[0];
                var dataUrl = currentCanvas.toDataURL('image/png');
                var now = new Date();
                var signedText = 'Signed on ' + now.toLocaleString();

                syncSignatureState(dataUrl, signedText);

                if (saveSignatureUrl) {
                    fetch(saveSignatureUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ signature: dataUrl })
                    })
                    .then(function (res) { return res.json(); })
                    .then(function () {
                        document.querySelectorAll('.signature-status').forEach(function (statusEl) {
                            statusEl.textContent = 'Signed and saved on ' + now.toLocaleString();
                        });
                    })
                    .catch(function () {
                        document.querySelectorAll('.signature-status').forEach(function (statusEl) {
                            statusEl.textContent = 'Signed locally (not saved to server).';
                        });
                    });
                }
            }

            function clearCanvas() {
                clearAllCanvases();
                drawing = false;
                hasStroke = false;
                signatureCommitted = false;
                if (hint) hint.style.display = 'block';
                if (applyBtn) applyBtn.disabled = true;
                document.querySelectorAll('.signature-status').forEach(function (statusEl) {
                    statusEl.textContent = '';
                });
            }

            canvases.forEach(function (canvas) {
                resizeCanvas(canvas);

                function start(e) {
                    if (signatureCommitted) {
                        return;
                    }

                    drawing = true;
                    hasStroke = true;
                    if (hint) hint.style.display = 'none';
                    var pos = getPos(canvas, e);
                    lastX = pos.x;
                    lastY = pos.y;
                    if (applyBtn) applyBtn.disabled = false;
                    if (e.pointerId !== undefined && canvas.setPointerCapture) {
                        canvas.setPointerCapture(e.pointerId);
                    }
                }

                function move(e) {
                    if (!drawing) return;
                    e.preventDefault();
                    var pos = getPos(canvas, e);
                    var ctx = canvas.getContext('2d');
                    ctx.beginPath();
                    ctx.moveTo(lastX, lastY);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                    lastX = pos.x;
                    lastY = pos.y;
                }

                function end() {
                    if (!drawing || !hasStroke) return;
                    drawing = false;
                    commitSignature(canvas);
                }

                canvas.addEventListener('pointerdown', start);
                canvas.addEventListener('pointermove', move);
                canvas.addEventListener('pointerup', end);
                canvas.addEventListener('pointerleave', end);
                canvas.addEventListener('pointercancel', end);
                canvas.style.touchAction = 'none';
            });

            if (clearBtn) {
                clearBtn.addEventListener('click', clearCanvas);
            }

            if (applyBtn) {
                applyBtn.addEventListener('click', function () {
                    commitSignature(canvases[0]);
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    document.querySelectorAll('.signature-result').forEach(function (resultWrap) {
                        resultWrap.style.display = 'none';
                    });
                    document.querySelectorAll('[id*="signature-edit-controls"]').forEach(function (editControls) {
                        editControls.style.display = 'none';
                    });
                    document.querySelectorAll('.signature-pad-wrap').forEach(function (padWrap) {
                        padWrap.style.display = 'block';
                    });
                    document.querySelectorAll('.signature-controls').forEach(function (controls) {
                        controls.style.display = 'flex';
                    });
                    document.querySelectorAll('input[id*="signature-input"]').forEach(function (hiddenInput) {
                        hiddenInput.value = '';
                    });
                    signatureCommitted = false;
                    clearCanvas();
                });
            }
        })();
    </script>
</body>
</html>