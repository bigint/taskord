<div class="card-header pt-3 pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="h5">Meetups</div>
                    <div>Meet and greet.</div>
                </div>
                <div>
                    <a class="btn btn-outline-success">
                        RSVPd
                    </a>
                    <a class="btn btn-outline-primary">
                        Upcoming
                    </a>
                    <a class="btn btn-outline-primary">
                        Finished
                    </a>
                    @auth
                    <button class="btn btn-success text-white" data-toggle="modal" data-target="#newMeetupModal">
                        <i class="fa fa-plus mr-1"></i>
                        New Meetup
                    </button>
                    @livewire('meetup.new-meetup')
                    @endauth
                </div>
            </div>
        </div>