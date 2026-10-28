<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\ContentSubmission;
use App\Models\Executive;
use App\Models\Gallery;
use App\Models\News;
use App\Models\SaktiContent;
use Illuminate\Database\QueryException;

class AdminDashboardController extends Controller
{
    public function index()
    {
        try {
            $commentsCount = Comment::count();
            $pendingComments = Comment::pending()->count();
            $recentComments = Comment::with('news')->latest()->take(5)->get();
        } catch (QueryException) {
            $commentsCount = 0;
            $pendingComments = 0;
            $recentComments = collect();
        }

        try {
            $submissionsCount = ContentSubmission::count();
            $pendingSubmissions = ContentSubmission::pending()->count();
        } catch (QueryException) {
            $submissionsCount = 0;
            $pendingSubmissions = 0;
        }

        $stats = [
            'sakti_count' => SaktiContent::count(),
            'executives_count' => Executive::count(),
            'galleries_count' => Gallery::count(),
            'news_count' => News::count(),
            'messages_count' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'comments_count' => $commentsCount,
            'pending_comments' => $pendingComments,
            'submissions_count' => $submissionsCount,
            'pending_submissions' => $pendingSubmissions,
        ];

        $recent_messages = ContactMessage::latest()->take(5)->get();
        $recent_sakti = SaktiContent::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_messages', 'recent_sakti', 'recent_comments'));
    }
}
