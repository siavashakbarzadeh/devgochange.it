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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post,$authors)
    {
        $this->post = $post;
        $this->authors = $authors;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*$image_name = null;
        if (Str::startsWith($this->post['post_mime_type'], 'image') && $this->file_contents_exist($this->post['guid'])) {
            $image_name = uniqid() . time() . '.' . pathinfo($this->post['guid'], PATHINFO_EXTENSION);
            file_put_contents(storage_path('app/public/' . $image_name),file_get_contents($this->post['guid']) );
        }*/
        $post = Post::query()->updateOrCreate(
            [
                'u_id' => $this->post['ID'],
            ]
            ,
            [
                'u_id' => $this->post['ID'],
                'name' => $this->post['post_title'],
                'content' => $this->post['post_content'],
//                'image' => $image_name,
                'author_id' => User::query()->where('email', $this->authors[$this->post['post_author']])->first()->id,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->post['post_date']),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->post['post_date']),
            ]
        );
        Slug::query()->create([
            'key' => time(),
            'reference_id' => $post->id,
            'reference_type' => $post->getMorphClass(),
            'prefix' => ""
        ]);
    }

    function file_contents_exist($url, $response_code = 200)
    {
        $headers = get_headers($url);

        if (substr($headers[0], 9, 3) == $response_code)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
