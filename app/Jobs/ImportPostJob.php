<?php

namespace App\Jobs;

use App\Models\User;
use Botble\Blog\Models\Post;
use Botble\Slug\Models\Slug;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post;
    private $authors;
    private $key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $authors, $key)
    {
        $this->post = $post;
        $this->authors = $authors;
        $this->key = $key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $post_url = "https://www.gochange.it/business/esplorando-i-lavori-nel-settore-digitale/" . $this->post['ID'];
        $image_name = null;
        if (Str::startsWith($this->post['post_mime_type'], 'image') && $this->file_contents_exist($post_url)) {
            $fp = file_get_contents($post_url);
            $tags = [];
            preg_match_all('/<img.+?class=".*?attachment-single-thumb size-single-thumb wp-post-image.*?"/', $fp, $tags);
            $url = collect($tags)->flatten()->map(function ($item) {
                preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $item, $images);
                return array_pop($images);
            })->filter(function ($item) {
                return filter_var($item, FILTER_VALIDATE_URL);
            })->last();
            if ($url && $this->file_contents_exist($url)) {
                $image_name = uniqid() . time() . '.' . pathinfo($this->post['guid'], PATHINFO_EXTENSION);
                file_put_contents(storage_path('app/public/' . $image_name), file_get_contents($url));
            }
        }
        $post = Post::query()->updateOrCreate(
            [
                'u_id' => $this->post['ID'],
            ]
            ,
            [
                'u_id' => $this->post['ID'],
                'name' => $this->post['post_title'],
                'content' => $this->post['post_content'],
                'image' => $image_name,
                'author_id' => User::query()->where('email', $this->authors[$this->post['post_author']])->first()->id,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->post['post_date']),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->post['post_date']),
            ]
        );
        /*Slug::query()->create([
            'key' => $this->key,
            'reference_id' => $post->id,
            'reference_type' => $post->getMorphClass(),
            'prefix' => ""
        ]);*/
    }

    function file_contents_exist($url, $response_code = 200)
    {
        $headers = get_headers($url);

        if (substr($headers[0], 9, 3) == $response_code) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
