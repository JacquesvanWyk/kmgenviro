<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $formType === 'contact' ? 'New Contact Form Submission' : ($formType === 'quote' ? 'New Quote Request' : ($formType === 'training' ? 'New Training Booking' : ($formType === 'equipment' ? 'New Equipment Enquiry' : 'New Lead'))) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #22c55e;
            color: #18181b;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            background-color: #f9fafb;
        }
        .field {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .field:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .value {
            margin-top: 5px;
            color: #111827;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6b7280;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #22c55e;
            color: #18181b;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KMG Environmental</h1>
    </div>

    <div class="content">
        <div class="badge">
            @switch($formType)
                @case('contact')
                    CONTACT ENQUIRY
                    @break
                @case('quote')
                    QUOTE REQUEST
                    @break
                @case('training')
                    TRAINING BOOKING
                    @break
                @case('equipment')
                    EQUIPMENT RENTAL
                    @break
                @case('lead')
                    RESOURCE DOWNLOAD
                    @break
                @default
                    NEW ENQUIRY
            @endswitch
        </div>

        @foreach($data as $key => $value)
            @if(!empty($value))
                <div class="field">
                    <div class="label">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                    <div class="value">
                        @if(is_array($value))
                            {{ implode(', ', $value) }}
                        @else
                            {!! nl2br(e($value)) !!}
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="footer">
        <p>This email was sent from the KMG Environmental website.</p>
        <p>{{ now()->format('d M Y, H:i') }}</p>
    </div>
</body>
</html>
