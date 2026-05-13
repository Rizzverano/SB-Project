<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Message Has Been Read</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Source Sans 3', Arial, sans-serif; color: #1e3a5f;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 4px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1e3a5f; padding: 36px 40px; text-align: center;">

                            <!-- Logo placeholder row -->
                            <p style="margin: 0 0 4px 0; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #86efac;">
                                Office of the
                            </p>
                            <h1 style="margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 26px; font-weight: 700; color: #ffffff; line-height: 1.3;">
                                Sangguniang Bayan<br>Hilongos, Leyte
                            </h1>
                        </td>
                    </tr>

                    <!-- Gradient Divider -->
                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #0d3b6e, #2ecc71, #1565c0, #2ecc71, #0d3b6e);"></td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 40px 32px 40px;">

                            <p style="margin: 0 0 8px 0; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #16a34a; font-weight: 600;">
                                Message Update
                            </p>
                            <h2 style="margin: 0 0 24px 0; font-family: 'Playfair Display', Georgia, serif; font-size: 22px; font-weight: 700; color: #1e3a5f;">
                                Your message has been read.
                            </h2>

                            <p style="margin: 0 0 16px 0; font-size: 14px; color: #374151; line-height: 1.8;">
                                Hello <strong>{{ $contactMessage->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 16px 0; font-size: 14px; color: #374151; line-height: 1.8;">
                                We would like to inform you that your message has been received and read by the administration of the Sangguniang Bayan of Hilongos, Leyte.
                            </p>

                            <p style="margin: 0 0 32px 0; font-size: 14px; color: #374151; line-height: 1.8;">
                                For further inquiries or concerns, kindly proceed to our legislative building during office hours.
                            </p>

                            <!-- Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #eff6ff; border-left: 4px solid #2ecc71; border-radius: 2px; margin-bottom: 32px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="margin: 0 0 4px 0; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #16a34a; font-weight: 600;">Office Hours</p>
                                        <p style="margin: 0; font-size: 13px; color: #1e3a5f; line-height: 1.7;">
                                            Monday to Friday &nbsp;•&nbsp; 8:00 AM – 5:00 PM (no noon break)<br>
                                            Western Barangay Hilongos, Leyte<br>
                                            (+63) 954 305 6206
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 14px; color: #374151; line-height: 1.8;">
                                Thank you for reaching out to us.
                            </p>

                        </td>
                    </tr>

                    <!-- Gradient Divider -->
                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #0d3b6e, #2ecc71, #1565c0, #2ecc71, #0d3b6e);"></td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #0f2744; padding: 24px 40px; text-align: center;">
                            <p style="margin: 0 0 4px 0; font-size: 11px; color: #86efac; letter-spacing: 2px; text-transform: uppercase;">
                                Sangguniang Bayan ng Hilongos, Leyte
                            </p>
                            <p style="margin: 0; font-size: 11px; color: rgba(255,255,255,0.4);">
                                © 2026 Office of the Sangguniang Bayan, Hilongos Leyte. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
