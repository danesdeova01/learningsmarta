<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        return view('admin.forum.index', [
            'menuActive' => 'forum', // Kirim variabel $menuActive
            'forums' => $forums,
        ]);
    }

    public function create()
    {
        return view('admin.forum.form', [
            'menuActive' => 'forum', // Kirim variabel $menuActive
            'isEdit' => false,
            'url' => url('admin/forum'),
        ]);
    }

    public function store(Request $request)
    {
        Forum::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'user_id' => auth()->id(),
        ]);
        Alert::success('Berhasil', 'Topik diskusi berhasil ditambahkan');
        return redirect('admin/forum');
    }

    public function show($id)
    {
        $forum = Forum::with(['user', 'replies.user'])->findOrFail($id);
        return view('admin.forum.detail', compact('forum'));
    }
    
    public function destroy($id)
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        Alert::success('Berhasil', 'Topik diskusi berhasil dihapus');
        return redirect()->route('admin.forum.index');
    }
}
