<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailSubject }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: Arial, sans-serif; color: #1f2937;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 4px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background-color: #1e3a5f; padding: 32px 40px; text-align: center;">
                            <p style="margin: 0 0 4px 0; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #86efac;">
                                Office of the
                            </p>
                            <h1 style="margin: 0; font-family: Georgia, serif; font-size: 26px; font-weight: 700; color: #ffffff; line-height: 1.3;">
                                Sangguniang Bayan<br>Hilongos, Leyte
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #0d3b6e, #2ecc71, #1565c0, #2ecc71, #0d3b6e);"></td>
                    </tr>

                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 8px 0; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #16a34a; font-weight: 600;">
                                Account Update
                            </p>
                            <h2 style="margin: 0 0 24px 0; font-family: Georgia, serif; font-size: 22px; font-weight: 700; color: #1e3a5f;">
                                {{ $mailSubject }}
                            </h2>

                            <p style="margin: 0 0 16px 0; font-size: 14px; color: #374151; line-height: 1.8;">
                                Hello <strong>{{ $name }}</strong>,
                            </p>

                            <p style="margin: 0; font-size: 14px; color: #374151; line-height: 1.8;">
                                {{ $accountMessage }}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #0d3b6e, #2ecc71, #1565c0, #2ecc71, #0d3b6e);"></td>
                    </tr>

                    <tr>
                        <td style="background-color: #0f2744; padding: 24px 40px; text-align: center;">
                            <p style="margin: 0 0 4px 0; font-size: 11px; color: #86efac; letter-spacing: 2px; text-transform: uppercase;">
                                Sangguniang Bayan ng Hilongos, Leyte
                            </p>
                            <p style="margin: 0; font-size: 11px; color: rgba(255,255,255,0.4);">
                                &copy; 2026 Office of the Sangguniang Bayan, Hilongos Leyte. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
