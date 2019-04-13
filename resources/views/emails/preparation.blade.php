<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Are You Ready?</h2>
<p>Hello {{ $name }}!</p>
<p>This is your {{ $timing }} reminder to get ready for our upcoming Chosen Family Reunion!</p>
<p>We'll be getting together November 1st - 10th, and we sure hope you'll be there!</p>
<p>Here are a few things you might want to do to prepare:</p>
<ul>
    <li>Take time off from work or school.</li>
    <li>Set aside some cash for food, souvenirs, and/or incidentals.</li>
    <li>Make travel arrangements.</li>
    <li>Refill medications to bring with you.</li>
    <li>Let people know you'll be away.</li>
    <li>Pack a bag.</li>
</ul>
<p>You can visit <a href="https://cyborg.love">cyborg.love</a> to change your RSVP or your notification settings.</p>
<p>Looking forward to spending time with you!</p>
<img src="{{ asset("images/preparation/option".$gif.".gif") }}">
</body>
</html>