<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $source = $request->query('source', 'all');
        $search = $request->query('q');

        $query = Comment::with(['news', 'saktiContent'])->latest();

        if ($status === 'pending') {
            $query->pending();
        } elseif ($status === 'approved') {
            $query->approved();
        }

        if ($source === 'news') {
            $query->whereNotNull('news_id');
        } elseif ($source === 'sakti') {
            $query->whereNotNull('sakti_content_id');
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%")
                    ->orWhereHas('news', function ($newsQuery) use ($search) {
                        $newsQuery->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('saktiContent', function ($saktiQuery) use ($search) {
                        $saktiQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $comments = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => Comment::count(),
            'pending' => Comment::pending()->count(),
            'approved' => Comment::approved()->count(),
            'news' => Comment::whereNotNull('news_id')->count(),
            'sakti' => Comment::whereNotNull('sakti_content_id')->count(),
        ];

        return view('admin.comments.index', compact('comments', 'status', 'source', 'search', 'counts'));
    }

    public function toggleApprove($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = ! $comment->is_approved;
        $comment->save();

        $statusText = $comment->is_approved ? 'disetujui dan kini tayang di website' : 'dibatalkan persetujuannya dan disembunyikan';

        return redirect()->back()->with('success', "Komentar berhasil {$statusText}.");
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus secara permanen.');
    }
}
