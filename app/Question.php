<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use parsedown;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = ['title', 'body'];

    // Question.vueでcreated_dateを使用
    // Favorite.vueで'is_favorited', favorites_countを使用
    protected $appends = ['created_date', 'is_favorited', 'favorites_count', 'body_html'];

    public function user() {
        return $this->belongsTo(User::class);   // questionのuser_idをuserのid
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // public function setBodyAttribute($value)
    // {
    //     $this->attributes['body'] = clean($value);
    // }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        // diffForHumans()は公開日時経過時間表示
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        // answersカラムがanswers_countにネーム変更
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function answers()   // hasManyは主キーから外部キーへつなぐ
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');   // グッドが多い順
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites() //belongsは外部キーから主キーへつなぐ
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); // , 'questoin_id', 'user_id');
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        // HTML タグおよび PHP タグを除去する strip_tags
        return Str::limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
