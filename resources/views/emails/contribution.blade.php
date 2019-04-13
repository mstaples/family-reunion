<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>Hello {{ $name }}!</p>
<p>This is your {{ $timing }} reminder to contribute to the housing costs for our Chosen Family Reunion!</p>
<p>We need to pay the balance on the house by October 1st, and your help is greatly appreciated!</p>
<p>You can visit <a href="https://cyborg.love">cyborg.love</a> to change your RSVP or your notification settings.</p>
<p>Looking forward to spending time with you!</p>
<img src="{{ asset("images/contribution/option".$gif.".gif") }}">
</body>
</html>