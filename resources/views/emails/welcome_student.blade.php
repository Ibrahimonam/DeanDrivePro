<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Dean Driving School</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="padding: 20px 0;">
        <!-- Container -->
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;">
          <!-- Header -->
          <tr>
            <td style="background-color:#0d6efd;padding:30px;text-align:center;">
              <h1 style="color:#ffffff;margin:0;font-size:28px;">Welcome, {{ $student->first_name }}!</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:30px;color:#333333;line-height:1.5;">
              <p style="font-size:16px;margin-top:0;">
                Congratulations on joining <strong>Dean Driving School</strong>! We’re thrilled to have you on board.
              </p>

              <p style="font-size:16px;">
                <strong style="color:#0d6efd;">Your Enrollment Details:</strong>
              </p>
              <ul style="font-size:16px;color:#333333;padding-left:20px;margin-top:0;">
                <li><strong>Class:</strong> {{ $student->class->name }}</li>
                <li><strong>Branch:</strong> {{ $student->branch->name }}</li>
              </ul>

              <p style="font-size:16px;">
                <strong style="color:#0d6efd;">What’s Next?</strong>
              </p>
              <ol style="font-size:16px;color:#333333;padding-left:20px;margin-top:0;">
                <li>You will receive your full schedule and instructor details via email shortly.</li>
                <li>If you have any questions, drop us a line at
                  <a href="mailto:info@deansystems.co.ke" style="color:#0d6efd;text-decoration:none;">
                    info@deansystems.co.ke
                  </a> or call us at <strong>+254 713 000000</strong>.
                </li>
              </ol>

              <p style="font-size:16px;">Thank you for choosing Dean Driving School. We look forward to helping you become a safer driver!</p>

              <p style="font-size:16px;margin-bottom:0;">
                Best regards,<br>
                <strong>{{ config('mail.from.name') }}</strong>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color:#f0f0f0;padding:20px;text-align:center;font-size:12px;color:#777777;">
              &copy; {{ date('Y') }} Dean Driving School. All rights reserved.<br>
              <a href="https://deansystems.co.ke" style="color:#777777;text-decoration:none;">www.deansystems.co.ke</a>
            </td>
          </tr>
        </table>
        <!-- End Container -->
      </td>
    </tr>
  </table>

</body>
</html>
