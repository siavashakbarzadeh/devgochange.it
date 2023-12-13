<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Jobs\PecEmailJob;
use App\Mail\TestMail;
use App\Models\Email;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PecEmailController extends Controller
{
    public function index()
    {
        $emails = Email::all();
        return view('emails.pec.index', compact('emails'));

    }

    public function create()
    {
        $emails = \Botble\ACL\Models\User::query()->with(['roles:name'])->select(['id', 'email'])->get()->map(function ($item) {
            $item->role = $item->roles->pluck('name')->first() ?? "default";
            return $item;
        })->groupBy('role')->toArray();
        return view('emails.pec.create', compact('emails'));
    }

    public function store(Request $request)
    {
        if ($request->filled('emails')) {
            $request->merge([
                'emails' => collect($request->emails)->mapWithKeys(function ($item, $key) {
                    return [$key => array_filter($item, 'strlen')];
                })->toArray(),
            ]);
        }
        $this->validate($request, [
            'emails' => ['required', 'array', 'min:1'],
            'emails.*' => ['nullable', 'array'],
            'emails.*.*' => ['email', 'exists:' . \Botble\ACL\Models\User::class . ',email'],
            'subject' => ['nullable', 'string'],
            'reply_to' => ['nullable', 'string'],
            'body' => ['required', 'string'],
        ]);
        $request->merge([
            'emails' => collect($request->emails)->flatten()->toArray(),
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
