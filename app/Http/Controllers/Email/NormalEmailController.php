<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Jobs\NormalEmailJob;
use App\Models\Email;
use Botble\ACL\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class NormalEmailController extends Controller
{
    public function index()
    {
        return view('emails.normal.index');
    }

    public function create()
    {
        $emails = User::query()->with(['roles:name'])->select(['id', 'email'])->get()->map(function ($item) {
            $item->role = $item->roles->pluck('name')->first() ?? "default";
            return $item;
        })->groupBy('role')->toArray();
        return view('emails.normal.create', compact('emails'));
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
            'emails.*.*' => ['email', 'exists:' . User::class . ',email'],
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
                    'mailer' => "smtp",
                ]);
                $email_obj->users()->attach(collect($request->emails)->map(function ($email) {
                    return optional(User::query()->select(['id'])->where('email', $email)->first())->id;
                })->filter(function ($item) {
                    return strlen($item);
                })->toArray());
                foreach ($request->emails as $email) {
                    NormalEmailJob::dispatch($email, $request->all());
                }
                return redirect()->route('admin.emails.normal.index');
            });
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back();
        }
    }
}
