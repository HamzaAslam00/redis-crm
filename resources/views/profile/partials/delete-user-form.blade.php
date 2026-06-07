<div x-data="{ deleteOpen: false }">

    <p style="font-size:0.85rem;color:var(--crm-text-muted);margin:0 0 1.25rem;line-height:1.7;max-width:560px">
        Once your account is deleted, all of its data will be permanently removed. Please make sure you have backed up anything you need before proceeding.
    </p>

    <button @click="deleteOpen = true" class="btn btn-danger">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
        Delete My Account
    </button>

    {{-- Confirmation modal --}}
    <template x-teleport="body">
        <div x-show="deleteOpen" x-transition.opacity.duration.200ms
            class="modal-overlay" style="display:none" @click.self="deleteOpen = false">
            <div class="modal-box" @click.stop x-transition.scale.duration.200ms>
                <div class="modal-header">
                    <h4>Delete Account</h4>
                    <button @click="deleteOpen = false" style="background:none;border:none;cursor:pointer;color:var(--crm-text-muted);padding:0.25rem;border-radius:6px;display:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="modal-body">
                    <p style="font-size:0.875rem;color:var(--crm-text-muted);margin:0 0 1.25rem;line-height:1.7">
                        Are you sure you want to permanently delete your account? This action <strong style="color:var(--crm-text)">cannot be undone</strong>. Please enter your password to confirm.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" id="delete-account-form">
                        @csrf
                        @method('delete')

                        <div class="form-group">
                            <label class="form-label" for="del_password">Your Password</label>
                            <input id="del_password" name="password" type="password"
                                class="form-control {{ $errors->userDeletion->get('password') ? 'is-invalid' : '' }}"
                                placeholder="Enter your password to confirm">
                            @foreach($errors->userDeletion->get('password') as $error)
                                <div class="form-error">{{ $error }}</div>
                            @endforeach
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button @click="deleteOpen = false" class="btn btn-secondary">Cancel</button>
                    <button type="submit" form="delete-account-form" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        Yes, Delete Account
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>
