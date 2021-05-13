<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->id . '-' . $this->slug,    // URL
            'votes_count'      => $this->votes_count,
            'answers_count'    => $this->answers_count,
            'views'            => $this->views,
            'status'           => $this->status,
            'excerpt'          => $this->excerpt,
            'created_date'     => $this->created_date,
            'user'             => new UserResource($this->user)
            // ユーザーの必要な情報だけを取得するためUserResourceを使用
        ];
    }
}

// API Resource は JSONレスポンスを返すときにJSONのdataを成形する物