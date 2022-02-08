<?php

declare(strict_types=1);

namespace App\Modules\Invite\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Invite\Repositories\InviteRepository;
use App\Modules\Invite\Requests\AcceptInviteRequest;
use App\Modules\Invite\Requests\CreateInviteRequest;
use App\Modules\Invite\Requests\DeleteInviteRequest;
use App\Modules\Invite\Requests\GetInviteInfoRequest;
use App\Modules\Invite\Requests\VerifyEmailRequest;
use App\Modules\Invite\Resources\InviteInfoResource;
use App\Modules\Invite\Resources\InviteListResource;
use App\Modules\Invite\Services\InviteService;
use Illuminate\Http\JsonResponse;

class InviteController extends AbstractController
{
    private InviteService $inviteService;
    private InviteRepository $inviteRepository;

    /**
     * @param InviteService    $inviteService
     * @param InviteRepository $inviteRepository
     */
    public function __construct(
        InviteService $inviteService,
        InviteRepository $inviteRepository
    ) {
        $this->inviteService = $inviteService;
        $this->inviteRepository = $inviteRepository;
    }

    /**
     * @param CreateInviteRequest $request
     *
     * @return JsonResponse
     */
    public function createInvite(CreateInviteRequest $request): JsonResponse
    {
        $this->inviteService->createInvite($request->validated());

        return response()->json();
    }

    public function getInviteList(): JsonResponse
    {
        $list = $this->inviteService->getInviteList();

        return response()->json([
            'current_page' => $list->currentPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
            'list' => InviteListResource::collection($list),
        ]);
    }

    /**
     * @param AcceptInviteRequest $request
     *
     * @return JsonResponse
     */
    public function acceptInvite(AcceptInviteRequest $request): JsonResponse
    {
        $this->inviteService->acceptInvite($request->validated());

        return response()->json();
    }

    /**
     * @param GetInviteInfoRequest $request
     *
     * @return InviteInfoResource
     */
    public function getInviteInfo(GetInviteInfoRequest $request): InviteInfoResource
    {
        $invite = $this->inviteRepository->getInviteByToken($request->route('token'));

        return new InviteInfoResource($invite);
    }

    /**
     * @param VerifyEmailRequest $request
     * @param string             $token
     *
     * @return JsonResponse
     */
    public function verifyEmail(VerifyEmailRequest $request, string $token): JsonResponse
    {
        $this->inviteService->verifyEmail($token);

        return response()->json();
    }

    /**
     * @param DeleteInviteRequest $request
     * @param int                 $inviteId
     *
     * @return JsonResponse
     */
    public function deleteInvite(DeleteInviteRequest $request, int $inviteId): JsonResponse
    {
        $this->inviteService->deleteInvite($inviteId);

        return response()->json([], 204);
    }
}
