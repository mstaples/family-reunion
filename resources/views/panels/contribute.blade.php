<header>
    <h2>Housing Contribution</h2>
</header>
    <div>
        <div class="row">
            <div class="col-12">
                <h3>Hello {{ $user->name }} <i class="icon fa-heart"></i></h3>
                <br/>
                <p>Half the cost of the space has been paid to reserve it. The other half is due on October 1st. If we haven't put together sufficient contributions to cover the balance, I will cancel the reservation assuming we are too busy to come together this year, and we'll try again in 2020!</p>

                @if ($user->rsvp->has_paid < $user->rsvp->getSplit())
                    <p>You can use the button to show a rough split of the housing cost based on your reservation.</p>
                @endif

                <p>Covering a share guarantees your space for the dates of your rsvp, but no financial contribution is necessary. All are welcome, space allowing, as your time is the most precious contribution you could make. You are also welcome to pay more than your split if you're having a good year and would like to facilitate more loved ones joining us.</p>

                <p>Contribute via
                    <a href="https://www.paypal.me/deadlugosi" target="_blank">paypal</a>,
                    <a href="https://venmo.com/Margaret-Staples-1" target="_blank">venmo</a>,
                    write me a check, hand me a stack of sweaty bills, whatever is easiest, but please report it here or remind me to do it.</p>

                <p>Here's hoping to see you this year
                    <i class="pro icon fa-universal-access"></i>
                    <i class="pro icon fa-home-heart"></i>
                    <i class="pro icon fa-fireplace"></i>
                </p>
                @if ($user->rsvp->has_paid > $user->rsvp->getSplit())
                    <div class="success">
                        <p>{{ $user->rsvp->getContributionMessage() }}</p>
                    </div>
                @else
                    <div class="col-12" id="calculate_split">
                        <button id="split_button" class="small">Calculate Split?</button>
                    </div>
                    <div class="col-12" id="display_split" style="display: none;">
                        split share = ${{ money_format('%i', $user->rsvp->getSplit()) }}
                    </div>
                @endif
            </div>

            <form action="{{ route('contribute') }}" method="post">
                <div class="col-12">
                    Reported Contribution:
                        <input type="text"
                               name="contribution"
                               value="{{ $user->rsvp->has_paid }}" />
                </div>
                <div class="col-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="submit"
                        @if ($user->rsvp->has_paid > 0)
                            value="Update"
                        @else
                            value="Save"
                        @endif
                    />
                </div>
            </form>
        </div>
    </div>
</form>