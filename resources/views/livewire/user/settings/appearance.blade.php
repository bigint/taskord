<div class="col-lg-8">
    <div class="card">
        <div class="card-header py-3">
            <span class="h5">Theme preferences</span>
            <div>Choose how Taskord looks to you.</div>
        </div>
        <div class="card-body d-flex">
            <div class="cursor-pointer me-3 card {{ Cookie::get('color_mode') === 'light' ? 'border-primary' : '' }}"
                wire:click="toggleMode('light')">
                <img class="rounded-top" src="https://ik.imagekit.io/taskordimg/light_preview_vbmoVL43E.svg" />
                <div class="card-footer">
                    <div class="fw-bold">
                        Default light
                    </div>
                </div>
            </div>
            <div class="cursor-pointer me-3 card {{ Cookie::get('color_mode') === 'dark' ? 'border-primary' : '' }}"
                wire:click="toggleMode('dark')">
                <img class="rounded-top" src="https://ik.imagekit.io/taskordimg/dark_preview_9AcAIKv8K.svg" />
                <div class="card-footer">
                    <div class="fw-bold">
                        Default dark
                    </div>
                </div>
            </div>
            <div class="cursor-pointer card {{ Cookie::get('color_mode') === 'auto' ? 'border-primary' : '' }}"
                wire:click="toggleMode('auto')">
                <img class="rounded-top" src="https://ik.imagekit.io/taskordimg/auto_preview_ucGhJPhO-.svg" />
                <div class="card-footer">
                    <div class="fw-bold">
                        System
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
