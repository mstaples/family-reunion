@include('components.header')
<body class="is-preload">
<div class="bg_heart">
<!-- Wrapper-->
<div id="wrapper">
    <!-- Nav -->
    @include('components.nav')

    <!-- Main -->
    <div id="main">

        <!-- Me -->
        <article id="home" class="panel intro">
            @include('panels.home')
        </article>

        <!-- Destination -->
        <article id="destination" class="panel">
            @include('panels.destination')
        </article>

        <!-- RSVP -->
        <article id="rsvp" class="panel">
            @include('panels.rsvp', [ 'user' => $user, 'hasConflicts' => false ])
        </article>

        <!-- Contribute -->
        <article id="contribute" class="panel">
            @include('panels.contribute', [ 'message' => "" ])
        </article>

        <!-- Notifications -->
        <article id="notifications" class="panel">
            @include('panels.notifications')
        </article>


    </div>

    <!-- Footer -->
    @include('components.footer')

</div>
</div>
@include('components.javascript')
</body>
</html>