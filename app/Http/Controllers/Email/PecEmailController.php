<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Jobs\PecEmailJob;
use App\Mail\TestMail;
use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PecEmailController extends Controller
{
    public function index()
    {
        return view('emails.pec.index');
    }

    public function create()
    {
        $emails = User::query()->pluck('email');
        return view('emails.pec.create', compact('emails'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'emails' => ['required', 'array', 'min:1'],
            'emails.' => ['email', 'exists:' . User::class . ',email'],
            'subject' => ['nullable', 'string'],
            'reply_to' => ['nullable', 'string'],
            'body' => ['required', 'string'],
        ]);
        try {
            return DB::transaction(function () use ($request) {
                /** @var Email $email_obj */
                $email_obj = Email::query()->create([
                    'user_id' => $request->user()->id,
                    'subject' => $request->subject,
                    'reply_to' => $request->reply_to,
                    'body' => $request->body,
                    'mailer' => "smtp_pec",
                ]);
                $email_obj->users()->attach(collect($request->emails)->map(function ($email) {
                    return optional(User::query()->select(['id'])->where('email', $email)->first())->id;
                })->filter(function ($item) {
                    return strlen($item);
                })->toArray());
                foreach ($request->emails as $email) {
                    PecEmailJob::dispatch($email, $request->all());
                }
                return redirect()->route('admin.emails.pec.index');
            });
        } catch (Throwable $e) {
            return redirect()->back();
        }
    }
}
