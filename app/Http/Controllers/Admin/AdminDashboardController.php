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

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'sakti_count' => SaktiContent::count(),
            'executives_count' => Executive::count(),
            'galleries_count' => Gallery::count(),
            'news_count' => News::count(),
            'messages_count' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'comments_count' => Comment::count(),
            'pending_comments' => Comment::pending()->count(),
            'submissions_count' => ContentSubmission::count(),
            'pending_submissions' => ContentSubmission::pending()->count(),
        ];

        $recent_messages = ContactMessage::latest()->take(5)->get();
        $recent_sakti = SaktiContent::latest()->take(5)->get();
        $recent_comments = Comment::with('news')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_messages', 'recent_sakti', 'recent_comments'));
    }
}
