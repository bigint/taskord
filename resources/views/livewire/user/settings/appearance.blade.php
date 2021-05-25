<div class="col-lg-8">
    <div class="card">
        <div class="card-header py-3">
            <span class="h5">Theme preferences</span>
            <div>Choose how Taskord looks to you.</div>
        </div>
        <div class="card-body d-flex">
            <div class="me-3 card {{ $user->dark_mode ? '' : 'border-primary'  }}">
                <img class="rounded-top" src="https://ik.imagekit.io/taskordimg/light_preview_vbmoVL43E.svg" />
                <div class="card-footer">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lightMode" id="lightMode" wire:click="toggleMode('light')" {{ $user->dark_mode ? '' : 'checked'  }}>
                        <label class="form-check-label fw-bold" for="lightMode">
                            Default light
                        </label>
                    </div>
                </div>
            </div>
            <div class="card {{ $user->dark_mode ? 'border-primary' : ''  }}">
                <img class="rounded-top" src="https://ik.imagekit.io/taskordimg/dark_preview_9AcAIKv8K.svg" />
                <div class="card-footer">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="darkMode" id="darkMode" wire:click="toggleMode('dark')" {{ $user->dark_mode ? 'checked' : ''  }}>
                        <label class="form-check-label fw-bold" for="darkMode">
                            Default dark
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
