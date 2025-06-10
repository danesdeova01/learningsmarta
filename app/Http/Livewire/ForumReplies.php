<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ForumReply;

class ForumReplies extends Component
{
    public $forumId;
    public $newReply = '';

    protected $rules = [
        'newReply' => 'required|string|max:1000',
    ];

    protected $listeners = ['replyAdded' => '$refresh'];

    public function mount($forumId)
    {
        $this->forumId = $forumId;
    }

    public function submitReply()
    {
        $this->validate();

        ForumReply::create([
            'forum_id' => $this->forumId,
            'user_id' => auth()->id(),
            'konten' => $this->newReply,
        ]);

        $this->newReply = '';

        $this->emit('replyAdded');
    }

    public function render()
    {
        $replies = ForumReply::with('user')
            ->where('forum_id', $this->forumId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.forum-replies', compact('replies'));
    }
}
