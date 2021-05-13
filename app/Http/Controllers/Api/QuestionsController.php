<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 質問を表示する
    // Postman [ GET Displau all Questions ]
    
    public function index()
    {
        // Question.php
        // view表示のためにEloquentでデータベースからwithでレコード指定して表示|latest()で降順
        $questions = Question::with('user')->latest()->paginate(5);

        return QuestionResource::collection($questions);

        // QuestionResource は JSONレスポンスを返すときにJSONのdataを成形する物
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // 新しい質問を追加するためのAPIエンドポイント
    // Postman [ POST Create Question ]
    
    public function store(AskQuestionRequest $request)
    {
        $question = $request->user()->questions()->create($request->only('title', 'body'));

        return response()->json([
            'message' => "Your questionshas been submitted",
            'question' => new QuestionResource($question)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */

    // Postman [ GET Show Question ]

    public function show(question $question)
    {
        return response()->json([
            'title'     => $question->title,
            'body'      => $question->body,
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */

    // 質問を更新するためのAPIエンドポイント
    // Postman [ PUT Update Question ]

    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update", $question);

        $question->update($request->only('title', 'body'));

        return response()->json([
            'message' => "Your question has been updated",
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */

    // 質問を削除するためのAPIエンドポイント
    // Postman [ DELETE Delete Question ]
    
    public function destroy(Question $question)
    {
        $this->authorize("delete", $question);

        $question->delete();

        return response()->json([
            'message' => "Your question has been deleted."
        ]);
    }
}