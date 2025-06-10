<div>
    <div wire:poll.5s id="replies-container" style="max-height: 400px; overflow-y: auto;">
        @foreach ($replies as $reply)
            <div wire:key="reply-{{ $reply->id }}" class="mb-3 border rounded p-3">
                <strong>{{ $reply->user->name }}</strong>
                <small class="text-muted float-right">{{ $reply->created_at->diffForHumans() }}</small>
                <p class="mt-2">{!! nl2br(e($reply->konten)) !!}</p>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="submitReply" class="mt-3">
        <textarea wire:model.defer="newReply" class="form-control" rows="3" placeholder="Tulis balasan..." required></textarea>
        @error('newReply') <span class="text-danger">{{ $message }}</span> @enderror
        <button type="submit" class="btn btn-primary mt-2">Kirim Balasan</button>
    </form>
</div>
