<header>
    <h2>RSVP</h2>
</header>
<form action="{{ route('rsvp') }}" method="post">
    <div>
        <div class="row">
            <div class="col-12">
                <h3>Hello, {{ $user->name }}</h3>
                @if ($hasConflicts)
                    <div class="error">
                        <p>{{ $message }}</p>
                        <ul>
                            @foreach ($conflicts as $conflict)
                                <li>{{ $conflict }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-4">
                <select name="private">
                    <option value="false"
                        @if (!$user->rsvp->private)
                            selected
                        @endif
                        >Shared Room
                    </option>
                    <option value="true"
                        @if ($user->rsvp->private)
                            selected
                        @endif
                        >Private Room*
                    </option>
                </select>
            </div>
            <div class="col-4">
                <select name="pet">
                    <option value="false"
                        @if (!$user->rsvp->pet)
                            selected
                        @endif
                        >Just Humans
                    </option>
                    <option value="true"
                        @if ($user->rsvp->pet)
                            selected
                        @endif
                        >Bringing Doggo
                    </option>
                </select>
            </div>
            <div class="col-12">
                Nights to reserve:<br/>
                @foreach ($user->rsvp->days as $day => $value)
                    @if ($value)
                        <?php $className = "selected" ?>
                    @else
                        <?php $className = "deselected" ?>
                    @endif
                    <input id="button-{{ $loop->iteration }}"
                           class="day-buttons {{ $className }}"
                           type="button"
                           name="day{{ $loop->iteration }}"
                           value="{{ $day }}" />
                    <input id="day-{{ $loop->iteration }}"
                           name="day{{ $loop->iteration }}-value"
                           type="hidden"
                           @if ($value)
                             value="true"
                           @else
                             value="false"
                           @endif
                    >
                @endforeach
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
            <div class="col-12">
                <small>*If you reserve a private room for you and your partner, there's no need for them to create a second reservation.</small>
            </div>
        </div>
    </div>
</form>