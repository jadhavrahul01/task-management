<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        .mail,
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }

        .w-100 {
            width: 100%;
        }

        .bg-gray {
            background-color: #353C49;
        }

        .bg-blue {
            background-color: #1d232a;
            color: #fff;
        }

        .bg-blue a {
            color: #fff;
        }

        .color-white {
            color: #fff;
        }

        .color-gray {
            color: #353C49;
        }

        .color-green {
            color: #0c5b2f;
        }

        .text-center {
            text-align: center;
        }

        a,
        .link {
            color: #1d232a;
            text-decoration: underline;
        }

        b,
        .bold {
            font-weight: 600;
        }

        p {
            margin: 5px 0;
            padding: 3px 0;
        }

        .main {
            padding: 0px 15px;
        }

        .header {
            background-color: #1d232a;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 0px 0px 40px 40px;
            margin-bottom: 20px;
        }

        .subject {
            color: #353C49;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            color: #fff;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
            background: #353C49;
            border-radius: 40px 40px 0px 0px;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            margin: 5px 0;
            display: inline-block;
            text-decoration: none;
        }


        .btn-sm {
            padding: 3px 6px;
            border-radius: 3px;
            margin: 3px 0;
            display: inline-block;
            font-size: 12px;
        }

        .btn-primary {
            background-color: #1d232a;
            color: #fff;
        }

        .btn-danger {
            background-color: #E63737;
            color: #fff;
        }

        .btn-info {
            background-color: #0096EA;
            color: #fff;
        }

        .btn-warning {
            background-color: #DF7E25;
            color: #fff;
        }

        .btn-success {
            background-color: #00C840;
            color: #fff;
        }

        .license {
            color: #353C49;
            padding: 3px 10px;
            border-radius: 5px;
            margin: 5px 0;
            display: inline-block;
            border: 2px solid #353C49;
            font-family: monospace;
            text-decoration: none;
            text-transform: uppercase;
        }

        .domain {
            color: #7B0700;
            padding: 3px 10px;
            border-radius: 5px;
            margin: 5px 0;
            font-weight: 600;
            display: inline-block;
            border: 2px solid #7B0700;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: left;
            color: #353C49;
        }

        th,
        td {
            border: 1px solid #B4B4B4;
            padding: 3px 5px;
        }

        thead {
            background-color: #E4E4E4;
        }

        .license-create-data tr td {
            border: 1px solid #000;
            padding: 8px;
        }

        .badge {
            border-radius: .5rem;
            vertical-align: middle;
            color: var(--badge-fg);
            border: var(--border)solid var(--badge-color, var(--color-base-200));
            width: fit-content;
            padding: 2px 3px !important;
            background-size: auto, calc(var(--noise)*100%);
            background-image: none, var(--fx-noise);
            background-color: var(--badge-bg);
            --badge-bg: var(--badge-color, var(--color-base-100));
            --badge-fg: var(--color-base-content);
            --size: calc(var(--size-selector, .25rem)*6);
            height: var(--size);
            justify-content: center;
            align-items: center;
            gap: .5rem;
            font-size: .875rem;
            display: inline-flex
        }

        .badge-primary {
            --badge-color: #3b82f6;
            /* Blue */
            --badge-fg: white;
        }

        .badge-success {
            --badge-color: #10b981;
            /* Green */
            --badge-fg: white;
        }

        .badge-warning {
            --badge-color: #f59e0b;
            /* Amber */
            --badge-fg: black;
        }

        .badge-error {
            --badge-color: #ef4444;
            /* Red */
            --badge-fg: white;
        }

        .badge-info {
            --badge-color: #0ea5e9;
            /* Light Blue */
            --badge-fg: white;
        }

        .badge-neutral {
            --badge-color: #6b7280;
            /* Gray */
            --badge-fg: white;
        }

        .badge-light {
            --badge-color: #f3f4f6;
            /* Light Gray */
            --badge-fg: black;
        }

        .badge-soft {
            border: none;
            background-color: var(--badge-soft-bg);
            color: var(--badge-soft-fg);
        }

        /* Soft Variants */
        .badge-primary.badge-soft {
            --badge-soft-bg: #dbeafe;
            /* Light Blue */
            --badge-soft-fg: #1e3a8a;
            /* Darker Blue */
        }

        .badge-success.badge-soft {
            --badge-soft-bg: #d1fae5;
            /* Light Green */
            --badge-soft-fg: #065f46;
            /* Darker Green */
        }

        .badge-warning.badge-soft {
            --badge-soft-bg: #fef3c7;
            /* Light Amber */
            --badge-soft-fg: #92400e;
            /* Darker Amber */
        }

        .badge-error.badge-soft {
            --badge-soft-bg: #fee2e2;
            /* Light Red */
            --badge-soft-fg: #991b1b;
            /* Darker Red */
        }

        .badge-info.badge-soft {
            --badge-soft-bg: #e0f2fe;
            /* Light Sky Blue */
            --badge-soft-fg: #0369a1;
            /* Darker Blue */
        }

        .badge-neutral.badge-soft {
            --badge-soft-bg: #f3f4f6;
            /* Light Gray */
            --badge-soft-fg: #374151;
            /* Medium Gray */
        }
    </style>
</head>

<body>
    <div class="mail">
        <div class="header">
            <div class="font-black text-2xl underline decoration-amber-400  decoration-[0.15rem]">TaskMate</div>
        </div>
        <div class="main">
            @yield('content')
        </div>
        <div class="footer" style="font-size:11px;color:#bababa;">
            <p>
                © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved
            </p>
        </div>
    </div>
</body>

</html>
