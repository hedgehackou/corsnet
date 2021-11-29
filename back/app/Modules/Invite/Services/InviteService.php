<?php

declare(strict_types=1);

namespace App\Modules\Invite\Services;

use App\Base\Services\AbstractService;
use App\Models\User;
use App\Modules\Invite\Mail\InviteMail;
use App\Modules\Invite\Models\Invite;
use App\Modules\Invite\Repositories\InviteRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class InviteService extends AbstractService
{
    private InviteRepository $inviteRepository;

    /**
     * @param InviteRepository $inviteRepository
     */
    public function __construct(InviteRepository $inviteRepository)
    {
        $this->inviteRepository = $inviteRepository;
    }

    /***
     * @param array $data
     *
     * @return Invite
     */
    public function createInvite(array $data): Invite
    {
        $token = Uuid::uuid4();

        /** @var Invite $invite */
        $invite = Invite::create([
            'email' => $data['email'],
            'token' => $token,
            'is_admin' => $data['role'] === 'admin',
            'is_accepted' => false,
        ]);

        $url = rtrim(env('APP_URL'), '/') . route('invite.accept', [
                'token' => $token,
                'email' => $data['email'],
            ], false);

        Mail::to($data['email'])->send(new InviteMail($url));


        return $invite;
    }

    /**
     * @param int $inviteId
     */
    public function deleteInvite(int $inviteId)
    {
        /** @var Invite $invite */
        $invite = Invite::findOrFail($inviteId);
        $invite->delete();
    }

    /**
     * @param array $data
     */
    public function acceptInvite(array $data)
    {
        /** @var Invite $invite */
        $invite = Invite::query()
            ->where('token', $data['token'])
            ->where('is_accepted', false)
            ->firstOrFail();

        DB::transaction(function () use ($invite, $data) {
            User::create([
                'email' => $invite->email,
                'name' => $data['name'],
                'is_admin' => $invite->is_admin,
                'password' => Hash::make($data['password'])
            ]);
            $invite->is_accepted = true;
            $invite->save();
        });
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getInviteList(): LengthAwarePaginator
    {
        return $this->inviteRepository
            ->getInviteList()
            ->paginate($this->getPerPage(), ['*'], $this->getPageName(), $this->getPage());
    }
}
