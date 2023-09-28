<?php

namespace App\Jobs;

use App\Models\User;
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
        $image_name = null;
        if (Str::startsWith($this->post['post_mime_type'], 'image')) {
            $image_name = uniqid() . time() . '.' . pathinfo($this->post['guid'], PATHINFO_EXTENSION);
            file_put_contents(storage_path('app/public/' . $image_name), file_get_contents($this->post['guid']));
        }
        $row = DB::connection('mysql')->table('posts')->updateOrInsert(
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
    }
}
