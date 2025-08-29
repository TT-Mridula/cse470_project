<!doctype html>
<html>
  <body>
    <p>Hello,</p>
    <p>Your {{ $appName }} registration code is:</p>
    <h2 style="letter-spacing:2px">{{ $code }}</h2>
    <p>This code expires in {{ $minutes }} minutes.</p>
    <p>If you did not start registration, ignore this email.</p>
  </body>
</html>
