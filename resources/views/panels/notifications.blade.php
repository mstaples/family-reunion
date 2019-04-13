<header>
    <h2>Notifications</h2>
</header>
<p>
  What kind of notifications would you like to receive?
</p>

<form action="{{ route('notification') }}" method="post">
    <div>
        <div class="row">
            <div class="col-12">
                <h3>Contribution Reminders</h3>
                <p>Want help remembering to contribute a bit at a time?</p>
            </div>
            <div class="col-2">
                <p>Via Text?</p>
            </div>
            <div class="col-3">
                <select name="contribution_text">
                    @foreach ($user->notification->options as $option)
                        <option value="{{ $option }}"
                                @if ($user->notification->contribution_text == $option)
                                selected
                                @endif
                        >{{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-1">
            </div>
            <div class="col-2">
                <p>Via Email?</p>
            </div>
            <div class="col-3">
                <select name="contribution_email">
                    @foreach ($user->notification->options as $option)
                        <option value="{{ $option }}"
                                @if ($user->notification->contribution_email == $option)
                                selected
                                @endif
                        >{{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <h3>Preparation Reminders</h3>
                <p>Want help remembering to get ready for the reunion?</p>
            </div>
            <div class="col-2">
                <p>Via Text?</p>
            </div>
            <div class="col-3">
                <select name="preparation_text">
                    @foreach ($user->notification->options as $option)
                        <option value="{{ $option }}"
                                @if ($user->notification->preparation_text == $option)
                                selected
                                @endif
                        >{{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-1">
            </div>
            <div class="col-2">
                <p>Via Email?</p>
            </div>
            <div class="col-3">
                <select name="preparation_email">
                    @foreach ($user->notification->options as $option)
                        <option value="{{ $option }}"
                                @if ($user->notification->preparation_email == $option)
                                selected
                                @endif
                        >{{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="submit"
                       @if ($user->rsvp->has_rsvp)
                       value="Update"
                       @else
                       value="Save"
                        @endif
                />
            </div>
        </div>
    </div>
</form>