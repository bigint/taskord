<div class="col-md-8">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Notifications</span>
            <div>Choose how you receive notifications.</div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Mentions</div>
                <span class="small">Notifications for the tasks, questions and comment if someone cites you with an @mention.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="mentionsEmail" id="mentionsEmail" class="form-check-input" type="checkbox" {{ $user->taskMentionedEmail ? 'checked' : '' }}>
                        <label for="mentionsEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="mentionsWeb" id="mentionsWeb" class="form-check-input" type="checkbox" {{ $user->taskMentionedWeb ? 'checked' : '' }}>
                        <label for="mentionsWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="mentionsEmail, mentionsWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Task Praise</div>
                <span class="small">Notifications for the tasks if someone praised it.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="taskPraisedEmail" id="taskPraisedEmail" class="form-check-input" type="checkbox" {{ $user->taskPraisedEmail ? 'checked' : '' }}>
                        <label for="taskPraisedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="taskPraisedWeb" id="taskPraisedWeb" class="form-check-input" type="checkbox" {{ $user->taskPraisedWeb ? 'checked' : '' }}>
                        <label for="taskPraisedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="taskPraisedEmail, taskPraisedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Comment Praise</div>
                <span class="small">Notifications for the comments if someone praised it.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="commentPraisedEmail" id="commentPraisedEmail" class="form-check-input" type="checkbox" {{ $user->commentPraisedEmail ? 'checked' : '' }}>
                        <label for="commentPraisedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="commentPraisedWeb" id="commentPraisedWeb" class="form-check-input" type="checkbox" {{ $user->commentPraisedWeb ? 'checked' : '' }}>
                        <label for="commentPraisedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="commentPraisedEmail, commentPraisedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Question Praise</div>
                <span class="small">Notifications for the questions if someone praised it.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="questionPraisedEmail" id="questionPraisedEmail" class="form-check-input" type="checkbox" {{ $user->questionPraisedEmail ? 'checked' : '' }}>
                        <label for="questionPraisedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="questionPraisedWeb" id="questionPraisedWeb" class="form-check-input" type="checkbox" {{ $user->questionPraisedWeb ? 'checked' : '' }}>
                        <label for="questionPraisedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="questionPraisedEmail, questionPraisedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Answer Praise</div>
                <span class="small">Notifications for the answers if someone praised it.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="answerPraisedEmail" id="answerPraisedEmail" class="form-check-input" type="checkbox" {{ $user->answerPraisedEmail ? 'checked' : '' }}>
                        <label for="answerPraisedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="answerPraisedWeb" id="answerPraisedWeb" class="form-check-input" type="checkbox" {{ $user->answerPraisedWeb ? 'checked' : '' }}>
                        <label for="answerPraisedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="answerPraisedEmail, answerPraisedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Task Comments</div>
                <span class="small">Notifications for the tasks if someone commented.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="commentAddedEmail" id="commentAddedEmail" class="form-check-input" type="checkbox" {{ $user->commentAddedEmail ? 'checked' : '' }}>
                        <label for="commentAddedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="commentAddedWeb" id="commentAddedWeb" class="form-check-input" type="checkbox" {{ $user->commentAddedWeb ? 'checked' : '' }}>
                        <label for="commentAddedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="commentAddedEmail, commentAddedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Question Answers</div>
                <span class="small">Notifications for the questions if someone answered.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="answerAddedEmail" id="answerAddedEmail" class="form-check-input" type="checkbox" {{ $user->answerAddedEmail ? 'checked' : '' }}>
                        <label for="answerAddedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="answerAddedWeb" id="answerAddedWeb" class="form-check-input" type="checkbox" {{ $user->answerAddedWeb ? 'checked' : '' }}>
                        <label for="answerAddedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="answerAddedEmail, answerAddedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">User Follows</div>
                <span class="small">Notifications for the user if someone follows.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="userFollowedEmail" id="userFollowedEmail" class="form-check-input" type="checkbox" {{ $user->userFollowedEmail ? 'checked' : '' }}>
                        <label for="userFollowedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="userFollowedWeb" id="userFollowedWeb" class="form-check-input" type="checkbox" {{ $user->userFollowedWeb ? 'checked' : '' }}>
                        <label for="userFollowedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="userFollowedEmail, userFollowedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Product Subscribes</div>
                <span class="small">Notifications for the products if someone subscribes.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="productSubscribedEmail" id="productSubscribedEmail" class="form-check-input" type="checkbox" {{ $user->productSubscribedEmail ? 'checked' : '' }}>
                        <label for="productSubscribedEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="productSubscribedWeb" id="productSubscribedWeb" class="form-check-input" type="checkbox" {{ $user->productSubscribedWeb ? 'checked' : '' }}>
                        <label for="productSubscribedWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="productSubscribedEmail, productSubscribedWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
            <li class="list-group-item pt-3 pb-3">
                <div class="h5">Product Updates</div>
                <span class="small">Notifications for the product updates for the product you subscribed.</span>
                <div class="mt-3">
                    <span>
                        <input wire:click="productUpdatesEmail" id="productUpdatesEmail" class="form-check-input" type="checkbox" {{ $user->productUpdatesEmail ? 'checked' : '' }}>
                        <label for="productUpdatesEmail" class="ml-1">Email</label>
                    </span>
                    <span class="ml-4">
                        <input wire:click="productUpdatesWeb" id="productUpdatesWeb" class="form-check-input" type="checkbox" {{ $user->productUpdatesWeb ? 'checked' : '' }}>
                        <label for="productUpdatesWeb" class="ml-1">Web</label>
                        <span wire:loading wire:target="productUpdatesEmail, productUpdatesWeb" class="small ml-2 text-success font-weight-bold">Updating...</span>
                    </span>
                </div>
            </li>
        </ul>
    </div>
</div>
