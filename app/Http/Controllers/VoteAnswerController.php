<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class VoteAnswerController extends Controller
{
    public function __construct()
    // コントローラー全体にミドルウェアを指定
    {
        $this->middleware('auth');  // ログイン認証をかける
    }

    public function __invoke(Answer $answer)
    {
        $vote = (int) request()->vote;

        $votesCount = auth()->user()->voteAnswer($answer, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => '投票済み',
                'votesCount' => $votesCount
            ]);
        }

        return back();  // ページリロード
    }
}